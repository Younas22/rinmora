<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ReviewResource;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\Catalog\Review;
use App\Models\Cms\HomepageSection;
use Illuminate\Http\Request;

class StorefrontController extends Controller
{
    public function categories()
    {
        $categories = Category::active()
            ->withCount(['products' => fn ($q) => $q->active()->where('is_visible', true)])
            ->orderBy('name')
            ->get();

        return CategoryResource::collection($categories);
    }

    public function products(Request $request)
    {
        $query = Product::active()
            ->where('is_visible', true)
            ->with(['coverImage', 'images', 'category'])
            ->withCount(['reviews' => fn ($q) => $q->approved()])
            ->withAvg(['reviews' => fn ($q) => $q->approved()], 'rating');

        if ($request->boolean('featured')) {
            $query->where('is_featured', true);
        }

        $limit = min((int) $request->input('limit', 8), 24);

        $products = $query->latest()->take($limit)->get();

        return ProductResource::collection($products);
    }

    public function reviews(Request $request)
    {
        $limit = min((int) $request->input('limit', 6), 24);

        $reviews = Review::approved()
            ->with('product')
            ->latest()
            ->take($limit)
            ->get();

        return ReviewResource::collection($reviews);
    }

    public function reels()
    {
        return response()->json(['data' => $this->buildReels()]);
    }

    public function layout()
    {
        return response()->json(['data' => $this->buildLayout()]);
    }

    public function home(Request $request)
    {
        return response()->json([
            'layout' => $this->buildLayout(),
            'categories' => CategoryResource::collection($this->categoriesQuery()->take(6)->get()),
            'bestsellers' => ProductResource::collection($this->bestsellersQuery()->take(8)->get()),
            'reels' => $this->buildReels(),
            'reviews' => ReviewResource::collection($this->reviewsQuery()->take(6)->get()),
        ]);
    }

    protected function categoriesQuery()
    {
        return Category::active()
            ->withCount(['products' => fn ($q) => $q->active()->where('is_visible', true)])
            ->orderBy('name');
    }

    protected function bestsellersQuery()
    {
        return Product::active()
            ->where('is_visible', true)
            ->where('is_featured', true)
            ->with(['coverImage', 'images', 'category'])
            ->withCount(['reviews' => fn ($q) => $q->approved()])
            ->withAvg(['reviews' => fn ($q) => $q->approved()], 'rating')
            ->latest();
    }

    protected function reviewsQuery()
    {
        return Review::approved()->with('product')->latest();
    }

    /**
     * One "reel" per active category, sourced from that category's own
     * products so the story bar reflects real, admin-managed catalog data.
     */
    protected function buildReels(): array
    {
        $categories = Category::active()
            ->with(['products' => function ($q) {
                $q->active()->where('is_visible', true)
                    ->with(['coverImage', 'images'])
                    ->withCount(['reviews' => fn ($r) => $r->approved()])
                    ->latest()
                    ->limit(4);
            }])
            ->orderBy('name')
            ->take(8)
            ->get()
            ->filter(fn (Category $category) => $category->products->isNotEmpty())
            ->values();

        return $categories->map(function (Category $category) {
            $products = $category->products;
            $coverUrl = fn ($product) => $product->coverImage?->url ?? $product->images->first()?->url;
            $primaryImage = $coverUrl($products->first()) ?? $category->image_url;

            return [
                'id' => $category->id,
                'title' => $category->name,
                'slug' => $category->slug,
                'avatar_url' => $category->image_url ?? $primaryImage,
                'media_url' => $primaryImage,
                'likes' => (int) $products->sum('reviews_count'),
                'products' => $products->take(2)->map(function ($product) use ($coverUrl) {
                    $price = (float) $product->price;
                    $compareAt = $product->compare_at_price !== null ? (float) $product->compare_at_price : null;

                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'image_url' => $coverUrl($product),
                        'price' => $price,
                        'compare_at_price' => $compareAt,
                        'discount_percent' => ($compareAt && $compareAt > $price)
                            ? (int) round((($compareAt - $price) / $compareAt) * 100)
                            : null,
                        'is_new' => $product->created_at?->gt(now()->subDays(21)) ?? false,
                    ];
                })->values(),
            ];
        })->values()->all();
    }

    /**
     * Which homepage blocks are visible and in what order, as managed from
     * the admin CMS "Homepage Sections" screen.
     */
    protected function buildLayout(): array
    {
        return HomepageSection::visible()
            ->ordered()
            ->get()
            ->map(fn (HomepageSection $section) => [
                'type' => $section->type,
                'button_text' => $section->button_text,
                'button_link' => $section->button_link,
            ])
            ->values()
            ->all();
    }
}
