<?php
namespace App\Http\Controllers\services;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;

class ServiceController extends Controller
{
        public function services(Request $request)
    {
        $services = DB::table('services')->get();
        return view('service.service', get_defined_vars());
    }
}