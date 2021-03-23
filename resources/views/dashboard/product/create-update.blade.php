@extends('layouts.dashboard')

@section('styles')
@endsection

@section('dashboard')
    <h1>Hello {{ auth()->user()->name }}</h1>
@endsection
