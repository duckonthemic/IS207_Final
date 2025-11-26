<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $role = $request->input('role');

        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate($perPage)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the user details.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', [User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_MODERATOR]),
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Thông tin người dùng đã được cập nhật');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Bạn không thể xóa chính mình');
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Người dùng đã được xóa');
    }

    /**
     * Mark a user's email as verified.
     */
    public function markVerified(User $user): RedirectResponse
    {
        if ($user->email_verified_at) {
            return back()->with('info', 'Email đã được xác minh trước đó');
        }

        $user->email_verified_at = now();
        $user->save();

        return back()->with('success', 'Email người dùng đã được đánh dấu là đã xác minh');
    }
}
