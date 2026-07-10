<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;
use App\Models\Catalog\CategoryMedia;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function __construct(protected ImageUploadService $images)
    {
    }

    public function index(Request $request)
    {
        $query = Category::withCount('products')->with('parent')->latest();

        if ($search = $request->get('search')) {
            $query->where('name', 'like', "%{$search}%");
        }
        if ($request->get('status') === 'active') {
            $query->where('status', true);
        } elseif ($request->get('status') === 'hidden') {
            $query->where('status', false);
        }

        $categories = $query->paginate(15)->withQueryString();

        $stats = [
            'total' => Category::count(),
            'active' => Category::where('status', true)->count(),
            'products_categorized' => Category::has('products')->withCount('products')->get()->sum('products_count'),
            'empty' => Category::doesntHave('products')->count(),
        ];

        $parents = Category::orderBy('name')->get();
        $editing = $request->filled('edit') ? Category::with('media')->find($request->get('edit')) : null;

        return view('admin.catalog.categories.index', compact('categories', 'stats', 'parents', 'editing'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $category = DB::transaction(function () use ($data, $request) {
            if ($request->hasFile('image')) {
                $data['image_path'] = $this->images->store($request->file('image'), 'catalog/categories')['path'];
            }
            $data['status'] = $request->boolean('status');

            $category = Category::create($data);
            $this->storeUploadedMedia($category, $request);

            return $category;
        });

        return redirect()->route('admin.catalog.categories.index', ['edit' => $category->id])->with('success', 'Category created.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $this->validated($request, $category);

        if ((int) ($data['parent_id'] ?? 0) === $category->id) {
            return back()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
        }

        DB::transaction(function () use ($data, $request, $category) {
            if ($request->hasFile('image')) {
                $this->images->delete($category->image_path);
                $data['image_path'] = $this->images->store($request->file('image'), 'catalog/categories')['path'];
            }
            $data['status'] = $request->boolean('status');

            $category->update($data);
            $this->storeUploadedMedia($category, $request);
        });

        return back()->with('success', 'Category updated.');
    }

    protected function validated(Request $request, ?Category $category = null): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_categories,slug,'.($category?->id ?? 'NULL'),
            'parent_id' => 'nullable|exists:catalog_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'nullable|boolean',
            'media.*' => 'nullable|mimes:jpg,jpeg,png,webp,mp4,mov,webm|max:20480',
        ]);
    }

    /**
     * Reel/story gallery: multiple images and/or short videos for this
     * category, separate from the single `image_path` thumbnail above.
     */
    protected function storeUploadedMedia(Category $category, Request $request): void
    {
        if (!$request->hasFile('media')) {
            return;
        }

        $hasCover = $category->media()->where('is_cover', true)->exists();
        $sortOrder = (int) $category->media()->max('sort_order');

        foreach ($request->file('media') as $file) {
            $isVideo = str_starts_with($file->getMimeType(), 'video/');

            $stored = $isVideo
                ? $this->images->storeRaw($file, "catalog/categories/{$category->id}/media")
                : $this->images->store($file, "catalog/categories/{$category->id}/media");

            $category->media()->create([
                'path' => $stored['path'],
                'type' => $isVideo ? 'video' : 'image',
                'is_cover' => !$hasCover,
                'sort_order' => ++$sortOrder,
            ]);

            $hasCover = true;
        }
    }

    public function destroyMedia(Category $category, CategoryMedia $media)
    {
        if ($media->category_id !== $category->id) {
            abort(404);
        }

        $wasCover = $media->is_cover;
        $this->images->delete($media->path);
        $media->delete();

        if ($wasCover) {
            $category->media()->oldest('sort_order')->first()?->update(['is_cover' => true]);
        }

        return back()->with('success', 'Media removed.');
    }

    public function setCoverMedia(Category $category, CategoryMedia $media)
    {
        if ($media->category_id !== $category->id) {
            abort(404);
        }

        $category->media()->update(['is_cover' => false]);
        $media->update(['is_cover' => true]);

        return back()->with('success', 'Cover updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Cannot delete a category that still has products assigned to it.');
        }

        $this->images->delete($category->image_path);
        foreach ($category->media as $media) {
            $this->images->delete($media->path);
        }
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
