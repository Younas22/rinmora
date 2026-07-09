<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('sku', 'like', "%{$search}%");
            });
        }
        if ($stock = $request->get('stock')) {
            match ($stock) {
                'in_stock' => $query->whereColumn('quantity', '>', 'low_stock_threshold'),
                'low_stock' => $query->whereColumn('quantity', '<=', 'low_stock_threshold')->where('quantity', '>', 0),
                'out_of_stock' => $query->where('quantity', '<=', 0),
                default => null,
            };
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'inventory_value' => Product::selectRaw('SUM(quantity * COALESCE(cost_per_item, 0)) as total')->value('total') ?? 0,
            'low_stock' => Product::lowStock()->where('quantity', '>', 0)->count(),
            'out_of_stock' => Product::where('quantity', '<=', 0)->count(),
        ];

        return view('admin.catalog.inventory.index', compact('products', 'stats'));
    }

    public function adjust(Request $request, Product $product)
    {
        $data = $request->validate([
            'type' => 'required|in:add,remove,set',
            'quantity' => 'required|integer|min:0',
            'reason' => 'required|in:restock,damaged,recount,return_to_stock',
            'notes' => 'nullable|string',
        ]);

        DB::transaction(function () use ($data, $product, $request) {
            $current = $product->quantity;

            $newQuantity = match ($data['type']) {
                'add' => $current + $data['quantity'],
                'remove' => max(0, $current - $data['quantity']),
                'set' => $data['quantity'],
            };

            $change = $newQuantity - $current;

            $product->update(['quantity' => $newQuantity]);

            $product->inventoryMovements()->create([
                'type' => $data['type'],
                'quantity_change' => $change,
                'reason' => $data['reason'],
                'notes' => $data['notes'] ?? null,
                'user_id' => $request->user()->id,
            ]);
        });

        return back()->with('success', 'Stock adjusted for '.$product->name.'.');
    }
}
