@extends('layouts.app')

@section('content')
    <h1>{{ route(Request::route()->getName()) }}</h1>
@endsection