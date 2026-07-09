<?php
namespace App\Http\Controllers\account;
use App\Http\Controllers\Controller;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use DB;
  
class UserController extends Controller
{

    public function index()
    {
        if (Auth::check()) {
            if (auth()->user()->roll == 'user') { 
                return redirect()->intended('employee-dashboard');
            }else{
                return redirect()->intended('hr-dashboard');
            }
        }
        return view('auth.login');
    }

        public function profile()
    {   
        $get_profile = User::where('users.id', auth()->user()->id)->first();
        return view('auth.profile' , get_defined_vars());
    }


    public function registration()
    {
        if (Auth::check()) {
            if (auth()->user()->roll == 'user') { 
                return redirect()->intended('employee-dashboard');
            }else{
                return redirect()->intended('hr-dashboard');
            }
        }
        return view('auth.registration');
    }


    public function postLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $back_url = $request->back_url;
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (auth()->user()->roll == 'user') {
                
                    if (!empty($back_url)) {
                        return redirect($back_url)->withSuccess('You have Successfully loggedin');
                    }else{
                        return redirect()->intended('employee-dashboard')->withSuccess('You have Successfully loggedin');

                    }

            }else{

                    if (!empty($back_url)) {
                      return redirect($back_url)->withSuccess('You have Successfully loggedin');
                    }else{
                        return redirect()->intended('hr-dashboard')->withSuccess('You have Successfully loggedin');
                    }
                
            }
        }


        $back_url = $request->back_url;
        if (!empty($back_url)) {
          return redirect()->back()->withErrors('Oppes! You have entered invalid credentials');
        }else{
            return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');
        }

    }



    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
    
}