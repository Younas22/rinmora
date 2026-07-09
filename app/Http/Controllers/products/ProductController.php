<?php
namespace App\Http\Controllers\products;
use App\Http\Controllers\Controller;


use App\Models\Seo;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class ProductController extends Controller
{

    public function index()
    {
        $products = Products::all();
        return view('products.products', get_defined_vars());
    }



    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'desc' => 'required|string',
            'website' => 'required|string',
        ]);

        Products::create($validatedData);

        return redirect()->route('products.index')->with('success', 'products added successfully!');
    }


    public function update(Request $request, $id)
    {
            $validatedData = $request->validate([
            'image' => 'required|string',
            'name' => 'required|string',
            'desc' => 'required|string',
            'website' => 'required|string',
            ]);

        $Products = Products::findOrFail($id);
        $Products->update($validatedData);

        return redirect()->route('products.index')->with('success', 'products updated successfully!');
    }



    public function destroy($id)
    {
        $Products = Products::findOrFail($id);
        $Products->delete();

        return redirect()->route('products.index')->with('success', 'products deleted successfully!');
    }

}
