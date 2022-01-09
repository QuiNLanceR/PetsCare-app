<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers {
        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
    {
        if (Auth::check()) {
            if (Auth::user()->role == 'dokter') {
                $this->redirectTo = '/dokter';
                return $this->redirectTo;
            }

            if (Auth::user()->role == 'pasien') {
                $this->redirectTo = '/pasien';
                return $this->redirectTo;
            }

            if (Auth::user()->role == 'admin') {
                $this->redirectTo = '/admin';
                return $this->redirectTo;
            }
        }
        
        $this->redirectTo = '/login';
        return $this->redirectTo;
         
        // return $next($request);
    } 

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }
    
    public function logout(Request $request)
    {
        $this->performLogout($request);
        return redirect()->route('login');
    }
}
