@if(count($errors) > 0)
    @foreach($errors->all() as $err)
        <div class="alert alert-danger">
            {{$err}}
        </div>
    @endforeach
@endif

@if(session('success'))
    <div class="alert alert-success session-message">
        {{session('success')}}
    </div>
@elseif(isset($success))
    <div class="alert alert-success session-message" >
        {{$success}}
    </div>
@elseif(isset($success['msg']))
    <div class="alert alert-success session-message" style="font-weight:bold;">
        {{$success['msg']}} 
    </div>
@elseif(isset($file['success']))
    <div class="alert alert-success session-message" style="font-weight:bold;">
        {{$file['success']}} 
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger session-message" >
        {{session('error')}}
    </div>
@elseif(isset($error))
    <div class="alert alert-danger session-message">
        {{$error}}
    </div>
@endif
