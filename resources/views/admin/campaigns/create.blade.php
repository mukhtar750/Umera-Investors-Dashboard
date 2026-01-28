@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Create Campaign</h1>
        <a href="{{ route('admin.campaigns.index') }}" class="text-skin-text-muted hover:text-skin-text">Back to List</a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
        <form action="{{ route('admin.campaigns.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Subject -->
            <div>
                <label for="subject" class="block text-sm font-medium text-skin-text-muted">Email Subject</label>
                <input type="text" name="subject" id="subject" required class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text">
            </div>

            <!-- Audience Selection -->
            <div>
                <label for="audience_ids" class="block text-sm font-medium text-skin-text-muted">Select Audiences</label>
                <select name="audience_ids[]" id="audience_ids" multiple required class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text h-32">
                    @foreach($audiences as $audience)
                        <option value="{{ $audience->id }}">{{ $audience->name }} ({{ $audience->contacts()->count() }} contacts)</option>
                    @endforeach
                </select>
                <p class="mt-1 text-sm text-skin-text-muted">Hold Ctrl/Cmd to select multiple audiences.</p>
            </div>

            <!-- Template Selection -->
            <div>
                <label class="block text-sm font-medium text-skin-text-muted mb-2">Select Template</label>
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    @foreach($templates as $template)
                    <label class="relative cursor-pointer group">
                        <input type="radio" name="template" value="{{ $template }}" class="peer sr-only" required {{ $loop->first ? 'checked' : '' }}>
                        <div class="p-4 border rounded-lg hover:bg-skin-base-ter peer-checked:border-umera-500 peer-checked:ring-2 peer-checked:ring-umera-500 peer-checked:bg-umera-50 transition-all text-center">
                            <span class="block text-sm font-medium text-skin-text capitalize">{{ $template }}</span>
                        </div>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Content Editor -->
            <div>
                <label for="content" class="block text-sm font-medium text-skin-text-muted">Email Content</label>
                <textarea name="content" id="content" rows="10" required class="mt-1 block w-full border-skin-border rounded-md shadow-sm focus:ring-umera-500 focus:border-umera-500 sm:text-sm bg-skin-fill text-skin-text font-mono"></textarea>
                <p class="mt-1 text-sm text-skin-text-muted">HTML is supported. Use <code>@{{ $contact->first_name }}</code> to personalize.</p>
            </div>

            <div class="flex justify-between items-center pt-4 border-t border-skin-border">
                <button type="submit" formaction="{{ route('admin.campaigns.preview') }}" formtarget="_blank" class="px-4 py-2 bg-skin-base border border-skin-border text-skin-text rounded-lg hover:bg-skin-base-ter transition-colors mr-auto">
                    Preview Design
                </button>
                <div class="flex space-x-3">
                    <button type="submit" name="action" value="draft" class="px-4 py-2 bg-skin-base border border-skin-border text-skin-text rounded-lg hover:bg-skin-base-ter transition-colors">
                        Save as Draft
                    </button>
                    <button type="submit" name="action" value="send" class="px-4 py-2 bg-umera-600 text-white rounded-lg hover:bg-umera-700 transition-colors" onclick="return confirm('Are you sure you want to send this campaign immediately?');">
                        Send Now
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
