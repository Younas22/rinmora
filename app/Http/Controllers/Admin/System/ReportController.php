<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Catalog\InventoryMovement;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use App\Models\Sales\Order;
use App\Models\Sales\OrderItem;
use App\Models\Sales\Payment;
use App\Models\Sales\Refund;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    protected const DATE_RANGES = ['this_month', 'last_month', 'last_7_days', 'last_30_days', 'this_year', 'custom'];

    protected const BUILT_REPORT_TYPES = ['sales', 'products', 'customers', 'orders', 'revenue', 'inventory'];

    protected function resolveDateRange(Request $request): array
    {
        $range = $request->get('range', 'this_month');
        if (!in_array($range, self::DATE_RANGES, true)) {
            $range = 'this_month';
        }

        $today = Carbon::today();

        if ($range === 'custom') {
            $from = $request->get('from');
            $to = $request->get('to');

            if ($from && $to && strtotime($from) && strtotime($to)) {
                $start = Carbon::parse($from)->startOfDay();
                $end = Carbon::parse($to)->endOfDay();
                if ($start->gt($end)) {
                    [$start, $end] = [$end->copy()->startOfDay(), $start->copy()->endOfDay()];
                }
            } else {
                $range = 'this_month';
            }
        }

        if ($range !== 'custom') {
            [$start, $end] = match ($range) {
                'last_month' => [$today->copy()->subMonthNoOverflow()->startOfMonth(), $today->copy()->subMonthNoOverflow()->endOfMonth()],
                'last_7_days' => [$today->copy()->subDays(6)->startOfDay(), $today->copy()->endOfDay()],
                'last_30_days' => [$today->copy()->subDays(29)->startOfDay(), $today->copy()->endOfDay()],
                'this_year' => [$today->copy()->startOfYear(), $today->copy()->endOfDay()],
                default => [$today->copy()->startOfMonth(), $today->copy()->endOfDay()],
            };
        }

        // Comparison window: the immediately preceding period of equal length,
        // so "+X% vs last period" means the same thing for every range option.
        $days = $start->diffInDays($end) + 1;
        $prevEnd = $start->copy()->subDay()->endOfDay();
        $prevStart = $prevEnd->copy()->subDays($days - 1)->startOfDay();

        return [$start, $end, $prevStart, $prevEnd, $range];
    }

    protected function pctChange($current, $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100.0 : 0.0;
        }

        return round(($current - $previous) / $previous * 100, 1);
    }

    /**
     * Count per calendar week for the last 4 weeks (trailing trend, independent
     * of the selected report date-range — same convention as the Sales tab's
     * existing Weekly Order Volume chart).
     */
    protected function weeklyTrend(callable $countForWindow): array
    {
        $weeks = collect(range(3, 0))->map(function ($weeksAgo) use ($countForWindow) {
            $weekStart = Carbon::now()->subWeeks($weeksAgo)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($weeksAgo)->endOfWeek();

            return [
                'label' => 'Wk '.(4 - $weeksAgo),
                'count' => $countForWindow($weekStart, $weekEnd),
            ];
        });

        return [$weeks, max(1, $weeks->max('count'))];
    }

    public function index(Request $request)
    {
        $reportType = $request->get('type', 'sales');
        [$start, $end, $prevStart, $prevEnd, $dateRange] = $this->resolveDateRange($request);

        $data = in_array($reportType, self::BUILT_REPORT_TYPES, true)
            ? match ($reportType) {
                'products' => $this->buildProductsReport($start, $end),
                'customers' => $this->buildCustomersReport($start, $end, $prevStart, $prevEnd),
                'orders' => $this->buildOrdersReport($start, $end),
                'revenue' => $this->buildRevenueReport($start, $end, $prevStart, $prevEnd),
                'inventory' => $this->buildInventoryReport($start, $end),
                default => $this->buildSalesReport($start, $end, $prevStart, $prevEnd),
            }
            : [];

        return view('admin.system.reports.index', array_merge(
            compact('reportType', 'dateRange', 'start', 'end'),
            $data
        ));
    }

    protected function buildSalesReport($start, $end, $prevStart, $prevEnd): array
    {
        $totalRevenue = (float) Order::whereBetween('created_at', [$start, $end])->sum('total');
        $totalOrders = Order::whereBetween('created_at', [$start, $end])->count();
        $aov = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;
        $totalRefunds = (float) Refund::whereBetween('created_at', [$start, $end])->sum('amount');
        $refundRate = $totalRevenue > 0 ? round($totalRefunds / $totalRevenue * 100, 1) : 0;

        $prevRevenue = (float) Order::whereBetween('created_at', [$prevStart, $prevEnd])->sum('total');
        $prevOrders = Order::whereBetween('created_at', [$prevStart, $prevEnd])->count();
        $prevAov = $prevOrders > 0 ? $prevRevenue / $prevOrders : 0;
        $prevRefunds = (float) Refund::whereBetween('created_at', [$prevStart, $prevEnd])->sum('amount');
        $prevRefundRate = $prevRevenue > 0 ? round($prevRefunds / $prevRevenue * 100, 1) : 0;

        $kpis = [
            'revenue' => ['value' => $totalRevenue, 'change' => $this->pctChange($totalRevenue, $prevRevenue), 'prev' => $prevRevenue],
            'orders' => ['value' => $totalOrders, 'change' => $this->pctChange($totalOrders, $prevOrders), 'prev' => $prevOrders],
            'aov' => ['value' => $aov, 'change' => $this->pctChange($aov, $prevAov), 'prev' => $prevAov],
            'refund_rate' => ['value' => $refundRate, 'change' => round($refundRate - $prevRefundRate, 1), 'prev' => $prevRefundRate],
        ];

        $revenueByCategory = OrderItem::join('sales_orders', 'sales_order_items.order_id', '=', 'sales_orders.id')
            ->join('catalog_products', 'sales_order_items.product_id', '=', 'catalog_products.id')
            ->join('catalog_categories', 'catalog_products.category_id', '=', 'catalog_categories.id')
            ->whereBetween('sales_orders.created_at', [$start, $end])
            ->select('catalog_categories.name', DB::raw('sum(sales_order_items.line_total) as total'))
            ->groupBy('catalog_categories.name')
            ->orderByDesc('total')
            ->take(4)
            ->get();
        $categoryTotal = max(0.01, $revenueByCategory->sum('total'));

        [$weeklyVolume, $maxWeekly] = $this->weeklyTrend(
            fn ($weekStart, $weekEnd) => Order::whereBetween('created_at', [$weekStart, $weekEnd])->count()
        );

        $topProducts = OrderItem::join('sales_orders', 'sales_order_items.order_id', '=', 'sales_orders.id')
            ->whereBetween('sales_orders.created_at', [$start, $end])
            ->select('product_id', 'product_name', DB::raw('sum(quantity) as sold'), DB::raw('sum(line_total) as revenue'))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('sold')
            ->take(3)
            ->get();

        $topCustomers = Order::whereBetween('created_at', [$start, $end])
            ->whereNotNull('user_id')
            ->select('user_id', DB::raw('count(*) as orders_count'), DB::raw('sum(total) as spend'))
            ->groupBy('user_id')
            ->orderByDesc('spend')
            ->take(3)
            ->with('user')
            ->get();

        $dailySummary = Order::whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('count(*) as orders_count'),
                DB::raw('sum(total) as revenue')
            )
            ->groupBy('day')
            ->orderByDesc('day')
            ->take(10)
            ->get()
            ->map(function ($row) {
                $refunds = (float) Refund::whereDate('created_at', $row->day)->sum('amount');

                return [
                    'date' => $row->day,
                    'orders' => $row->orders_count,
                    'revenue' => (float) $row->revenue,
                    'refunds' => $refunds,
                    'net' => (float) $row->revenue - $refunds,
                ];
            });

        return compact('kpis', 'revenueByCategory', 'categoryTotal', 'weeklyVolume', 'maxWeekly', 'topProducts', 'topCustomers', 'dailySummary');
    }

    protected function buildProductsReport($start, $end): array
    {
        $unitsSold = (int) OrderItem::join('sales_orders', 'sales_order_items.order_id', '=', 'sales_orders.id')
            ->whereBetween('sales_orders.created_at', [$start, $end])
            ->sum('quantity');

        $productKpis = [
            'units_sold' => $unitsSold,
            'active_products' => Product::where('status', 'active')->count(),
            'avg_rating' => round((float) Review::approved()->avg('rating'), 1),
            'low_stock' => Product::lowStock()->where('quantity', '>', 0)->count(),
        ];

        $topSellers = OrderItem::join('sales_orders', 'sales_order_items.order_id', '=', 'sales_orders.id')
            ->whereBetween('sales_orders.created_at', [$start, $end])
            ->select('product_id', 'product_name', DB::raw('sum(quantity) as sold'), DB::raw('sum(line_total) as revenue'))
            ->groupBy('product_id', 'product_name')
            ->orderByDesc('sold')
            ->take(10)
            ->get();

        $soldProductIds = OrderItem::whereNotNull('product_id')->distinct()->pluck('product_id');
        $neverSold = Product::whereNotIn('id', $soldProductIds)
            ->where('status', 'active')
            ->orderByDesc('created_at')
            ->take(10)
            ->get(['id', 'name', 'quantity', 'price']);

        $revenueByCategory = OrderItem::join('sales_orders', 'sales_order_items.order_id', '=', 'sales_orders.id')
            ->join('catalog_products', 'sales_order_items.product_id', '=', 'catalog_products.id')
            ->join('catalog_categories', 'catalog_products.category_id', '=', 'catalog_categories.id')
            ->whereBetween('sales_orders.created_at', [$start, $end])
            ->select('catalog_categories.name', DB::raw('sum(sales_order_items.line_total) as total'), DB::raw('sum(sales_order_items.quantity) as units'))
            ->groupBy('catalog_categories.name')
            ->orderByDesc('total')
            ->take(6)
            ->get();
        $categoryTotal = max(0.01, $revenueByCategory->sum('total'));

        return compact('productKpis', 'topSellers', 'neverSold', 'revenueByCategory', 'categoryTotal');
    }

    protected function buildCustomersReport($start, $end, $prevStart, $prevEnd): array
    {
        $newCustomers = User::customers()->whereBetween('created_at', [$start, $end])->count();
        $prevNewCustomers = User::customers()->whereBetween('created_at', [$prevStart, $prevEnd])->count();

        $totalCustomers = User::customers()->count();

        $buyersInPeriod = Order::whereBetween('created_at', [$start, $end])->whereNotNull('user_id')->distinct()->pluck('user_id');
        $repeatCustomers = User::customers()->whereIn('id', $buyersInPeriod)->withCount('orders')->get()->filter(fn ($u) => $u->orders_count > 1)->count();
        $repeatRate = $buyersInPeriod->count() > 0 ? round($repeatCustomers / $buyersInPeriod->count() * 100, 1) : 0;

        $avgLifetimeValue = (float) (User::customers()
            ->withSum(['orders as lv' => fn ($q) => $q->whereNotIn('status', ['cancelled', 'refunded'])], 'total')
            ->get()->avg('lv') ?? 0);

        $customerKpis = [
            'new_customers' => ['value' => $newCustomers, 'change' => $this->pctChange($newCustomers, $prevNewCustomers)],
            'total_customers' => $totalCustomers,
            'repeat_rate' => $repeatRate,
            'avg_lifetime_value' => $avgLifetimeValue,
        ];

        [$signupTrend, $maxSignups] = $this->weeklyTrend(
            fn ($weekStart, $weekEnd) => User::customers()->whereBetween('created_at', [$weekStart, $weekEnd])->count()
        );

        $tierBreakdown = User::customers()
            ->select('customer_tier', DB::raw('count(*) as total'))
            ->groupBy('customer_tier')
            ->orderByDesc('total')
            ->get();

        $topCustomers = Order::whereBetween('created_at', [$start, $end])
            ->whereNotNull('user_id')
            ->select('user_id', DB::raw('count(*) as orders_count'), DB::raw('sum(total) as spend'))
            ->groupBy('user_id')
            ->orderByDesc('spend')
            ->take(10)
            ->with('user')
            ->get();

        return compact('customerKpis', 'signupTrend', 'maxSignups', 'tierBreakdown', 'topCustomers');
    }

    protected function buildOrdersReport($start, $end): array
    {
        $totalOrders = Order::whereBetween('created_at', [$start, $end])->count();
        $delivered = Order::whereBetween('created_at', [$start, $end])->where('status', 'delivered')->count();
        $cancelled = Order::whereBetween('created_at', [$start, $end])->where('status', 'cancelled')->count();
        $itemUnits = (int) OrderItem::join('sales_orders', 'sales_order_items.order_id', '=', 'sales_orders.id')
            ->whereBetween('sales_orders.created_at', [$start, $end])
            ->sum('quantity');

        $orderKpis = [
            'total_orders' => $totalOrders,
            'delivered' => $delivered,
            'cancelled_rate' => $totalOrders > 0 ? round($cancelled / $totalOrders * 100, 1) : 0,
            'avg_items' => $totalOrders > 0 ? round($itemUnits / $totalOrders, 1) : 0,
        ];

        $statusBreakdown = Order::whereBetween('created_at', [$start, $end])
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->orderByDesc('total')
            ->get();

        $paymentBreakdown = Order::whereBetween('created_at', [$start, $end])
            ->select('payment_status', DB::raw('count(*) as total'))
            ->groupBy('payment_status')
            ->orderByDesc('total')
            ->get();

        $dailyOrders = Order::whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('count(*) as total'),
                DB::raw("sum(case when status = 'delivered' then 1 else 0 end) as delivered"),
                DB::raw("sum(case when status = 'cancelled' then 1 else 0 end) as cancelled")
            )
            ->groupBy('day')
            ->orderByDesc('day')
            ->take(10)
            ->get();

        return compact('orderKpis', 'statusBreakdown', 'paymentBreakdown', 'dailyOrders');
    }

    protected function buildRevenueReport($start, $end, $prevStart, $prevEnd): array
    {
        $gross = (float) Order::whereBetween('created_at', [$start, $end])->sum('total');
        $refunds = (float) Refund::whereBetween('created_at', [$start, $end])->sum('amount');
        $net = $gross - $refunds;
        $discounts = (float) Order::whereBetween('created_at', [$start, $end])->sum('discount_amount');

        $prevGross = (float) Order::whereBetween('created_at', [$prevStart, $prevEnd])->sum('total');
        $prevRefunds = (float) Refund::whereBetween('created_at', [$prevStart, $prevEnd])->sum('amount');
        $prevNet = $prevGross - $prevRefunds;

        $revenueKpis = [
            'gross' => ['value' => $gross, 'change' => $this->pctChange($gross, $prevGross)],
            'refunds' => $refunds,
            'net' => ['value' => $net, 'change' => $this->pctChange($net, $prevNet)],
            'discounts' => $discounts,
        ];

        $components = [
            'subtotal' => (float) Order::whereBetween('created_at', [$start, $end])->sum('subtotal'),
            'shipping' => (float) Order::whereBetween('created_at', [$start, $end])->sum('shipping_amount'),
            'tax' => (float) Order::whereBetween('created_at', [$start, $end])->sum('tax_amount'),
            'discounts' => $discounts,
            'refunds' => $refunds,
            'net' => $net,
        ];

        $byGateway = Payment::join('sales_payment_gateways', 'sales_payments.gateway_id', '=', 'sales_payment_gateways.id')
            ->where('sales_payments.status', 'success')
            ->whereBetween('sales_payments.created_at', [$start, $end])
            ->select('sales_payment_gateways.name', DB::raw('sum(sales_payments.amount) as total'))
            ->groupBy('sales_payment_gateways.name')
            ->orderByDesc('total')
            ->get();
        $gatewayTotal = max(0.01, $byGateway->sum('total'));

        // Trailing 6 calendar months, independent of the selected range — same
        // "recent trend alongside a period summary" convention as the weekly charts.
        $monthlyTrend = collect(range(5, 0))->map(function ($monthsAgo) {
            $monthStart = Carbon::now()->subMonthsNoOverflow($monthsAgo)->startOfMonth();
            $monthEnd = Carbon::now()->subMonthsNoOverflow($monthsAgo)->endOfMonth();

            return [
                'label' => $monthStart->format('M'),
                'total' => (float) Order::whereBetween('created_at', [$monthStart, $monthEnd])->sum('total'),
            ];
        });
        $maxMonthly = max(0.01, $monthlyTrend->max('total'));

        return compact('revenueKpis', 'components', 'byGateway', 'gatewayTotal', 'monthlyTrend', 'maxMonthly');
    }

    protected function buildInventoryReport($start, $end): array
    {
        $inventoryKpis = [
            'total_stock' => Product::sum('quantity'),
            'inventory_value' => Product::selectRaw('SUM(quantity * COALESCE(cost_per_item, 0)) as total')->value('total') ?? 0,
            'low_stock' => Product::lowStock()->where('quantity', '>', 0)->count(),
            'out_of_stock' => Product::where('quantity', '<=', 0)->count(),
        ];

        $byReason = InventoryMovement::whereBetween('created_at', [$start, $end])
            ->select('reason', DB::raw('sum(abs(quantity_change)) as total'), DB::raw('count(*) as movements'))
            ->groupBy('reason')
            ->orderByDesc('total')
            ->get();

        [$movementTrend, $maxMovements] = $this->weeklyTrend(
            fn ($weekStart, $weekEnd) => InventoryMovement::whereBetween('created_at', [$weekStart, $weekEnd])->count()
        );

        $topShrinkage = InventoryMovement::join('catalog_products', 'catalog_inventory_movements.product_id', '=', 'catalog_products.id')
            ->whereBetween('catalog_inventory_movements.created_at', [$start, $end])
            ->where('catalog_inventory_movements.reason', 'damaged')
            ->select('catalog_products.name', DB::raw('sum(abs(catalog_inventory_movements.quantity_change)) as total'))
            ->groupBy('catalog_products.name')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return compact('inventoryKpis', 'byReason', 'movementTrend', 'maxMovements', 'topShrinkage');
    }

    public function exportSalesCsv(Request $request)
    {
        [$start, $end] = $this->resolveDateRange($request);

        $rows = Order::whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('count(*) as orders_count'),
                DB::raw('sum(total) as revenue')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $filename = 'sales-report-'.$start->format('Y-m-d').'-to-'.$end->format('Y-m-d').'.csv';

        return response()->streamDownload(function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date', 'Orders', 'Revenue']);
            foreach ($rows as $row) {
                fputcsv($handle, [$row->day, $row->orders_count, number_format((float) $row->revenue, 2, '.', '')]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }
}
