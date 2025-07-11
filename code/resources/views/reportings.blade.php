@extends('layouts.master')

@section('title', 'Reporting DayLog')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('reporting-daylog')
</section>
@endsection
