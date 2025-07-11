@extends('layouts.master')

@section('title', 'Absensi Menu')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('absensi-menu')
</section>
@endsection
