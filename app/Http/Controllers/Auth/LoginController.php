<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controllers
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
    protected $redirectTo = '/profile';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }


    public function username(){
        return 'username';
    }

	public function showLoginForm()
	{
		return view('auth.login',[
            "SEOData" => new SEOData(
                title: trans("message.login"),
                description: trans("message.parde_e_shop_seo")." | ". trans("message.login")
            )
        ]);
	}

    protected function authenticated(Request $request, $user)
    {
        return redirect()->to('/profile');
    }

    public function login(Request $request)
    {

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        if(\Auth::attempt([ 'username' => $request->username, 'password' => $request->password ])) {
            return redirect()->to('profile');
        }  else {
            $this->incrementLoginAttempts($request);
            return redirect()->back()->withErrors([
                "username" => trans("message.username_or_password_invalid"),
            ])->withInput();
        }
    }



}
