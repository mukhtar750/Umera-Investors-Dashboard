@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-skin-text">{{ $audience->name }}</h1>
            <p class="text-sm text-skin-text-muted mt-1">{{ $audience->description }}</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="document.getElementById('importModal').classList.remove('hidden')" class="px-4 py-2 bg-skin-base border border-skin-border text-skin-text rounded-lg hover:bg-skin-base-ter transition-colors">
                Import CSV
            </button>
            <a href="{{ route('admin.audiences.edit', $audience) }}" class="px-4 py-2 bg-skin-base border border-skin-border text-skin-text rounded-lg hover:bg-skin-base-ter transition-colors">
                Edit Settings
            </a>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('importModal').classList.add('hidden')"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('admin.audiences.import', $audience) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Import Contacts</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500 mb-4">Upload a CSV file with columns: <strong>Email</strong>, <strong>First Name</strong> (optional), <strong>Last Name</strong> (optional).</p>
                            <input type="file" name="file" accept=".csv,.txt" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-umera-50 file:text-umera-700 hover:file:bg-umera-100">
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-umera-600 text-base font-medium text-white hover:bg-umera-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Import
                        </button>
                        <button type="button" onclick="document.getElementById('importModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Contacts List -->
    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border overflow-hidden">
        <div class="px-6 py-4 border-b border-skin-border flex justify-between items-center bg-skin-base-ter">
            <h3 class="text-lg font-medium text-skin-text">Contacts ({{ $audience->contacts->count() }})</h3>
            <button onclick="openMoveModal()" class="text-sm text-umera-600 hover:text-umera-800 disabled:opacity-50" id="moveBtn" disabled>
                Move/Copy Selected
            </button>
        </div>
        <form id="bulkForm" method="POST" action="{{ route('admin.audiences.move-contacts', $audience) }}">
            @csrf
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-base-ter">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" onclick="toggleAll(this)" class="rounded border-gray-300 text-umera-600 shadow-sm focus:border-umera-300 focus:ring focus:ring-umera-200 focus:ring-opacity-50">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Added</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($contacts as $contact)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <input type="checkbox" name="contact_ids[]" value="{{ $contact->id }}" onchange="updateMoveBtn()" class="contact-checkbox rounded border-gray-300 text-umera-600 shadow-sm focus:border-umera-300 focus:ring focus:ring-umera-200 focus:ring-opacity-50">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-skin-text">{{ $contact->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">{{ $contact->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">{{ $contact->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('admin.audiences.remove-contact', [$audience, $contact]) }}" method="POST" class="inline-block" onsubmit="return confirm('Remove this contact from the audience?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-skin-text-muted">No contacts in this audience yet. Import a CSV to get started.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Move/Copy Modal -->
            <div id="moveModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('moveModal').classList.add('hidden')"></div>
                    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Move/Copy Contacts</h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Action</label>
                                    <select name="action_type" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-umera-500 focus:border-umera-500 sm:text-sm rounded-md">
                                        <option value="copy">Copy to another audience</option>
                                        <option value="move">Move to another audience</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Target Audience</label>
                                    <select name="target_audience_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-umera-500 focus:border-umera-500 sm:text-sm rounded-md">
                                        @foreach($otherAudiences as $other)
                                            <option value="{{ $other->id }}">{{ $other->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-umera-600 text-base font-medium text-white hover:bg-umera-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Proceed
                            </button>
                            <button type="button" onclick="document.getElementById('moveModal').classList.add('hidden')" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="px-6 py-4 border-t border-skin-border">
            {{ $contacts->links() }}
        </div>
    </div>
</div>

<script>
function toggleAll(source) {
    checkboxes = document.getElementsByClassName('contact-checkbox');
    for(var i=0, n=checkboxes.length;i<n;i++) {
        checkboxes[i].checked = source.checked;
    }
    updateMoveBtn();
}

function updateMoveBtn() {
    var checked = document.querySelectorAll('.contact-checkbox:checked').length;
    document.getElementById('moveBtn').disabled = checked === 0;
    document.getElementById('moveBtn').innerText = checked > 0 ? 'Move/Copy Selected (' + checked + ')' : 'Move/Copy Selected';
}

function openMoveModal() {
    document.getElementById('moveModal').classList.remove('hidden');
}
</script>
@endsection
