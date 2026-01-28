@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-skin-text">Import Preview</h1>
        <a href="{{ route('admin.investors.import') }}" class="text-sm text-umera-600 hover:text-umera-700">Back</a>
    </div>

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border p-6">
        <h3 class="text-lg font-medium text-skin-text mb-2">Detected Column Mappings</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
            @foreach($header as $i => $col)
                <div class="text-sm">
                    <span class="text-skin-text">{{ $col }}</span>
                    <span class="text-skin-text-muted">→</span>
                    <span class="font-medium">{{ $header_map[$i] ?? $col }}</span>
                </div>
            @endforeach
        </div>
    </div>

    @if(count($missing_optional) > 0)
    <div class="bg-amber-50 dark:bg-amber-900/20 border-l-4 border-amber-400 p-4">
        <p class="text-sm text-amber-700 dark:text-amber-200">
            Missing optional fields: {{ implode(', ', $missing_optional) }}
        </p>
    </div>
    @endif

    @if(count($errors) > 0)
    <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-400 p-4">
        <ul class="list-disc list-inside text-sm text-red-700">
            @foreach($errors as $err)
                <li>Row {{ $err['row'] }}: {{ $err['reason'] }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="bg-skin-base shadow-sm rounded-lg border border-skin-border overflow-x-auto">
        <table class="min-w-full divide-y divide-skin-border">
            <thead class="bg-skin-base-ter/50">
                <tr>
                    @foreach(array_keys($rows[0] ?? []) as $col)
                        <th class="px-6 py-3 text-left text-xs font-medium text-skin-text-muted uppercase">{{ $col }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody class="divide-y divide-skin-border">
                @foreach($rows as $r)
                    <tr>
                        @foreach($r as $col => $val)
                            <td class="px-6 py-4 text-sm text-skin-text">
                                {{ is_array($val) ? json_encode($val) : $val }}
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <form action="{{ route('admin.investors.import.store') }}" method="POST" class="flex justify-end">
        @csrf
        <input type="hidden" name="file" value="{{ $stored_path }}">
        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-umera-600 hover:bg-umera-700">
            Confirm & Start Import
        </button>
    </form>
</div>
@endsection
