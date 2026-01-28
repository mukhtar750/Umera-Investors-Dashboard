@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">Import Investors</h1>
            <p class="text-sm text-skin-text-muted mt-1">Bulk create investor accounts and historical investments.</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.users.index') }}" class="text-sm text-umera-600 hover:text-umera-700 dark:hover:text-umera-400 font-medium inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                Back to Investors
            </a>
        </div>
    </div>

    <!-- Warning Banner -->
    <div class="bg-umera-50 dark:bg-umera-900/40 border-l-4 border-umera-500 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-umera-600 dark:text-umera-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-umera-900 dark:text-umera-100">
                    <strong class="font-medium">Warning:</strong> Bulk import affects legal, financial, and investor records. Ensure data accuracy before processing.
                </p>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-green-700 dark:text-green-200">{{ session('success') }}</p>
                @if(session('error_list'))
                    <ul class="mt-2 list-disc list-inside text-sm text-red-600 dark:text-red-400">
                        @foreach(session('error_list') as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-red-700 dark:text-red-200">{{ session('error') }}</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Import Form -->
    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
        <form action="{{ route('admin.investors.import.preview') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-skin-text">Import File</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-skin-border border-dashed rounded-md hover:border-umera-500 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-skin-text-muted" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-skin-text-muted">
                            <label for="file-upload" class="relative cursor-pointer bg-skin-base rounded-md font-medium text-umera-600 hover:text-umera-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-umera-500">
                                <span>Upload a file</span>
                                <input id="file-upload" name="file" type="file" class="sr-only" accept=".csv,.txt,.xlsx,.xls">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-skin-text-muted">
                            CSV, Excel (.xlsx, .xls) up to 10MB
                        </p>
                    </div>
                </div>
                @error('file')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-skin-base-ter rounded-md p-4">
                <h3 class="text-sm font-medium text-skin-text mb-2">File Header Guidance (CSV or Excel)</h3>
                <p class="text-xs text-skin-text-muted mb-2">
                    Headers are mapped flexibly. Required: Email and either Full Name or First Name + Last Name.
                    Common headers recognized include:
                </p>
                <code class="block w-full bg-skin-base p-2 rounded border border-skin-border text-xs text-skin-text-muted overflow-x-auto">
                    email | e-mail<br>
                    full_name | name OR first_name + last_name<br>
                    phone | contact number | mobile<br>
                    land_name | land | project | offering<br>
                    block_name | unit_number<br>
                    investment_amount | amount invested<br>
                    investment_date | year/month<br>
                    total_paid | amount paid<br>
                    roi_percentage | roi<br>
                    Year 1, Year 2, Year 3 (yearly payments)
                </code>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                    Preview Import
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
