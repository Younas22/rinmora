<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductDetailResource;
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

        if ($category = $request->input('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $category));
        }

        if ($search = $request->input('q')) {
            $query->where(function ($sub) use ($search) {
                $sub->where('name', 'like', "%{$search}%")
                    ->orWhere('short_description', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->input('min_price'));
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->input('max_price'));
        }

        match ($request->input('sort')) {
            'price_asc' => $query->orderBy('price'),
            'price_desc' => $query->orderByDesc('price'),
            'popular' => $query->orderByDesc('reviews_count'),
            default => $query->latest(),
        };

        $perPage = min((int) $request->input('per_page', 12), 48);

        $products = $query->paginate($perPage)->withQueryString();

        return ProductResource::collection($products);
    }

    public function productDetail(string $slug, Request $request)
    {
        $product = Product::active()
            ->where('is_visible', true)
            ->where('slug', $slug)
            ->with(['images', 'variants', 'category', 'brand'])
            ->withCount(['reviews' => fn ($q) => $q->approved()])
            ->withAvg(['reviews' => fn ($q) => $q->approved()], 'rating')
            ->first();

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $reviewsPerPage = min((int) $request->input('reviews_per_page', 5), 20);
        $reviews = $product->reviews()->approved()->latest()->paginate($reviewsPerPage, ['*'], 'reviews_page');

        $related = Product::active()
            ->where('is_visible', true)
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with(['coverImage', 'images', 'category'])
            ->withCount(['reviews' => fn ($q) => $q->approved()])
            ->withAvg(['reviews' => fn ($q) => $q->approved()], 'rating')
            ->latest()
            ->take(4)
            ->get();

        return response()->json([
            'product' => new ProductDetailResource($product),
            'reviews' => [
                'data' => ReviewResource::collection($reviews->getCollection())->resolve(),
                'meta' => [
                    'current_page' => $reviews->currentPage(),
                    'last_page' => $reviews->lastPage(),
                    'per_page' => $reviews->perPage(),
                    'total' => $reviews->total(),
                    'from' => $reviews->firstItem(),
                    'to' => $reviews->lastItem(),
                ],
            ],
            'related_products' => ProductResource::collection($related),
        ]);
    }

    public function validateCart(Request $request)
    {
        $data = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|integer',
            'items.*.variant_id' => 'nullable|integer',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        $productIds = collect($data['items'])->pluck('product_id')->unique();

        $products = Product::with(['coverImage', 'images', 'variants'])
            ->whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $results = collect($data['items'])->map(function (array $line) use ($products) {
            $product = $products->get($line['product_id']);

            if (! $product || $product->status !== 'active' || ! $product->is_visible) {
                return [
                    'product_id' => $line['product_id'],
                    'variant_id' => $line['variant_id'] ?? null,
                    'qty' => $line['qty'],
                    'available' => false,
                    'reason' => 'not_found',
                ];
            }

            $variant = ! empty($line['variant_id'])
                ? $product->variants->firstWhere('id', $line['variant_id'])
                : null;

            $price = $variant?->price !== null ? (float) $variant->price : (float) $product->price;
            $quantityAvailable = $variant ? $variant->quantity : $product->quantity;
            $available = $quantityAvailable > 0;

            return [
                'product_id' => $product->id,
                'variant_id' => $variant?->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'image_url' => $product->coverImage?->url ?? $product->images->first()?->url,
                'price' => $price,
                'compare_at_price' => $product->compare_at_price !== null ? (float) $product->compare_at_price : null,
                'qty' => $line['qty'],
                'quantity_available' => $quantityAvailable,
                'available' => $available,
                'reason' => $available ? null : 'out_of_stock',
            ];
        });

        return response()->json(['items' => $results->values()]);
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
            ->with(['media'])
            ->with(['products' => function ($q) {
                $q->active()->where('is_visible', true)
                    ->with(['coverImage', 'images'])
                    ->withCount(['reviews' => fn ($r) => $r->approved()])
                    ->latest()
                    ->limit(10);
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

            // Admin can attach several photos/videos per category (the
            // "Reel / Story Media" gallery) — that becomes the sequence of
            // slides for this reel. Falls back to a single derived image
            // when no gallery has been uploaded yet.
            $slides = $category->media->isNotEmpty()
                ? $category->media->map(fn ($item) => ['type' => $item->type, 'url' => $item->url])->values()->all()
                : [['type' => 'image', 'url' => $primaryImage]];

            return [
                'id' => $category->id,
                'title' => $category->name,
                'slug' => $category->slug,
                'avatar_url' => $category->image_url ?? $primaryImage,
                'slides' => $slides,
                'likes' => (int) $products->sum('reviews_count'),
                'products' => $products->map(function ($product) use ($coverUrl) {
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
                'title' => $section->title,
                'subtitle' => $section->subtitle,
                'content' => $section->content,
                'image_url' => $section->image_url,
                'button_text' => $section->button_text,
                'button_link' => $section->button_link,
            ])
            ->values()
            ->all();
    }
}
