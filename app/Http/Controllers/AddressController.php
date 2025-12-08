<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $addresses = Auth::user()->addresses()->latest()->get();
        return view('profile.addresses.index', compact('addresses'));
    }

    public function create()
    {
        return view('profile.addresses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => 'nullable|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line' => 'required|string',
            'is_default' => 'boolean',
        ]);

        $validated['label'] = $validated['label'] ?? 'Home';
        $validated['user_id'] = Auth::id();
        $validated['is_default'] = $request->boolean('is_default');

        // If setting as default, unset other defaults
        if ($validated['is_default']) {
            Auth::user()->addresses()->update(['is_default' => false]);
        }

        // If this is the first address, make it default
        if (Auth::user()->addresses()->count() === 0) {
            $validated['is_default'] = true;
        }

        $address = UserAddress::create($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Địa chỉ đã được thêm thành công!');
    }

    public function edit(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        return view('profile.addresses.edit', compact('address'));
    }

    public function update(Request $request, UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'label' => 'nullable|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address_line' => 'required|string',
            'is_default' => 'boolean',
        ]);

        $validated['label'] = $validated['label'] ?? $address->label ?? 'Home';
        $validated['is_default'] = $request->boolean('is_default');

        if ($validated['is_default']) {
            Auth::user()->addresses()
                ->where('id', '!=', $address->id)
                ->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')
            ->with('success', 'Địa chỉ đã được cập nhật!');
    }

    public function destroy(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        if ($address->is_default && Auth::user()->addresses()->count() > 1) {
            $newDefault = Auth::user()->addresses()
                ->where('id', '!=', $address->id)
                ->first();
            $newDefault->update(['is_default' => true]);
        }

        $address->delete();

        return redirect()->route('addresses.index')
            ->with('success', 'Địa chỉ đã được xóa!');
    }

    public function setDefault(UserAddress $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->setAsDefault();

        return response()->json(['success' => true, 'message' => 'Đã đặt làm địa chỉ mặc định!']);
    }
}
