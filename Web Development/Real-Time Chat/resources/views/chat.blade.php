@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Chats</div>

                <div class="panel-body">
                    {{-- <chat-messages :messages="messages"></chat-messages> --}}
                </div>
                <div class="panel-footer">
                    <example-component
                        :user="{{ Auth::user() }}"
                        :token=`{{JWTAuth::fromUser(Auth::user())}}`
                    ></example-component>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection