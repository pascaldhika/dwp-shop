<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Field yang digunakan untuk login.
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

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
     * Setelah berhasil login.
     */
    protected function authenticated(Request $request, $user)
    {
        if ($user->is_active != 1) {
            Auth::logout();

            return back()->with([
                'account_deactivated' =>
                    'Your account is deactivated! Please contact with Super Admin.'
            ]);
        }

        if ($user->hasRole('admin')) {
            return redirect()->intended(RouteServiceProvider::HOME);
        } else{
            return redirect()->intended(RouteServiceProvider::SHOP);
        }
        
    }
}