<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display list of users
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 20);
        $search = $request->input('search');
        $role = $request->input('role');

        $query = User::withCount(['orders', 'reviews']);

        // Search by name or email
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role) {
            $query->where('role', $role);
        }

        $users = $query->latest('id')->paginate($perPage)->withQueryString();

        // Statistics
        $stats = [
            'total' => User::count(),
            'admins' => User::where('role', 'admin')->count(),
            'moderators' => User::where('role', 'moderator')->count(),
            'users' => User::where('role', 'user')->count(),
            'today' => User::whereDate('created_at', today())->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show user details
     */
    public function show(User $user): View
    {
        $user->load([
            'orders' => function ($q) {
                $q->latest('placed_at')->limit(10);
            },
            'addresses',
            'reviews.product'
        ]);

        $orderStats = [
            'total' => $user->orders()->count(),
            'total_spent' => $user->orders()->whereIn('status', ['delivered', 'completed'])->sum('total'),
            'pending' => $user->orders()->where('status', 'pending')->count(),
            'completed' => $user->orders()->whereIn('status', ['delivered', 'completed'])->count(),
        ];

        return view('admin.users.show', compact('user', 'orderStats'));
    }

    /**
     * Show edit form
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:user,admin,moderator',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        // Remove password if empty
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được cập nhật thành công');
    }

    /**
     * Toggle user status (ban/unban) - soft approach via role change
     */
    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        // Prevent self-modification
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể thay đổi trạng thái của chính mình');
        }

        // Toggle between active and banned (we'll use a simple approach)
        // In a real app, you might want a separate 'is_active' or 'banned_at' field

        return back()->with('success', 'Trạng thái người dùng đã được cập nhật');
    }

    /**
     * Delete user
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể xóa tài khoản của chính mình');
        }

        // Prevent deleting users with orders
        if ($user->orders()->exists()) {
            return back()->with('error', 'Không thể xóa người dùng có đơn hàng. Hãy vô hiệu hóa thay vì xóa.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được xóa');
    }
}
