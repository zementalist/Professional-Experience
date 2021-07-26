@extends('../layouts/app')
<script src="{{asset('js/fileUpload.js')}}"></script>

@section('content')
<div id="asyncAlert"></div>
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="process" id="drop_zone">
            <div class="row justify-content-center">
                <div class="col-md-8 col-12 col-sm-10 col-lg-8">
                    <div class="process-container">
                        <!-- FORM -->
                        {!! Form::open(['action' => 'UploadController@upload', 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'myForm', 'accept-charset' => 'utf-8']) !!}
                            <div class="row">
                                <div class="col-md-3 col-sm-3 col-3 col-lg-3">
                                    {{ csrf_field() }}
                                    {{ Form::label('name', 'Name:') }}
                                    <br>
                                    {{ Form::label('file', 'File:', ['id' => 'fileLabel']) }}
                                    <br>
                                    {{ Form::label('radio', 'Keep file for:') }}
                                </div>
                                <div class="col-md-6 col-sm-6 col-6 col-lg-6">
                                    {{ Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter your name (optional)']) }}            

                                    {{ Form::file('file', ['style' => 'display:none', 'id' => 'file', 'required' => 'true', 'accept' => $fileDetails['type'] . '/*', 'maxSize' => $fileDetails['maxSize']]) }}
                                    {{ Form::label('file', 'Choose file', ['class' => 'btn btn-info choose-btn']) }} <span id="filename"></span>
                                    <br>
                                    {{ Form::radio('duration', '0', true) }} <div style="display:inline-block;">4 hours</div><br>
                                    {{ Form::radio('duration', '1', false,['style' => 'margin-top:-1rem;']) }} <div style="display:inline-block;">1 day</div>
                                    <div class="loader-container"></div>
                                    <br>
                                    <div class="progress-container">
                                        <div class="progress-bar">0%</div>
                                    </div>
                                    <input type="text" name="type" readonly value={{$fileDetails['type']}} style="display:none;">
                                    <div class="up-btn-container">
                                        {{ Form::submit('Upload', ['class' => 'btn btn-primary', 'style'=>'width:75%', 'id' => 'uploadBtn']) }}
                                    </div>
                                </div>
                                <div class="col-md-3 col-3"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-12 col-lg-12">
                                    <div id="drop-cover">
                                        Drag & Drop a File Here
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        <div class="row">
                            <div class="col-md-6 col-6 col-sm-6 col-offset-6 mx-auto">
                                <div class="alert alert-info">
                                    Max size to upload : <span style="font-weight:bold;">{{ round($fileDetails['maxSize'] / 1000) . ' MB'}}</span>
                                </div>
                                <div class="alert alert-info">
                                    File Extension must be one of : <span style="font-weight:bold;">{{implode(', ',$fileDetails['possibleExtn'])}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
