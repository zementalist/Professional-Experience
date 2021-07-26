@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
            <div class="access-panel">
                <access-control></access-control>
            </div>
    </div>
@endsection

<style>
    body {
        min-height: 100%;
    }
    .access-panel {
        min-height: 100%;
        min-width: 100%;
    }
    </style>