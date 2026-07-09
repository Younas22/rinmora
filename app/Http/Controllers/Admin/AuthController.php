<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isAgent())) {
            return redirect()->route('admin.dashboard.index');
        }
        
        return view('admin.auth.login');
    }
    
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Rate limiting
        $key = 'login.' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => "Too many login attempts. Please try again in {$seconds} seconds.",
            ]);
        }
        
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            if ($user->isAdmin() || $user->isAgent()) {
                $request->session()->regenerate();
                $user->update(['last_activity' => now()]);
                
                // Clear rate limiter on successful login
                RateLimiter::clear($key);
                
                return redirect()->intended(route('admin.dashboard.index'));
            }
            
            Auth::logout();
            RateLimiter::hit($key);
            throw ValidationException::withMessages([
                'email' => 'Access denied. Admin privileges required.',
            ]);
        }
        
        RateLimiter::hit($key);
        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}