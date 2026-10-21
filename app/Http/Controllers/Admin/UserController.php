<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'totalUsers' => User::count(),
            'activeUsers' => User::where('is_active', true)->count(),
            'inactiveUsers' => User::where('is_active', false)->count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', Rule::in(['admin', 'lead', 'anggota'])],
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
            'is_active' => true,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => [
                'required', 'string', 'max:50', 'alpha_dash',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => ['required', Rule::in(['admin', 'lead', 'anggota'])],
        ]);

        if ($user->is(auth()->user())) {
            $validated['role'] = $user->role;
        }

        $user->update($validated);

        return back()->with('success', 'Data akun berhasil diperbarui.');
    }

    public function toggleActive(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->withErrors([
                'account' => 'Kamu tidak dapat menonaktifkan akun sendiri.',
            ]);
        }

        $user->update(['is_active' => ! $user->is_active]);

        return back()->with('success', 'Status akun berhasil diperbarui.');
    }
}
