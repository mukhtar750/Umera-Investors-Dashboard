@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Create Audience</h1>
        <a href="{{ route('admin.audiences.index') }}" class="text-skin-text-muted hover:text-skin-text">Back to List</a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
        <form action="{{ route('admin.audiences.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-skin-text-muted">Audience Name</label>
                <input type="text" name="name" id="name" required class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-skin-text-muted">Description (Optional)</label>
                <textarea name="description" id="description" rows="3" class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-umera-600 text-white rounded-lg hover:bg-umera-700 transition-colors">
                    Create Audience
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
