@extends('../layouts/app')
<script src="{{asset('js/fileView.js')}}"></script>

@section('content')
<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="files">
            @if(isset($success['msg']))
                {!! Form::open(['action' => 'UploadController@index', 'method' => 'post', 'class' => 'form-inline']) !!}
                    {{ Form::text('type', $success['type'], ['class' => 'form-control', 'placeholder' => 'Secure Code', 'required', 'style' => 'display:none;']) }}
                    {{ Form::submit('Upload another ' . $success['type'], ['class' => 'btn btn-primary up-btn up-btn2']) }}
                {!! Form::close() !!}
            @endif
            <div class="row justify-content-center">
                <div class="col-md-8 col-10 col-sm-8 col-lg-8">
                @if(isset($file))
                    <div class="file-container">
                            <div class="row-centered">
                                <!--Preview -->
                                @if($file['type'] == 'Image')
                                    <div class="preview">
                                        <img src="<?php echo Storage::url('files/' . $file['type'] . '/' . $file['downloadable']) ?>" alt={{$file['name']}}>
                                        <br>
                                    </div>
                                @else
                                    <div class="preview">
                                        <i class="<?php echo $file['icon'] . ' icona' ?>" style="font-size:15vw;"></i>
                                        <br>
                                    </div>
                                @endif
                                <!-- file details +  -->
                                <div class="file-details">
                                    <br>
                                    <p class="filedata">File name: <span style="word-break:break-word;">{{$file['name']}}</span></p>
                                    <p class="filedata">File type: <span>{{$file['type']}}</span></p>
                                    <p class="filedata">File size: <span>{{$file['size']}}</span></p>
                                    <p class="filedata">Uploaded <span><?php echo $file['time'] ?></span>, by <span>{{$file['user']}}</span></p>
                                </div>
                                <!-- Download button -->
                                <div class="access-panel">
                                    <a href="<?php echo Storage::url('files/' . $file['type'] . '/' . $file['downloadable']) ?>" download="<?php echo $file['name']?>" class="btn btn-primary access">Download</a>
                                    <!-- if(image|audio|video) view btn -->
                                    @if(in_array($file['type'], array('Audio', 'Video', 'Image')))
                                    <div style="display:inline-block;width:2vw;"></div>
                                    <hr id="hr">
                                    <a href="<?php echo Storage::url('files/' . $file['type'] . '/' . $file['downloadable']) ?>" target="_blank" class="btn btn-primary access">View</a>        
                                    @endif
                                </div>
                                <br>
                            </div>
                        <div class="row justify-content-center">
                            <!-- link{readonly} + copy_link btn -->
                            <!-- secure_code + delete form\btn -->
                            <form class="form-inline">
                                <input class="form-control" type="text"  id="link" value={{ Request::root() . '/files/' . $file['id'] }} readonly>
                                <input type="button" class="btn btn-info" id="copy" value="Copy link">
                                <div id="alertZone"></div>
                            </form>
                            <div style="display: inline-block; width: 2vw;"></div>
                            {!! Form::open(['action' => ['UploadController@destroy', $file['id']], 'method' => 'delete', 'class' => 'form-inline']) !!}
                                {{ Form::text('code', ( isset($file['secureCode']) ? $file['secureCode'] : ''), ['class' => 'form-control', 'placeholder' => 'Secure Code', 'required']) }}
                                {{ Form::submit('Delete file', ['class' => 'btn btn-danger']) }}
                            {!! Form::close() !!}
                            <div>
                                @if(isset($file['info']))
                                    <div class="alert alert-info">
                                        <span>{{$file['info']}}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <a <?php $fileid = $file['id'] ?> href={{ Route('contact', compact('fileid')) }} id="repBtn">Report this file?</a>
                    </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
