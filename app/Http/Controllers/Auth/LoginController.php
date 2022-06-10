<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Auth\Guard;

use Illuminate\Http\Request;

use App\Models\Hotelcorporatecontactbasic;

use Auth;

use Illuminate\Support\Str;

use App\Models\ProductCategories;

use Session;

class LoginController extends Controller

{

    use AuthenticatesUsers;


    protected $auth;


    protected $redirectTo = '/';


    public function __construct(Guard $auth)

    {

        $this->middleware('guest', ['except' => 'logout']);

        $this->auth = $auth;

    }

    public function login(Request $request)

    {

        $email      = $request->get('email');

        $password   = $request->get('password');

        $remember   = $request->get('remember');

        if ($this->auth->attempt([

            'email'     => $email,

            'password'  => $password

        ], $remember == 1 ? true : false)) {

             if ($this->auth->user()) { 

                    if (session_status() == PHP_SESSION_NONE) {

                    session_start();

                    }

                    $category_list = ProductCategories::get();
                    return view('panels.category_list',['category_list' => $category_list]);
                }
        }

        else {

            return redirect()->back()

                ->with('message','Incorrect email or password')

                ->with('status', 'danger')

                ->withInput();

        }

    }


public function logout(Request $request) {

    Auth::logout();   

    if (session_status() == PHP_SESSION_NONE) {

    session_start();

    }

    session_destroy();

    unset($_SESSION['oauth_state']);

    session_unset();

    Session::flush();

    return redirect('/');

}



}