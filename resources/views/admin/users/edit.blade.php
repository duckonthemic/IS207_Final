@extends('layouts.admin')

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-black text-cyber-white uppercase tracking-tighter">Edit User</h1>
                <p class="text-cyber-text-muted font-mono text-sm mt-1">// USER_ID: {{ $user->id }}</p>
            </div>
            <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 bg-transparent border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                Back to List
            </a>
        </div>

        <!-- Form -->
        <div class="bg-cyber-black border border-cyber-border p-6">
            @if(session('success'))
                <div class="bg-green-900 border border-green-700 text-green-200 px-4 py-3 mb-6 font-mono text-sm">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-3 mb-6 font-mono text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.users.update', $user) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <!-- User Avatar Preview -->
                <div class="flex items-center gap-4 pb-6 border-b border-cyber-border">
                    <div
                        class="w-16 h-16 bg-cyber-gray border border-cyber-border flex items-center justify-center text-cyber-white text-2xl font-bold uppercase">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="text-cyber-white font-bold">{{ $user->name }}</p>
                        <p class="text-cyber-text-muted text-sm font-mono">{{ $user->email }}</p>
                        <p class="text-cyber-text-muted text-xs mt-1">Member since {{ $user->created_at->format('M d, Y') }}
                        </p>
                    </div>
                </div>

                <!-- Name -->
                <div>
                    <label for="name"
                        class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono text-sm @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email"
                        class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Email *</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono text-sm @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone"
                        class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono text-sm @error('phone') border-red-500 @enderror">
                    @error('phone')
                        <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div>
                    <label for="role"
                        class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Role *</label>
                    <select id="role" name="role" required
                        class="w-full bg-cyber-gray border border-cyber-border text-cyber-white rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono text-sm uppercase @error('role') border-red-500 @enderror"
                        {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                        <option value="moderator" {{ old('role', $user->role) == 'moderator' ? 'selected' : '' }}>Moderator
                        </option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @if($user->id === auth()->id())
                        <input type="hidden" name="role" value="{{ $user->role }}">
                        <p class="mt-1 text-yellow-400 text-xs">You cannot change your own role</p>
                    @endif
                    @error('role')
                        <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Section -->
                <div class="pt-6 border-t border-cyber-border">
                    <h3 class="text-cyber-white font-bold uppercase tracking-wider mb-4">Change Password</h3>
                    <p class="text-cyber-text-muted text-xs mb-4">Leave blank to keep current password</p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="password"
                                class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">New
                                Password</label>
                            <input type="password" id="password" name="password"
                                class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono text-sm @error('password') border-red-500 @enderror">
                            @error('password')
                                <p class="mt-1 text-red-400 text-xs">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation"
                                class="block text-cyber-text-muted text-xs font-bold uppercase tracking-wider mb-2">Confirm
                                Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="w-full bg-cyber-gray border border-cyber-border text-cyber-white placeholder-cyber-text-muted rounded-none px-4 py-3 focus:border-cyber-white focus:outline-none transition font-mono text-sm">
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex gap-4 pt-6 border-t border-cyber-border">
                    <button type="submit"
                        class="px-6 py-3 bg-cyber-white text-cyber-black hover:bg-gray-300 transition font-bold uppercase tracking-wider text-sm">
                        Save Changes
                    </button>
                    <a href="{{ route('admin.users.show', $user) }}"
                        class="px-6 py-3 bg-transparent border border-cyber-white text-cyber-white hover:bg-cyber-white hover:text-cyber-black transition font-bold uppercase tracking-wider text-sm">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        @if($user->id !== auth()->id() && $user->orders()->count() == 0)
            <div class="bg-cyber-black border border-red-700 p-6 mt-6">
                <h3 class="text-red-400 font-bold uppercase tracking-wider mb-4">Danger Zone</h3>
                <p class="text-cyber-text-muted text-sm mb-4">Once you delete a user, there is no going back. Please be certain.
                </p>
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-2 bg-red-600 text-white hover:bg-red-700 transition font-bold uppercase tracking-wider text-sm">
                        Delete User
                    </button>
                </form>
            </div>
        @endif
    </div>
@endsection