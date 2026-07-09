<?php
namespace App\Http\Controllers\blog;
use App\Http\Controllers\Controller;

use App\Models\BlogPost;
use App\Models\PostMeta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class PostMetaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $postMetas = PostMeta::all();
        return view('postmeta.index', compact('postMetas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogpost = BlogPost::all();
        return view('postmeta.create' , compact('blogpost'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'blog_post_id' => 'required|integer',
            'meta_key' => 'required|string',
            'meta_value' => 'required|string',
        ]);

        PostMeta::create($validatedData);

        return redirect()->route('postmeta.index')->with('success', 'Post meta added successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function edit($id)
{
    $postMeta = PostMeta::findOrFail($id);
    $blogpost = BlogPost::all();
    return view('postmeta.edit' , compact('postMeta','blogpost'));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'blog_post_id' => 'required|integer',
        'meta_key' => 'required|string',
        'meta_value' => 'required|string',
    ]);

    $postMeta = PostMeta::findOrFail($id);
    $postMeta->update($validatedData);

    return redirect()->route('postmeta.index')->with('success', 'Post meta updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function destroy($id)
{
    $postMeta = PostMeta::findOrFail($id);
    $postMeta->delete();

    return redirect()->route('postmeta.index')->with('success', 'Post meta deleted successfully!');
}

}
