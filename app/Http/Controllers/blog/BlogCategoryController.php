<?php
namespace App\Http\Controllers\blog;
use App\Http\Controllers\Controller;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
{
    $categories = BlogCategory::all();
    return view('posts.category.index', compact('categories'));
}
public function create()
{
    return view('posts.category.create');
}
public function store(Request $request)
{
    $category = new BlogCategory;
    $category->name = $request->name;
    $category->save();
    return redirect()->route('blog.category.index');
}
public function edit($id)
{
    $category = BlogCategory::findOrFail($id);
    return view('posts.category.edit', compact('category'));
}
public function update(Request $request, $id)
{
    $category = BlogCategory::findOrFail($id);
    $category->name = $request->name;
    $category->save();
    return redirect()->route('blog.category.index');
}
public function delete($id)
{
    $category = BlogCategory::findOrFail($id);
    $category->delete();
    return redirect()->route('blog.category.index');
}

}
