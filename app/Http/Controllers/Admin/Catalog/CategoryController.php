<?php

namespace App\Http\Controllers\Admin\Catalog;

use App\Http\Controllers\Controller;
use App\Models\Catalog\Category;
use App\Services\Catalog\ImageUploadService;
use Illuminate\Http\Request;

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
        $editing = $request->filled('edit') ? Category::find($request->get('edit')) : null;

        return view('admin.catalog.categories.index', compact('categories', 'stats', 'parents', 'editing'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_categories,slug',
            'parent_id' => 'nullable|exists:catalog_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'nullable|boolean',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $this->images->store($request->file('image'), 'catalog/categories')['path'];
        }
        $data['status'] = $request->boolean('status', true);

        Category::create($data);

        return back()->with('success', 'Category created.');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:catalog_categories,slug,'.$category->id,
            'parent_id' => 'nullable|exists:catalog_categories,id',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'status' => 'nullable|boolean',
        ]);

        if ((int) ($data['parent_id'] ?? 0) === $category->id) {
            return back()->withErrors(['parent_id' => 'A category cannot be its own parent.']);
        }

        if ($request->hasFile('image')) {
            $this->images->delete($category->image_path);
            $data['image_path'] = $this->images->store($request->file('image'), 'catalog/categories')['path'];
        }
        $data['status'] = $request->boolean('status', true);

        $category->update($data);

        return back()->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with('error', 'Cannot delete a category that still has products assigned to it.');
        }

        $this->images->delete($category->image_path);
        $category->delete();

        return back()->with('success', 'Category deleted.');
    }
}
