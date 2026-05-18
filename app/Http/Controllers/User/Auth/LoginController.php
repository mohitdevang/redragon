<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    protected $redirectTo = 'profile';
    protected $redirectToLogin = 'userlogin';



public function login(Request $request)
{
    $request->validate([
        'unique_id' => ['required', 'string'],
        'password'  => ['required'],
    ]);

    if (Auth::attempt([
        'unique_id' => $request->unique_id,
        'password'  => $request->password,
    ])) {

        $request->session()->regenerate();

        $user = Auth::user();

        $user->update([
            'last_login_at'    => $user->current_login_at ?? now(),
            'current_login_at' => now(),
            'last_login_ip'    => $request->ip(),
        ]);

        return redirect()->intended('profile');
    }
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($this->redirectToLogin);
    }

    public function showUserLoginForm()
{
    return view('page_templates.login'); // change view path if needed
}
}
