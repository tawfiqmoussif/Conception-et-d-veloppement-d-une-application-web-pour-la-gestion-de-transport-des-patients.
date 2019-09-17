<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/overview';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
{
    if(Auth::user()->hasAnyRole("admin")){
        return '/admin'; 
    }
    if(Auth::user()->hasAnyRole("coordinateur")){
        return '/coordinateur'; 
    }
    if(Auth::user()->hasAnyRole("major") ){
        return '/major'; 
    }
    if(Auth::user()->hasAnyRole("demandeur")){
        return '/demandeur'; 
    }
 
    if(Auth::user()->hasAnyRole("brancardier") ){
        return '/brancardier'; 
    }
    if(Auth::user()->hasAnyRole("not_active")){
        return '/not_active'; 
    }
    
}
}
