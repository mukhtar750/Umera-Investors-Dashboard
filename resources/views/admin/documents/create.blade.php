<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h2 class="text-2xl font-bold text-skin-text">Upload Document</h2>
            <a href="{{ route('admin.documents.index') }}" class="text-skin-text-muted hover:text-skin-text">Back to Documents</a>
        </div>

        <div class="bg-skin-base border border-skin-border rounded-lg shadow-sm p-6">
            <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-skin-text-muted">Document Name</label>
                    <input type="text" name="name" id="name" required
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-sm font-medium text-skin-text-muted">Document Type</label>
                    <select name="type" id="type" required
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                        <option value="contract">Contract</option>
                        <option value="report">Report</option>
                        <option value="legal">Legal</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <!-- Associated Offering (Optional) -->
                <div>
                    <label for="offering_id" class="block text-sm font-medium text-skin-text-muted">Associated Offering (Optional)</label>
                    <select name="offering_id" id="offering_id"
                        class="mt-1 block w-full rounded-md border-skin-border shadow-sm focus:border-umera-500 focus:ring-umera-500 sm:text-sm bg-skin-fill text-skin-text">
                        <option value="">None (General Document)</option>
                        @foreach($offerings as $offering)
                            <option value="{{ $offering->id }}">{{ $offering->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- File -->
                <div>
                    <label for="file" class="block text-sm font-medium text-skin-text-muted">File</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-skin-border border-dashed rounded-md bg-skin-bg-alt">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-skin-text-muted" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-skin-text-muted justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-skin-base rounded-md font-medium text-umera-600 hover:text-umera-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-umera-500 px-2">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="file" type="file" class="sr-only" required>
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-skin-text-muted">
                                PDF, DOC, DOCX up to 10MB
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                        Upload Document
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>