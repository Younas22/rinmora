<?php
namespace App\Http\Controllers\order;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use DB;
use Hash;
use Ramsey\Uuid\Uuid;

class OrderController extends Controller
{
       public function index()
    {
        if (auth()->user()->roll == 'hr') {
            $user = User::orderBy('created_at','desc')
            ->where(['roll'=>'user'])->get();
            $order = Order::join('users', 'order.user_id', '=', 'users.id')
                ->select('order.*', 'users.name', 'users.email', 'users.phone')
                ->orderBy('created_at', 'desc')
                ->where('order.order_type', 'product')->paginate(10);
        }else{
            $order = Order::join('users', 'order.user_id', '=', 'users.id')
                ->select('order.*', 'users.name', 'users.email', 'users.phone')
                ->orderBy('created_at', 'desc')
                ->where('users.id', auth()->user()->id)
                ->where('order.order_type', 'product')->paginate(10);
        }


        $products = DB::table('products')->get();
        $product_b = DB::table('products')->where('id',1)->first();
        $product_s = DB::table('products')->where('id',2)->first();

        $booking_details = DB::table('products_detials')->where('product_id',1)->get();
        $code_details = DB::table('products_detials')->where('product_id',2)->first();

        return view('products.order',get_defined_vars())
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }


        public function orders_details(Request $request)
    {
        $order_detail = Order::join('users', 'order.user_id', '=', 'users.id')
            ->select('order.*', 'users.name', 'users.email', 'users.phone')
            ->where('order.id', '=', $request->id)
            ->first();
            
        $product_details = OrderDetails::where('order_id', $request->id)
            ->join('products_detials', 'order_details.item_id', '=', 'products_detials.id')
            ->select('order_details.*', 'products_detials.name', 'products_detials.price', 'products_detials.source', 'products_detials.image', 'products_detials.product_type','products_detials.desc')
            ->get();

            // dd($request->id);
        return view('products.orders_details', get_defined_vars());
    }

        // track_order
        public function track_order(Request $request)
    {
        $order_details = Order::where('order_id',$request->order_id)->first();
        if ($order_details == null) {
            return view('errors.404', ['error_message' => 'Something Wrong!']);
        }

        $user_details = User::where('id',$order_details->user_id)->first();
        $email = $user_details->email;
        $password = $user_details->dc_password;
        $created_by = $order_details->created_by;
        return view('products.track_order' ,get_defined_vars());
    }

