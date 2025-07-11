@extends('layouts.master')

@section('title', 'Logbook Management')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('logbook-admin-menu')
</section>
@endsection
