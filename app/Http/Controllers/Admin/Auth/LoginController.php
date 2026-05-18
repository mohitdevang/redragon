<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Admin;

class LoginController extends Controller
{
    protected $redirectTo = 'admin/dashboard';
    protected $redirectToLogin = 'admin.login';

    /**
     * Admin guard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * Show admin login form
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        /**
         * IMPORTANT:
         * Use Auth::guard('admin')->attempt()
         * This works once DB password is VALID bcrypt
         */
        if ($this->guard()->attempt([
            'email'    => $request->email,
            'password' => $request->password,
        ])) {

            $request->session()->regenerate();

            $admin = $this->guard()->user();

            $admin->update([
                'last_login_at'    => $admin->current_login_at ?? now(),
                'current_login_at' => now(),
                'last_login_ip'    => $request->ip(),
            ]);

            return redirect()->intended($this->redirectTo);
        }

        return back()->withErrors([
            'email' => 'Invalid admin credentials.',
        ])->withInput();
    }

    /**
     * Admin logout
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route($this->redirectToLogin);
    }
}
