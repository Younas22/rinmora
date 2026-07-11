<?php

namespace App\Http\Controllers\Admin\Sales;

use App\Http\Controllers\Controller;
use App\Models\Sales\ShippingMethod;
use App\Models\Sales\ShippingZone;
use App\Models\Setting;
use Illuminate\Http\Request;

class ShippingController extends Controller
{
    public function index()
    {
        $zones = ShippingZone::with('methods')->orderBy('sort_order')->get();

        $stats = [
            'active_zones' => $zones->where('is_active', true)->count(),
            'methods' => $zones->sum(fn ($z) => $z->methods->count()),
            'free_shipping_threshold' => Setting::getValue('free_shipping_threshold', 'shipping', '75.00'),
        ];

        $freeShippingEnabled = (bool) Setting::getValue('free_shipping_enabled', 'shipping', true);
        $freeShippingThreshold = Setting::getValue('free_shipping_threshold', 'shipping', '75.00');

        return view('admin.sales.shipping.index', compact('zones', 'stats', 'freeShippingEnabled', 'freeShippingThreshold'));
    }

    public function storeZone(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'countries' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        ShippingZone::create($data);

        return back()->with('success', 'Shipping zone created.');
    }

    public function updateZone(Request $request, ShippingZone $zone)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'countries' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $zone->update($data);

        return back()->with('success', 'Shipping zone updated.');
    }

    public function destroyZone(ShippingZone $zone)
    {
        $zone->delete();

        return back()->with('success', 'Shipping zone deleted.');
    }

    public function storeMethod(Request $request, ShippingZone $zone)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'delivery_time' => 'required|string|max:255',
            'rate' => 'nullable|numeric|min:0',
        ]);

        $zone->methods()->create($data);

        return back()->with('success', 'Shipping method added.');
    }

    public function updateMethod(Request $request, ShippingMethod $method)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'delivery_time' => 'required|string|max:255',
            'rate' => 'nullable|numeric|min:0',
        ]);

        $method->update($data);

        return back()->with('success', 'Shipping method updated.');
    }

    public function destroyMethod(ShippingMethod $method)
    {
        $method->delete();

        return back()->with('success', 'Shipping method deleted.');
    }

    public function updateFreeThreshold(Request $request)
    {
        $data = $request->validate([
            'free_shipping_enabled' => 'nullable|boolean',
            'free_shipping_threshold' => 'required|numeric|min:0',
        ]);

        Setting::setValue('free_shipping_enabled', $request->boolean('free_shipping_enabled') ? '1' : '0', 'shipping');
        Setting::setValue('free_shipping_threshold', (string) $data['free_shipping_threshold'], 'shipping');

        return back()->with('success', 'Free shipping rule updated.');
    }
}
