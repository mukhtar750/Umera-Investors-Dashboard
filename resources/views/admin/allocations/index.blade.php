@extends('layouts.app')

@section('content')
<div class="space-y-6" x-data="{ 
    selected: [], 
    allSelected: false,
    toggleAll() {
        this.allSelected = !this.allSelected;
        if (this.allSelected) {
            this.selected = {{ $allocations->pluck('id') }};
        } else {
            this.selected = [];
        }
    },
    updateSelectAll() {
        this.allSelected = this.selected.length === {{ $allocations->count() }};
    }
}">
    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
        <h1 class="text-2xl font-bold text-skin-text">Manage Allocations</h1>
        <div class="flex items-center gap-4">
            <!-- Bulk Actions -->
            <div x-show="selected.length > 0" x-transition class="flex items-center gap-2">
                <form action="{{ route('admin.allocations.bulk-update') }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <input type="hidden" name="allocation_ids[]" x-model="selected"> <!-- This might need handling for array binding -->
                    <!-- Workaround for array binding in form submission -->
                    <template x-for="id in selected" :key="id">
                        <input type="hidden" name="allocation_ids[]" :value="id">
                    </template>
                    
                    <button type="submit" name="status" value="active" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors shadow-sm">
                        Approve Selected
                    </button>
                    <button type="submit" name="status" value="cancelled" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors shadow-sm" onclick="return confirm('Are you sure you want to reject the selected allocations? This will refund the users.')">
                        Reject Selected
                    </button>
                </form>
                <span class="text-sm text-skin-text-muted" x-text="selected.length + ' selected'"></span>
            </div>

            <a href="{{ route('admin.allocations.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-umera-600 hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500 transition-colors w-full sm:w-auto justify-center">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Assign Allocation
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-400 p-4 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
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

    <div class="bg-skin-base border border-skin-border rounded-xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-skin-border">
                <thead class="bg-skin-fill">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300 text-umera-600 shadow-sm focus:border-umera-300 focus:ring focus:ring-umera-200 focus:ring-opacity-50" 
                                @click="toggleAll()" 
                                :checked="allSelected">
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Investor</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Offering</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Amount</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Units</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-skin-text-muted uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-skin-base divide-y divide-skin-border">
                    @forelse($allocations as $allocation)
                        <tr class="hover:bg-skin-fill transition-colors" :class="{'bg-skin-fill': selected.includes({{ $allocation->id }})}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" value="{{ $allocation->id }}" x-model="selected" @click="updateSelectAll()" class="rounded border-gray-300 text-umera-600 shadow-sm focus:border-umera-300 focus:ring focus:ring-umera-200 focus:ring-opacity-50">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">{{ $allocation->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">{{ $allocation->offering->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text">₦{{ number_format($allocation->amount, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">{{ $allocation->units }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-skin-text-muted">{{ \Carbon\Carbon::parse($allocation->allocation_date)->format('M d, Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-medium rounded-full 
                                    {{ $allocation->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                                       ($allocation->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300') }}">
                                    {{ ucfirst($allocation->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($allocation->status === 'pending')
                                    <div class="flex justify-end space-x-2">
                                        <form action="{{ route('admin.allocations.update', $allocation) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="active">
                                            <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-medium" onclick="return confirm('Approve this allocation?')">Approve</button>
                                        </form>
                                        <span class="text-skin-border">|</span>
                                        <form action="{{ route('admin.allocations.update', $allocation) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 font-medium" onclick="return confirm('Reject this allocation?')">Reject</button>
                                        </form>
                                    </div>
                                @else
                                    <span class="text-skin-text-muted">Locked</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-sm text-skin-text-muted">No allocations found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
