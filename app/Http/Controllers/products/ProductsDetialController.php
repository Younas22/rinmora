<?php
namespace App\Http\Controllers\products;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Products;
use App\Models\ProductsDetial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;

class ProductsDetialController extends Controller
{
    public function index()
    {
        // $products_detials = ProductsDetial::latest()->paginate(15);
        $products = Products::all();

        $products_detials = ProductsDetial::join('products', 'products_detials.product_id', '=', 'products.id')
                ->select('products_detials.*', 'products.name as product_cat')
                ->orderBy('created_at', 'desc')->paginate(15);


        return view('products.products_detials', get_defined_vars())
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


    public function store(Request $request)
    {

        // dd($request->all());

        $validatedData = $request->validate([
            'product_id' => 'required',
            'name' => 'required|string',
            'price' => 'required|string',
            'desc' => 'required'
        ]);


        $source = '';
        if ($request->product_type == 'notion') {
                $source = $request->link;
        }else{
            if($request->file('source'))
            {
                $file= $request->file('source');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('./products_detials'), $filename);
                $source = url('public/products_detials').'/'.$filename;
            }
        }


            $ProductsDetial = new ProductsDetial();
            $ProductsDetial->product_id = $request->product_id;
            $ProductsDetial->image = $request->image;
            $ProductsDetial->image_2 =$request->image_2;
            $ProductsDetial->name = $request->name;
            $ProductsDetial->price = $request->price;
            $ProductsDetial->source = $source;
            $ProductsDetial->product_type = $request->product_type;
            $ProductsDetial->desc = $request->desc;
            $ProductsDetial->save();

            return redirect()->route('product-details.index')->with('success', 'product details created successfully');
    }



public function update(Request $request, $id)
{

        $source = '';
        if ($request->product_type == 'notion') {
                $source = $request->link;
        }else{
            if($request->file('source'))
            {
                $file= $request->file('source');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('./products_detials'), $filename);
                $source = url('public/products_detials').'/'.$filename;
            }else{
                $source = $request->oldsource;
            }
        }

            $edit_data = array(
                'product_id' => $request->product_id,
                'image' => $request->image,
                'image_2' =>$request->image_2,
                'name' => $request->name,
                'price' => $request->price,
                'source' => $source,
                'product_type' => $request->product_type,
                'desc' => $request->desc
            );

            $ProductsDetial = ProductsDetial::findOrFail($id);
            $ProductsDetial->update($edit_data);
            

        return redirect()->route('product-details.index')->with('success', 'Product details updated successfully');
}



    public function destroy($id)
    {
        $products_detial = ProductsDetial::find($id);
        if($products_detial->delete()){
            return redirect()->route('product-details.index')->with('success', 'Product details deleted successfully');
        }else{
            return redirect()->route('product-details.index')->with('error', 'An error occured while deleting the product details');
        }
    }


}
