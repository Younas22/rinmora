<?php
namespace App\Http\Controllers\blog;
use App\Http\Controllers\Controller;

use App\Models\Attendance;
use App\Models\Daily_task;
use App\Models\User;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogPostImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->paginate(15);
        
        return view('posts.index', get_defined_vars())
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $categories = BlogCategory::all();
        return view('posts.create' , compact('categories'));
    }

    public function setting()
    {
        return view('posts.setting');
    }

    public function inv()
    {
        return view('posts.inv');
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $validatedData = $request->validate([
            'category_id' => 'required',
            'title' => 'required|string',
            'slug' => 'required|string',
            'body' => 'required|string',
            'featured_image' => 'required|string',
            'status' => 'required|in:published,draft'
        ]);


        //     if($request->file('featured_image'))
        // {
        //     $file= $request->file('featured_image');
        //     $filename= date('YmdHi').$file->getClientOriginalName();
        //     $file->move(public_path('./featured_image'), $filename);
        //     $featured_image = $filename;

        // }


            $post = new BlogPost();
            $post->category_id = $validatedData['category_id'];
            $post->title = $validatedData['title'];
            $post->slug = $validatedData['slug'];
            $post->featured_image = $validatedData['featured_image'];
            $post->body = $validatedData['body'];
            $post->status = $validatedData['status'];
            $post->user_id = auth()->user()->id;
            $post->save();

            return redirect()->route('posts.index')->with('success', 'Post created successfully');
    }


    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::all();
        return view('posts.edit', compact('post', 'categories'));
    }


public function update(Request $request, BlogPost $post)
{
    $validatedData = $request->validate([
        'category_id' => 'required',
        'title' => 'required|string',
        'slug' => 'required|string',
        'body' => 'required|string',
        'featured_image' => 'required|string',
        'status' => 'required|in:published,draft'
    ]);

    $post->category_id = $validatedData['category_id'];
    $post->title = $validatedData['title'];
    $post->slug = $validatedData['slug'];
    $post->featured_image = $validatedData['featured_image'];
    $post->body = $validatedData['body'];
    $post->status = $validatedData['status'];
    $post->user_id = auth()->user()->id;
    $post->save();


    return redirect()->route('posts.index')->with('success', 'Post updated successfully');
}



    public function destroy(BlogPost $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }


}
