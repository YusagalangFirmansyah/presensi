@extends('layouts.master')

@section('title', 'Absensi Management')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('absensi-admin-menu')
</section>
@endsection
