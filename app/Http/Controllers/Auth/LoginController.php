<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Scout;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('auth.login', ['register' => !User::exists()]);
    }

    /**
     * Return the authenticated response.
     *
     * @param Request $request
     * @param User    $user
     *
     * @return mixed
     */
    public function authenticated(Request $request, $user)
    {
        return Scout::response()
            ->withoutCache()
            ->notifyWithMessage('Logged in.')
            ->redirect('/');
    }
}
