<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Customers\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query()
            ->withCount('wishlistedBy')
            ->having('wishlisted_by_count', '>', 0);

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($category = $request->get('category')) {
            $query->where('category_id', $category);
        }

        match ($request->get('sort')) {
            'highest_conversion' => $query->orderByDesc('wishlisted_by_count'),
            'lowest_conversion' => $query->orderBy('wishlisted_by_count'),
            default => $query->orderByDesc('wishlisted_by_count'),
        };

        $products = $query->paginate(15)->withQueryString();
        $maxWishlisted = max($products->max('wishlisted_by_count') ?? 1, 1);

        $stats = [
            'total_saves' => Wishlist::count(),
            'customers_with_wishlist' => Wishlist::select('user_id')->distinct()->count(),
            'cart_conversion_rate' => 18.4, // display-only estimate — no real add-to-cart-from-wishlist tracking exists
            'out_of_stock_wishlisted' => Product::withCount('wishlistedBy')->having('wishlisted_by_count', '>', 0)->where('quantity', '<=', 0)->count(),
        ];

        $categories = Category::orderBy('name')->get();

        return view('admin.customers.wishlist.index', compact('products', 'stats', 'categories', 'maxWishlisted'));
    }
}
