@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Edit User</h1>
            <p class="text-sm text-skin-text-muted mt-1">Update investor profile details.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-umera-600 hover:text-umera-700 dark:hover:text-umera-400 font-medium inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Users
            </a>
        </div>
    </div>

    <!-- Form -->
    <div class="bg-skin-base shadow-sm rounded-xl border border-skin-border">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                <div class="sm:col-span-2 border-b border-skin-border pb-2">
                    <h3 class="text-md font-medium text-skin-text">Basic Information</h3>
                </div>
                <div>
                    <label for="name" class="block text-sm font-medium text-skin-text">Full Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-skin-text">Email Address</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm" required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-skin-text">Phone Number</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="dob" class="block text-sm font-medium text-skin-text">Date of Birth</label>
                    <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                    @error('dob')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2">
                    <label for="address" class="block text-sm font-medium text-skin-text">Residential Address</label>
                    <textarea name="address" id="address" rows="2" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-skin-text">Account Status</label>
                    <select name="status" id="status" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                        <option value="active" {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="banned" {{ old('status', $user->status) === 'banned' ? 'selected' : '' }}>Banned</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="sm:col-span-2 border-b border-skin-border pb-2 mt-4">
                    <h3 class="text-md font-medium text-skin-text">Next of Kin Details</h3>
                </div>

                <div>
                    <label for="next_of_kin_name" class="block text-sm font-medium text-skin-text">NOK Full Name</label>
                    <input type="text" name="next_of_kin_name" id="next_of_kin_name" value="{{ old('next_of_kin_name', $user->next_of_kin_name) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                    @error('next_of_kin_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="next_of_kin_relationship" class="block text-sm font-medium text-skin-text">Relationship</label>
                    <input type="text" name="next_of_kin_relationship" id="next_of_kin_relationship" value="{{ old('next_of_kin_relationship', $user->next_of_kin_relationship) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                    @error('next_of_kin_relationship')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="next_of_kin_email" class="block text-sm font-medium text-skin-text">NOK Email</label>
                    <input type="email" name="next_of_kin_email" id="next_of_kin_email" value="{{ old('next_of_kin_email', $user->next_of_kin_email) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                    @error('next_of_kin_email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="next_of_kin_phone" class="block text-sm font-medium text-skin-text">NOK Phone</label>
                    <input type="text" name="next_of_kin_phone" id="next_of_kin_phone" value="{{ old('next_of_kin_phone', $user->next_of_kin_phone) }}" class="mt-1 block w-full rounded-md border-skin-border bg-skin-base text-skin-text shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm">
                    @error('next_of_kin_phone')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-skin-border">
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
