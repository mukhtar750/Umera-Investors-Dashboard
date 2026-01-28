@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">My Profile</h1>
            <p class="text-sm text-skin-text-muted mt-1">Manage your personal information and security.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 dark:bg-green-900/30 border border-green-400 dark:border-green-800 text-green-700 dark:text-green-400 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border">
        <form action="{{ route('investor.profile.update') }}" method="POST" class="p-6 space-y-8">
            @csrf
            @method('PUT')

            <!-- Personal Information -->
            <div class="space-y-6">
                <div class="border-b border-skin-border pb-2">
                    <h3 class="text-lg font-medium text-skin-text">Personal Information</h3>
                    <p class="text-xs text-skin-text-muted">Used for your investment documentation and communication.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block text-sm font-medium text-skin-text">Full Name</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-skin-text">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="block text-sm font-medium text-skin-text">Phone Number</label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="dob" class="block text-sm font-medium text-skin-text">Date of Birth</label>
                        <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('dob') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="address" class="block text-sm font-medium text-skin-text">Residential Address</label>
                        <textarea name="address" id="address" rows="3" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">{{ old('address', $user->address) }}</textarea>
                        @error('address') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Next of Kin -->
            <div class="space-y-6">
                <div class="border-b border-skin-border pb-2">
                    <h3 class="text-lg font-medium text-skin-text">Next of Kin</h3>
                    <p class="text-xs text-skin-text-muted">Emergency contact information for your portfolio.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="next_of_kin_name" class="block text-sm font-medium text-skin-text">Full Name</label>
                        <input type="text" name="next_of_kin_name" id="next_of_kin_name" value="{{ old('next_of_kin_name', $user->next_of_kin_name) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('next_of_kin_name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_relationship" class="block text-sm font-medium text-skin-text">Relationship</label>
                        <input type="text" name="next_of_kin_relationship" id="next_of_kin_relationship" value="{{ old('next_of_kin_relationship', $user->next_of_kin_relationship) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('next_of_kin_relationship') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_email" class="block text-sm font-medium text-skin-text">Email Address</label>
                        <input type="email" name="next_of_kin_email" id="next_of_kin_email" value="{{ old('next_of_kin_email', $user->next_of_kin_email) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('next_of_kin_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="next_of_kin_phone" class="block text-sm font-medium text-skin-text">Phone Number</label>
                        <input type="text" name="next_of_kin_phone" id="next_of_kin_phone" value="{{ old('next_of_kin_phone', $user->next_of_kin_phone) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('next_of_kin_phone') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Security -->
            <div class="space-y-6">
                <div class="border-b border-skin-border pb-2">
                    <h3 class="text-lg font-medium text-skin-text">Change Password</h3>
                    <p class="text-xs text-skin-text-muted">Leave blank if you don't want to change your password.</p>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="password" class="block text-sm font-medium text-skin-text">New Password</label>
                        <input type="password" name="password" id="password" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-skin-text">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-6 border-t border-skin-border">
                <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                    Save Profile Changes
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
