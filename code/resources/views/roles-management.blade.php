@extends('layouts.master')

@section('title', 'Role Management')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('roles-menu')
</section>
@endsection
