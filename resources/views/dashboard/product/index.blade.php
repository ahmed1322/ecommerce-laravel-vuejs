@extends('layouts.dashboard')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard/dataTables.bootstrap.min.css') }}">
@endsection

@section('dashboard')
    <seller-products seller_products_route={{ route('api.products.index') }}></seller-products>
@endsection

@section('scripts')
    <script src="{{ asset('js/dashboard/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dashboard/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/app-vue.js') }}"></script>
@endsection
