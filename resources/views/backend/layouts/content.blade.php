@extends('backend.index')

@section('header-resources')
@endsection

@section('dashboard-content')
    @include('partials.message')
    @yield('content')
@endsection

@section('footer-script')
@endsection
