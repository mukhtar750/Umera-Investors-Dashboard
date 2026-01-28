<x-app-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    @if(auth()->user()->role === 'admin')
        @include('admin.dashboard')
    @elseif(auth()->user()->role === 'legal')
        @include('legal.dashboard')
    @else
        @include('investor.dashboard')
    @endif
</x-app-layout>
