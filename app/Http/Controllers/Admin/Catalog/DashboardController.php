<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'active_products' => Product::active()->count(),
            'low_stock' => Product::lowStock()->count(),
            'pending_reviews' => Review::pending()->count(),
            'total_categories' => Category::count(),
            'total_brands' => Brand::count(),
        ];

        $lowStockProducts = Product::lowStock()->latest()->take(5)->get();
        $latestReviews = Review::with('product')->latest()->take(5)->get();

        return view('admin.catalog.dashboard.index', compact('stats', 'lowStockProducts', 'latestReviews'));
    }
}
