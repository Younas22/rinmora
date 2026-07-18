<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Category;
use App\Models\Catalog\Collection;
use App\Models\Catalog\Product;
use App\Models\Catalog\ProductImage;
use App\Models\Catalog\ProductVariant;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(protected ImageUploadService $images)
    {
    }

    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand', 'coverImage']);

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")->orWhere('sku', 'like', "%{$search}%");
            });
        }
        if ($category = $request->get('category')) {
            $query->where('category_id', $category);
        }
        if ($brand = $request->get('brand')) {
            $query->where('brand_id', $brand);
        }
        if ($status = $request->get('status')) {
            $query->where('status', $status);
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
            'total' => Product::count(),
            'in_stock' => Product::whereColumn('quantity', '>', 'low_stock_threshold')->count(),
            'low_stock' => Product::lowStock()->where('quantity', '>', 0)->count(),
            'out_of_stock' => Product::where('quantity', '<=', 0)->count(),
        ];

        $categories = Category::orderBy('name')->get();
        $brands = Brand::orderBy('name')->get();

        return view('admin.catalog.products.index', compact('products', 'stats', 'categories', 'brands'));
    }

    public function create()
    {
        return view('admin.catalog.products.create', $this->formData());
    }

    public function edit(Product $product)
    {
        $product->load(['images', 'variants']);

        return view('admin.catalog.products.edit', $this->formData() + ['product' => $product]);
    }

    protected function formData(): array
    {
        return [
            'categories' => Category::orderBy('name')->get(),
            'brands' => Brand::orderBy('name')->get(),
            'collections' => Collection::orderBy('name')->get(),
        ];
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $product = DB::transaction(function () use ($data, $request) {
            $product = Product::create($data);
            $this->syncVariants($product, $request);
            $this->storeUploadedImages($product, $request);

            return $product;
        });

        return redirect()->route('admin.catalog.products.edit', $product)->with('success', 'Product created.');
    }

    public function update(Request $request, Product $product)
    {
        if ($request->boolean('toggle_featured_only')) {
            $product->update(['is_featured' => $request->boolean('is_featured')]);

            return back()->with('success', 'Product updated.');
        }

        $data = $this->validated($request, $product);

        DB::transaction(function () use ($data, $request, $product) {
            $product->update($data);
            $this->syncVariants($product, $request);
            $this->storeUploadedImages($product, $request);
        });

        return redirect()->route('admin.catalog.products.edit', $product)->with('success', 'Product updated.');
    }

    protected function validated(Request $request, ?Product $product = null): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_products,slug,'.($product?->id ?? 'NULL'),
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'cost_per_item' => 'nullable|numeric|min:0',
            'sku' => 'nullable|string|max:255|unique:catalog_products,sku,'.($product?->id ?? 'NULL'),
            'barcode' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:0',
            'low_stock_threshold' => 'nullable|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'dimensions' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'category_id' => 'nullable|exists:catalog_categories,id',
            'brand_id' => 'nullable|exists:catalog_brands,id',
            'collection_id' => 'nullable|exists:catalog_collections,id',
            'tags' => 'nullable|string',
            'status' => 'required|in:active,draft,archived',
        ]);

        $data['tags'] = array_values(array_filter(array_map('trim', explode(',', $data['tags'] ?? ''))));
        $data['quantity'] = $data['quantity'] ?? 0;
        $data['low_stock_threshold'] = $data['low_stock_threshold'] ?? 10;
        $data['track_quantity'] = $request->boolean('track_quantity', true);
        $data['allow_backorders'] = $request->boolean('allow_backorders');
        $data['charge_tax'] = $request->boolean('charge_tax', true);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_visible'] = $request->boolean('is_visible', true);

        return $data;
    }

    protected function syncVariants(Product $product, Request $request): void
    {
        $variants = json_decode($request->input('variants_json', '[]'), true) ?: [];

        // Defensive: an empty submitted list while the product currently HAS
        // variants almost always means the variants_json field failed to
        // populate (e.g. a JS error before submit) rather than the admin
        // deliberately removing every option — don't silently wipe existing
        // variants in that case.
        if (empty($variants) && $product->variants()->exists()) {
            return;
        }

        $product->variants()->delete();

        foreach ($variants as $variant) {
            if (empty($variant['option_values'])) {
                continue;
            }

            ProductVariant::create([
                'product_id' => $product->id,
                'sku' => $variant['sku'] ?: null,
                'price' => $variant['price'] !== '' ? $variant['price'] : null,
                'quantity' => (int) ($variant['quantity'] ?? 0),
                'option_values' => $variant['option_values'],
            ]);
        }
    }

    protected function storeUploadedImages(Product $product, Request $request): void
    {
        if (!$request->hasFile('images')) {
            return;
        }

        $hasCover = $product->images()->where('is_cover', true)->exists();
        $sortOrder = (int) $product->images()->max('sort_order');

        foreach ($request->file('images') as $file) {
            $stored = $this->images->store($file, "catalog/products/{$product->id}");

            $product->images()->create([
                'path' => $stored['path'],
                'is_cover' => !$hasCover,
                'sort_order' => ++$sortOrder,
            ]);

            $hasCover = true;
        }
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            $this->images->delete($image->path);
        }

        $product->delete();

        return redirect()->route('admin.catalog.products.index')->with('success', 'Product deleted.');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        $wasCover = $image->is_cover;
        $this->images->delete($image->path);
        $image->delete();

        if ($wasCover) {
            $product->images()->oldest('sort_order')->first()?->update(['is_cover' => true]);
        }

        return back()->with('success', 'Image removed.');
    }

    public function setCoverImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            abort(404);
        }

        $product->images()->update(['is_cover' => false]);
        $image->update(['is_cover' => true]);

        return back()->with('success', 'Cover image updated.');
    }

    public function destroyManyImages(Request $request, Product $product)
    {
        $ids = (array) $request->input('image_ids', []);
        $images = $product->images()->whereIn('id', $ids)->get();

        $hadCover = $images->contains('is_cover', true);

        foreach ($images as $image) {
            $this->images->delete($image->path);
            $image->delete();
        }

        if ($hadCover) {
            $product->images()->oldest('sort_order')->first()?->update(['is_cover' => true]);
        }

        return response()->json(['deleted' => $images->pluck('id')]);
    }

    public function reorderImages(Request $request, Product $product)
    {
        foreach ((array) $request->input('order', []) as $index => $imageId) {
            $product->images()->where('id', $imageId)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
}