       public function all_quote()
    {
        if (auth()->user()->roll == 'hr') {
            $user = User::orderBy('created_at','desc')
            ->where(['roll'=>'user'])->get();
            $quote = Order::join('users', 'order.user_id', '=', 'users.id')
                ->select('order.*', 'users.name', 'users.email', 'users.phone')
                ->orderBy('created_at', 'desc')
                ->where('order.order_type', 'services')->paginate(10);
        }else{
            $user = User::orderBy('created_at','desc')
            ->where(['roll'=>'user'])->get();
            $quote = Order::join('users', 'order.user_id', '=', 'users.id')
                ->select('order.*', 'users.name', 'users.email', 'users.phone')
                ->orderBy('created_at', 'desc')
                ->where('users.id', auth()->user()->id)
                ->where('order.order_type', 'services')->paginate(10);
        }


        $services = DB::table('services')->get();
        return view('service.quote',get_defined_vars())
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

        public function quote_details(Request $request)
    {
        $quote_detail = Order::join('users', 'order.user_id', '=', 'users.id')
            ->select('order.*', 'users.name', 'users.email', 'users.phone')
            ->where('order.id', '=', $request->id)
            ->first();

        return view('service.quote_details', get_defined_vars());
    }

    // track_quote
        public function track_quote(Request $request)
    {
        $quote_details = Order::where('order_id',$request->quote_id)->first();

        if ($quote_details == null) {
            return view('errors.404', ['error_message' => 'Something Wrong!']);
        }
        
        $user_details = User::where('id',$quote_details->user_id)->first();
        $email = $user_details->email;
        $password = $user_details->dc_password;
        $created_by = $quote_details->created_by;
        return view('service.track_quote' ,get_defined_vars());
    }


       public function help()
    {
        return view('hr.help',get_defined_vars());
    }

       public function gethelp()
    {
        return view('hr.gethelp',get_defined_vars());
    }

       public function get_service()
    {

        $products = DB::table('products')->get();
        $product_b = DB::table('products')->where('id',1)->first();
        $product_s = DB::table('products')->where('id',2)->first();
        $product_c = DB::table('products')->where('id',3)->first();

        $booking_details = DB::table('products_detials')->where('product_id',1)->get();
        $code_details = DB::table('products_detials')->where('product_id',2)->first();
        $course_details = DB::table('products_detials')->where('product_id',3)->first();
        $services = DB::table('services')->get();
        // return view('products.getproducts',get_defined_vars());
        return view('service.getservice',get_defined_vars());
    }

 






 

       //insert
        public function store(Request $request)
    {
        if ($request->created_by == 'self') {
            if (!empty($request->customer_id)) {
                $get_user_id = $request->customer_id;
            }else{
                $check_user_exist = User::where('email',$request->customer_email)->first();
                if (!empty($check_user_exist->email)) {
                    $get_user_id = $check_user_exist->id;
                }else{
                    $password = Str::random(6);
                    $user_created = User::create([
                        'name' => $request->customer_name,
                        'email' => $request->customer_email,
                        'phone' => $request->customer_phone,
                        'password' => Hash::make($password),
                        'dc_password' => $password
                      ]);
                    $get_user_id = $user_created->id;
                }

            }
        }else{
            $get_user_id = $request->customer_id;
        }


        if ($request->order_type == 'product') {
            if($request->file('screenshoot'))
        {
            $file= $request->file('screenshoot');
            $filename= date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('./screenshoot'), $filename);
            $screenshoot = $filename;

        }

        $orderId =  'O_'.uniqid();




        $order = array(
            'order_id'=>$orderId,
            'created_by'=>$request->created_by,
            'user_id'=>$get_user_id,
            'order_type'=>$request->order_type,
            'desc'=>$request->note,
            'payment_option'=>$request->payment_method,
            'total_cost'=>$request->total_payment,
            'product_name'=>get_product_name(1),
            'screen_shoot'=>$screenshoot
        );

        $order_created = Order::create($order);

            if (get_product_name(1) == 'e-Books') {
                $subproduct_arr = $request->subproduct;
                foreach ($subproduct_arr as $key => $book_id) {
                    $add_produt = array(
                        'order_id'=>$order_created->id,
                        'item_id'=>$book_id,
                        'cost'=>get_cost($book_id),
                        'qty'=>1,
                    );

                    $product_added = OrderDetails::create($add_produt);
                }
            }

            if (get_product_name(1) == 'Blog Script') {
                    $add_produt = array(
                        'order_id'=>$order_created->id,
                        'item_id'=>$request->item_id,
                        'cost'=>get_cost(2),
                        'qty'=>1,
                    );

                $product_added = OrderDetails::create($add_produt);
            }
            



        }else{

            if($request->file('document'))
            {
                $file= $request->file('document');
                $filename= date('YmdHi').$file->getClientOriginalName();
                $file->move(public_path('./quote_document'), $filename);
                $quote_document = $filename;

            }else{
                $quote_document = null;
            }

            $quoteId =  'Q_'.uniqid();
            $quote = array(
                'order_id'=>$quoteId,
                'created_by'=>$request->created_by,
                'product_name'=>$request->project_title,
                'user_id'=>$get_user_id,
                'order_type'=>$request->order_type,
                'desc'=>$request->note,
                'payment_status'=>'unpaid',
                'document'=>$quote_document
            );

            $quote_created = Order::create($quote);
        }

        if ($request->order_type == 'product') {
            return redirect()->route('track.order',$order_created->order_id)
                        ->with('success','Order created successfully.');
        }

        if ($request->order_type == 'services') {
            return redirect()->route('track.quote',$quote_created->order_id)
                        ->with('success','Quote request created successfully.');
        }


    }

        //update-status
    public function updateStatus(Request $request)
    {
       
        $order = Order::findOrFail($request->id);
        $order->order_status = $request->status;
        $order->save();

        if ($request->status == 'completed') {
         $get_order = Order::where('id',$request->id)->first();
         if ($get_order->product_name == 'e-Books') {
             $product_details = OrderDetails::where('order_id', $request->id)
            ->join('products_detials', 'order_details.item_id', '=', 'products_detials.id')
            ->select('order_details.item_id','products_detials.source','products_detials.id')
            ->get();

            foreach ($product_details as $key) {
                if ($key->item_id == $key->id) {
                    DB::table('order_details')->where('order_id', $request->id)->where('item_id', $key->item_id)->update(['joining_link'=>$key->source]);
                }
            }
         }

        if ($get_order->product_name == 'Blog Script') {
             $product_details = OrderDetails::where('order_id', $request->id)
            ->join('products_detials', 'order_details.item_id', '=', 'products_detials.id')
            ->select('order_details.item_id','products_detials.source','products_detials.id')
            ->first();
            if ($product_details->item_id == $product_details->id) {
                    DB::table('order_details')->where('order_id', $request->id)->where('item_id', $product_details->item_id)->update(['joining_link'=>$product_details->source]);
                }
         }
        }



        return response()->json(['message' => 'Order status updated successfully']);
    }


        //destroy
        public function destroy($Order)
    {
        $Order = Order::find($Order);
        $Order->delete();
        return redirect()->back()->with('success','Data deleted successfully');
    }
}
