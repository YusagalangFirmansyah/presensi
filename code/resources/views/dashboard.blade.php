@extends('layouts.master')

@section('title', 'Dashboard')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>

    <div class="section-body">
        @livewire('welcome-dashboard')
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                @livewire('count-absence')
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                @livewire('count-presence')
            </div>
            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                @livewire('count-logbook')
            </div>
        </div>
        @if (auth()->user()->role->id == '1')
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                @livewire('count-general-user')
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                @livewire('count-role')
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                @livewire('count-category')
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                @livewire('count-division')
            </div>
        </div>
        @livewire('count-admin')
        @endif
    </div>
</section>
@endsection
