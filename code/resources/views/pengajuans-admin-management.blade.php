@extends('layouts.master')

@section('title', 'Pengajuan Cuti dan Izin Management')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('pengajuan-admin-menu')
</section>
@endsection
