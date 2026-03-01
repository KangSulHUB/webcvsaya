<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $expectedUsername = env('ADMIN_USERNAME', 'admin');
        $expectedPassword = env('ADMIN_PASSWORD', 'admin123');

        if (
            hash_equals($expectedUsername, $validated['username'])
            && hash_equals($expectedPassword, $validated['password'])
        ) {
            $request->session()->regenerate();
            $request->session()->put('is_admin', true);

            return redirect()->route('admin.projects');
        }

        return back()
            ->withErrors(['login' => 'Username atau password salah.'])
            ->onlyInput('username');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('project');
    }
}
