<?php
namespace App\Http\Controllers\blog;
use App\Http\Controllers\Controller;

use App\Models\Seo;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $seos = Seo::all();
        return view('seo.index', compact('seos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogpost = BlogPost::all();
        return view('seo.create' , compact('blogpost'));
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
            'title' => 'required|string',
            'description' => 'required|string',
            'keywords' => 'required|string',
        ]);

        Seo::create($validatedData);

        return redirect()->route('seo.index')->with('success', 'Seo added successfully!');
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
    $seos = Seo::findOrFail($id);
    $blogpost = BlogPost::all();
    return view('seo.edit', compact('seos','blogpost'));
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
            'title' => 'required|string',
            'description' => 'required|string',
            'keywords' => 'required|string',
        ]);

    $post_seo = Seo::findOrFail($id);
    $post_seo->update($validatedData);

    return redirect()->route('seo.index')->with('success', 'Post meta updated successfully!');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function destroy($id)
{
    $post_seo = Seo::findOrFail($id);
    $post_seo->delete();

    return redirect()->route('seo.index')->with('success', 'Post meta deleted successfully!');
}

}
