<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override to use 'login' field instead of 'email'.
     */
    public function username()
    {
        return 'login';
    }

    /**
     * Get the needed authorization credentials from the request.
     */
    protected function credentials(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('psw');

        // Determine if input is email or ID/passport
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'id_or_passport';

        return [
            $field => $login,
            'password' => $password,
        ];
    }

    /**
     * Handle post-authentication logic.
     */
    protected function authenticated(Request $request, $user)
    {
        if (!$user->hasVerifiedEmail()) {
            Auth::logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'Please verify your email address before logging in.']);
        }

        return redirect()->intended($this->redirectPath());
    }
}
