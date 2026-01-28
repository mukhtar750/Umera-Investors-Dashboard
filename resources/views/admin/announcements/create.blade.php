@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Create Announcement</h1>
        <a href="{{ route('admin.announcements.index') }}" class="text-sm text-skin-text-muted hover:text-skin-text">Back to Announcements</a>
    </div>

    <div class="bg-skin-base border border-skin-border rounded-lg shadow-sm p-6">
        <form action="{{ route('admin.announcements.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-skin-text-muted">Title</label>
                <input type="text" name="title" id="title" required
                    class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-sm font-medium text-skin-text-muted">Content</label>
                <textarea name="content" id="content" rows="6" required
                    class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text"></textarea>
            </div>

            <!-- Published -->
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="is_published" name="is_published" type="checkbox" value="1"
                        class="focus:ring-umera-500 h-4 w-4 text-umera-600 border-skin-border rounded bg-skin-fill">
                </div>
                <div class="ml-3 text-sm">
                    <label for="is_published" class="font-medium text-skin-text-muted">Publish immediately</label>
                    <p class="text-skin-text-muted">If unchecked, this announcement will be saved as a draft.</p>
                </div>
            </div>

            <div class="flex justify-end pt-4">
                <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                    Create Announcement
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
