<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\PaymentGateway;
use App\Models\Sales\Payment;
use App\Models\Sales\Refund;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $stats = [
            'total_transactions' => Payment::count(),
            'total_revenue' => Payment::where('status', 'success')->sum('amount'),
            'pending_refunds' => Refund::where('stage', '!=', 'processed')->count(),
            'failed_payments' => Payment::where('status', 'failed')->count(),
        ];

        $gateways = PaymentGateway::orderBy('sort_order')->get();
        $transactions = Payment::with(['order', 'gateway'])->latest()->paginate(10);
        $refunds = Refund::with(['order', 'payment'])->whereIn('stage', ['requested', 'approved'])->latest()->take(10)->get();

        $logs = Payment::with('order')->latest()->take(4)->get()
            ->map(fn (Payment $p) => [
                'text' => ($p->status === 'success' ? 'Payment captured for ' : ($p->status === 'failed' ? 'Payment declined for ' : 'Refund processed for ')).$p->transaction_ref,
                'color' => match ($p->status) { 'success' => 'success', 'failed' => 'danger', default => 'warning' },
                'at' => $p->created_at,
            ])
            ->concat(
                Refund::latest()->take(4)->get()->map(fn (Refund $r) => [
                    'text' => 'Refund '.$r->stage.' for Order #'.($r->order->order_number ?? $r->order_id),
                    'color' => 'warning',
                    'at' => $r->created_at,
                ])
            )
            ->sortByDesc('at')
            ->take(6)
            ->values();

        return view('admin.sales.payments.index', compact('stats', 'gateways', 'transactions', 'refunds', 'logs'));
    }

    public function updateGateway(Request $request, PaymentGateway $gateway)
    {
        $gateway->update(['is_enabled' => $request->boolean('is_enabled')]);

        return back()->with('success', $gateway->name.' '.($gateway->is_enabled ? 'enabled' : 'disabled').'.');
    }

    public function updateRefundStage(Request $request, Refund $refund)
    {
        $data = $request->validate([
            'stage' => 'required|in:requested,approved,processed',
        ]);

        $refund->update($data);

        return back()->with('success', 'Refund stage updated.');
    }
}
