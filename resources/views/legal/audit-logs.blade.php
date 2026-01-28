<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Audit Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-medium">System Activity Log</h3>
                            <p class="text-gray-600 text-sm mt-1">Review critical actions performed across the platform.</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                            {{ number_format($logs->total()) }} entries
                        </span>
                    </div>

                    <form method="GET" action="{{ route('legal.audit-logs.index') }}" class="mb-4 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">Action</label>
                            <select name="action" class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-umera-500 focus:ring-umera-500">
                                <option value="">All actions</option>
                                @foreach($actions as $action)
                                    <option value="{{ $action }}" @if(($filters['action'] ?? '') === $action) selected @endif>
                                        {{ str_replace('_', ' ', $action) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-600 mb-1">User</label>
                            <select name="user_id" class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-umera-500 focus:ring-umera-500">
                                <option value="">All users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" @if(($filters['user_id'] ?? '') == $user->id) selected @endif>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">From</label>
                                <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-umera-500 focus:ring-umera-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">To</label>
                                <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="block w-full rounded-md border-gray-300 text-sm shadow-sm focus:border-umera-500 focus:ring-umera-500">
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button type="submit" class="inline-flex items-center px-3 py-2 rounded-md bg-umera-600 text-white text-sm font-medium hover:bg-umera-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-umera-500">
                                Apply
                            </button>
                            <a href="{{ route('legal.audit-logs.index') }}" class="inline-flex items-center px-3 py-2 rounded-md border border-gray-300 text-sm font-medium text-gray-700 hover:bg-gray-50">
                                Reset
                            </a>
                        </div>
                    </form>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($logs as $log)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->created_at->format('M d, Y H:i') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $log->user->name ?? 'System' }}
                                            @if($log->user)
                                                <div class="text-xs text-gray-500">{{ $log->user->email }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ str_replace('_', ' ', $log->action) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if($log->subject_type && $log->subject_id)
                                                <span class="text-xs text-gray-500">{{ class_basename($log->subject_type) }} #{{ $log->subject_id }}</span>
                                            @else
                                                <span class="text-xs text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <div>{{ $log->ip_address ?? 'N/A' }}</div>
                                            @if($log->user_agent)
                                                <div class="text-xs text-gray-500 truncate max-w-xs">
                                                    {{ $log->user_agent }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @if(is_array($log->metadata) && count($log->metadata))
                                                <div class="text-xs text-gray-700">
                                                    @foreach($log->metadata as $key => $value)
                                                        <div><span class="font-semibold">{{ $key }}:</span> {{ is_scalar($value) ? $value : json_encode($value) }}</div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="text-xs text-gray-400">No extra data</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-8 text-center text-sm text-gray-500">
                                            No audit log entries found yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
