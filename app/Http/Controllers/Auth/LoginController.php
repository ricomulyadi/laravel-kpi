<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (! $user || ! $user->is_active) {
            return back()
                ->withErrors([
                    'username' => 'Username atau password salah, atau akun tidak aktif.',
                ])
                ->onlyInput('username');
        }

        if (! Auth::attempt($credentials)) {
            return back()
                ->withErrors([
                    'username' => 'Username atau password salah, atau akun tidak aktif.',
                ])
                ->onlyInput('username');
        }

        $request->session()->regenerate();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'lead' => redirect()->route('lead.dashboard'),
            'anggota' => redirect()->route('anggota.dashboard'),
            default => $this->logoutInvalidRole($request),
        };
    }

    private function logoutInvalidRole(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->withErrors([
                'username' => 'Role akun belum valid. Hubungi administrator.',
            ]);
    }

    public function destroy(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
