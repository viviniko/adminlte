@extends('layouts.master')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Welcome to this beautiful admin panel.</p>
@stop

@push('js')
    <script> console.log('Hi!'); </script>
@endpush