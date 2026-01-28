@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-skin-text">System Settings</h1>
        <p class="mt-1 text-sm text-skin-text-muted">Configure global application settings.</p>
    </div>

    @if(session('success'))
        <div class="mb-6 bg-green-50 dark:bg-green-900/30 border-l-4 border-green-400 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-green-700 dark:text-green-300">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-skin-base rounded-xl border border-skin-border shadow-sm overflow-hidden">
        <form action="{{ route('admin.settings.update') }}" method="POST" class="divide-y divide-skin-border">
            @csrf
            
            <!-- General Settings -->
            <div class="p-6">
                <h3 class="text-lg font-medium text-skin-text mb-4">General Information</h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="site_name" class="block text-sm font-medium text-skin-text-muted">Site Name</label>
                        <div class="mt-1">
                            <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? config('app.name') }}" class="shadow-sm focus:ring-umera-500 focus:border-umera-500 block w-full sm:text-sm border-skin-border rounded-md bg-skin-fill text-skin-text">
                        </div>
                        <p class="mt-2 text-sm text-skin-text-muted">The name of the application displayed in titles and emails.</p>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="support_email" class="block text-sm font-medium text-skin-text-muted">Support Email</label>
                        <div class="mt-1">
                            <input type="email" name="support_email" id="support_email" value="{{ $settings['support_email'] ?? 'support@umera.com' }}" class="shadow-sm focus:ring-umera-500 focus:border-umera-500 block w-full sm:text-sm border-skin-border rounded-md bg-skin-fill text-skin-text">
                        </div>
                        <p class="mt-2 text-sm text-skin-text-muted">Email address for user support inquiries.</p>
                    </div>
                </div>
            </div>

            <!-- Financial Settings -->
            <div class="p-6">
                <h3 class="text-lg font-medium text-skin-text mb-4">Financial Configuration</h3>
                <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="currency_symbol" class="block text-sm font-medium text-skin-text-muted">Currency Symbol</label>
                        <div class="mt-1">
                            <input type="text" name="currency_symbol" id="currency_symbol" value="{{ $settings['currency_symbol'] ?? '₦' }}" class="shadow-sm focus:ring-umera-500 focus:border-umera-500 block w-full sm:text-sm border-skin-border rounded-md bg-skin-fill text-skin-text">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="min_withdrawal" class="block text-sm font-medium text-skin-text-muted">Minimum Withdrawal Amount</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-skin-text-muted sm:text-sm">₦</span>
                            </div>
                            <input type="number" name="min_withdrawal" id="min_withdrawal" value="{{ $settings['min_withdrawal'] ?? '1000' }}" class="focus:ring-umera-500 focus:border-umera-500 block w-full pl-7 sm:text-sm border-skin-border rounded-md bg-skin-fill text-skin-text">
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Control -->
            <div class="p-6">
                <h3 class="text-lg font-medium text-skin-text mb-4">System Control</h3>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="maintenance_mode" name="maintenance_mode" type="checkbox" value="1" {{ isset($settings['maintenance_mode']) && $settings['maintenance_mode'] ? 'checked' : '' }} class="focus:ring-umera-500 h-4 w-4 text-umera-600 border-skin-border rounded bg-skin-fill">
                        <!-- Hidden input to handle unchecked state -->
                        <input type="hidden" name="maintenance_mode_present" value="1"> 
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="maintenance_mode" class="font-medium text-skin-text-muted">Maintenance Mode</label>
                        <p class="text-skin-text-muted">Prevent users from accessing the dashboard while you perform updates.</p>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-skin-fill flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                    Save Settings
                </button>
            </div>
        </form>
    </div>
</div>
@endsection