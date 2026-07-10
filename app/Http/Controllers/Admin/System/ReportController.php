<?php

namespace App\Http\Controllers\Admin\System;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use App\Models\Sales\Order;
use App\Models\Sales\OrderItem;
use App\Models\Sales\Refund;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $reportType = $request->get('type', 'sales');

        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfDay();
        $prevStart = (clone $start)->subMonthNoOverflow();
        $prevEnd = (clone $start)->subDay()->endOfDay();

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

        $pctChange = function ($current, $previous) {
            if ($previous == 0) {
                return $current > 0 ? 100.0 : 0.0;
            }

            return round(($current - $previous) / $previous * 100, 1);
        };

        $kpis = [
            'revenue' => ['value' => $totalRevenue, 'change' => $pctChange($totalRevenue, $prevRevenue), 'prev' => $prevRevenue],
            'orders' => ['value' => $totalOrders, 'change' => $pctChange($totalOrders, $prevOrders), 'prev' => $prevOrders],
            'aov' => ['value' => $aov, 'change' => $pctChange($aov, $prevAov), 'prev' => $prevAov],
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

        $weeklyVolume = collect(range(3, 0))->map(function ($weeksAgo) {
            $weekStart = Carbon::now()->subWeeks($weeksAgo)->startOfWeek();
            $weekEnd = Carbon::now()->subWeeks($weeksAgo)->endOfWeek();

            return [
                'label' => 'Wk '.(4 - $weeksAgo),
                'count' => Order::whereBetween('created_at', [$weekStart, $weekEnd])->count(),
            ];
        });
        $maxWeekly = max(1, $weeklyVolume->max('count'));

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
            ->map(function ($row) use ($start, $end) {
                $refunds = (float) Refund::whereDate('created_at', $row->day)->sum('amount');

                return [
                    'date' => $row->day,
                    'orders' => $row->orders_count,
                    'revenue' => (float) $row->revenue,
                    'refunds' => $refunds,
                    'net' => (float) $row->revenue - $refunds,
                ];
            });

        return view('admin.system.reports.index', compact(
            'reportType', 'kpis', 'start', 'end', 'revenueByCategory', 'categoryTotal',
            'weeklyVolume', 'maxWeekly', 'topProducts', 'topCustomers', 'dailySummary'
        ));
    }

    public function exportSalesCsv(Request $request)
    {
        $start = Carbon::now()->startOfMonth();
        $end = Carbon::now()->endOfDay();

        $rows = Order::whereBetween('created_at', [$start, $end])
            ->select(
                DB::raw('DATE(created_at) as day'),
                DB::raw('count(*) as orders_count'),
                DB::raw('sum(total) as revenue')
            )
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $filename = 'sales-report-'.$start->format('Y-m').'.csv';

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
