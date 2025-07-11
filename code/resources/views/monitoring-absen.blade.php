@extends('layouts.master')

@section('title', 'Monitoring Absence')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('monitoring-absence')
</section>
@endsection
