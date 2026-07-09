<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with('product');

        $tab = $request->get('tab', 'all');
        if (in_array($tab, ['pending', 'approved', 'reported'], true)) {
            $query->where('status', $tab);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                    ->orWhereHas('product', fn ($p) => $p->where('name', 'like', "%{$search}%"));
            });
        }
        if ($rating = $request->get('rating')) {
            if ($rating === '3-') {
                $query->where('rating', '<=', 3);
            } else {
                $query->where('rating', $rating);
            }
        }
        if ($product = $request->get('product')) {
            $query->where('product_id', $product);
        }

        $reviews = $query->latest()->paginate(15)->withQueryString();

        $counts = [
            'all' => Review::count(),
            'pending' => Review::pending()->count(),
            'approved' => Review::approved()->count(),
            'reported' => Review::where('status', 'reported')->count(),
        ];

        $distribution = [];
        $total = Review::count();
        for ($star = 5; $star >= 1; $star--) {
            $count = Review::where('rating', $star)->count();
            $distribution[$star] = $total ? round($count / $total * 100) : 0;
        }

        $products = Product::orderBy('name')->get(['id', 'name']);

        return view('admin.catalog.reviews.index', compact('reviews', 'counts', 'distribution', 'products', 'tab'));
    }

    public function updateStatus(Request $request, Review $review)
    {
        $data = $request->validate([
            'status' => 'required|in:pending,approved,rejected,reported',
        ]);

        $review->update($data);

        return back()->with('success', 'Review updated.');
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with('success', 'Review deleted.');
    }
}
