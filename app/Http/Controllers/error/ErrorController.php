<?php
namespace App\Http\Controllers\error;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
class ErrorController extends Controller {
	
    public function pageNotFound() {
        return view('errors.404');
    }
}
