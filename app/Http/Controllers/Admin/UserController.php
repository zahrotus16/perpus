<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'anggota');
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%")
                  ->orWhere('member_id', 'like', "%{$request->search}%");
            });
        }
        if ($request->status) $query->where('status', $request->status);
        $users = $query->withCount(['loans', 'activeLoans'])->latest()->paginate(15)->withQueryString();
        return \view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return \view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users',
            'phone'     => 'nullable|string|regex:/^[0-9]+$/|max:20',
            'address'   => 'nullable|string',
            'password'  => ['required', Rules\Password::defaults()],
            'member_id' => 'required|string|unique:users,member_id',
            'gender'    => 'nullable|string|max:20',
        ]);
        User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'address'   => $request->address,
            'password'  => Hash::make($request->password),
            'role'      => 'anggota',
            'member_id' => $request->member_id,
            'status'    => $request->status ?? 'active',
            'gender'    => $request->gender,
        ]);
        return redirect()->route('admin.users.index')->with('success', 'Anggota berhasil ditambahkan!');
    }

    public function show(User $user)
    {
        $user->load(['loans.book', 'reviews.book']);
        
        $loanStats = [
            'total'     => $user->loans->count(),
            'active'    => $user->loans->where('status', 'borrowed')->count(),
            'returned'  => $user->loans->where('status', 'returned')->count(),
            'overdue'   => $user->loans->where('status', 'overdue')->count(),
        ];

        return view('admin.users.show', compact('user', 'loanStats'));
    }

    public function edit(User $user)
    {
        return \view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'phone'   => 'nullable|string|regex:/^[0-9]+$/|max:20',
            'address' => 'nullable|string',
            'status'  => 'required|in:active,inactive',
            'gender'  => 'nullable|string|max:20',
        ]);
        $user->update($request->only('name', 'email', 'phone', 'address', 'status', 'gender'));
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }
        return redirect()->route('admin.users.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    public function destroy(User $user)
    {
        if ($user->activeLoans()->exists()) {
            return back()->with('error', 'Anggota tidak dapat dihapus karena masih memiliki peminjaman aktif!');
        }
        $user->delete();
        return back()->with('success', 'Anggota berhasil dihapus!');
    }

    public function resetPassword(User $user)
    {
        $newPassword = 'member123';
        $user->update(['password' => Hash::make($newPassword)]);
        return back()->with('success', "Password berhasil direset ke: {$newPassword}");
    }
}
