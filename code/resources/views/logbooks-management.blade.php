@extends('layouts.master')

@section('title', 'Log Book Management')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('logbook-menu')
</section>
@endsection
