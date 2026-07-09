<?php
namespace App\Http\Controllers\blog;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Image;
class ImageController extends Controller
{ 
    public function index()
    {
        $images = Image::latest()->paginate(10);
        return view("images.display", compact("images"));
    }

    public function create()
    {
        return view("images.create");
    }

    public function store(Request $request)
    {
        // Validate the image
        $validatedData = $request->validate([
            "images.*" => "required|image|mimes:jpeg,png,jpg,gif,svg|max:2048",
        ]);

        // Handle the image upload
        $images = $request->file("images");
        foreach ($images as $image) {
            $image_url = $image->store("all_images");
            Image::create([
                "path" => $image_url,
            ]);
        }

        return redirect()
            ->route("images.index")
            ->with("success", "Images uploaded successfully");
    }

    public function destroy(Image $image)
    {
        // dd($image);
        $image_res = Image::findOrFail($image->id);
        // \Storage::delete($image_res->url);
        $image_res->delete();

        return redirect()
            ->back()
            ->with("success", "Image deleted successfully!");
    }
}
