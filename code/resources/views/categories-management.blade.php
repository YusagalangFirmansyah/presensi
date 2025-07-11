@extends('layouts.master')

@section('title', 'Category Management')

@push('styles')
    @livewireStyles
@endpush

@push('scripts')
    @livewireScripts
@endpush

@section('content')
<section class="section">
    @livewire('categories-menu')
</section>
@endsection
