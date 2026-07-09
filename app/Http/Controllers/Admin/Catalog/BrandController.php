<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Brand;
use App\Models\Catalog\Collection;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(protected ImageUploadService $images)
    {
    }

    public function index()
    {
        $brands = Brand::withCount('products')->orderBy('name')->get();
        $collections = Collection::withCount('products')->orderBy('name')->get();

        $brandStats = [
            'total' => $brands->count(),
            'active' => $brands->where('status', true)->count(),
            'products_assigned' => $brands->sum('products_count'),
        ];

        $collectionStats = [
            'total' => $collections->count(),
            'live' => $collections->where('status', true)->count(),
            'draft' => $collections->where('status', false)->count(),
        ];

        return view('admin.catalog.brands.index', compact('brands', 'collections', 'brandStats', 'collectionStats'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_brands,slug',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo_path'] = $this->images->store($request->file('logo'), 'catalog/brands')['path'];
        }
        $data['status'] = $request->boolean('status', true);

        Brand::create($data);

        return back()->with('success', 'Brand created.');
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_brands,slug,'.$brand->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('logo')) {
            $this->images->delete($brand->logo_path);
            $data['logo_path'] = $this->images->store($request->file('logo'), 'catalog/brands')['path'];
        }
        $data['status'] = $request->boolean('status', true);

        $brand->update($data);

        return back()->with('success', 'Brand updated.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return back()->with('error', 'Cannot delete a brand that still has products assigned to it.');
        }

        $this->images->delete($brand->logo_path);
        $brand->delete();

        return back()->with('success', 'Brand deleted.');
    }

    public function storeCollection(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_collections,slug',
            'description' => 'nullable|string',
            'type' => 'required|in:manual,automatic',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $this->images->store($request->file('cover_image'), 'catalog/collections')['path'];
        }
        $data['status'] = $request->boolean('status', true);

        Collection::create($data);

        return back()->with('success', 'Collection created.');
    }

    public function updateCollection(Request $request, Collection $collection)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_collections,slug,'.$collection->id,
            'description' => 'nullable|string',
            'type' => 'required|in:manual,automatic',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('cover_image')) {
            $this->images->delete($collection->cover_image_path);
            $data['cover_image_path'] = $this->images->store($request->file('cover_image'), 'catalog/collections')['path'];
        }
        $data['status'] = $request->boolean('status', true);

        $collection->update($data);

        return back()->with('success', 'Collection updated.');
    }

    public function destroyCollection(Collection $collection)
    {
        if ($collection->products()->exists()) {
            return back()->with('error', 'Cannot delete a collection that still has products assigned to it.');
        }

        $this->images->delete($collection->cover_image_path);
        $collection->delete();

        return back()->with('success', 'Collection deleted.');
    }
}
