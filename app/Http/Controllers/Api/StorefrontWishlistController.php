<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Catalog\Product;
use App\Models\Customers\Wishlist;
use Illuminate\Http\Request;

class StorefrontWishlistController extends Controller
{
    public function index(Request $request)
    {
        return $this->currentWishlist($request);
    }

    public function toggle(Request $request, Product $product)
    {
        $userId = $request->user()->id;

        $existing = Wishlist::where('user_id', $userId)->where('product_id', $product->id)->first();

        if ($existing) {
            $existing->delete();

            return response()->json(['wishlisted' => false]);
        }

        Wishlist::create(['user_id' => $userId, 'product_id' => $product->id]);

        return response()->json(['wishlisted' => true]);
    }

    public function merge(Request $request)
    {
        $data = $request->validate([
            'product_ids' => 'array',
            'product_ids.*' => 'integer|exists:catalog_products,id',
        ]);

        $userId = $request->user()->id;

        foreach ($data['product_ids'] ?? [] as $productId) {
            Wishlist::firstOrCreate(['user_id' => $userId, 'product_id' => $productId]);
        }

        return $this->currentWishlist($request);
    }

    protected function currentWishlist(Request $request)
    {
        $productIds = Wishlist::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->pluck('product_id')
            ->all();

        $products = Product::whereIn('id', $productIds)
            ->with(['coverImage', 'images', 'category'])
            ->withCount(['reviews' => fn ($q) => $q->approved()])
            ->withAvg(['reviews' => fn ($q) => $q->approved()], 'rating')
            ->get()
            ->sortBy(fn (Product $product) => array_search($product->id, $productIds))
            ->values();

        return ProductResource::collection($products);
    }
}
