@extends('layouts.app')
<style>
    #userText {
        height: 10rem;
    }
    #header {
        background-color: cornflowerblue;
    }
    </style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        @if(count($notes) > 0)
        <div class="col-md-4 col-4 col-sm-4 col-lg-4">
                <ol>
                    @foreach($notes as $note)
                        <li>{{substr($note->content, 0, 20) . "..." }}</li>
                    @endforeach
                </ol>
        </div>
        @endif
        <div class="col-md-8 col-8 col-sm-8 col-lg-8">
            <div class="card">
                <div class="card-header">Guide</div>
                <div class="card-body">
                    <p>You can <b>Start</b> typing, and you can <b>Open</b> any of your notes by its number,<br>
                        Also you can <b>Delete</b> the last word while you're in typing mode or <b>Delete</b> a note by its number in normal mode.<br>
                        Not to mention about stopping any process and getting a step <b>Back</b>.<br>
                        I forgot .. you can <b>Clear</b> or <b>Copy</b> the whole text of a note in typing mode. <br>
                        Have fun :)
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div id="editor" contenteditable></div>
            <div id="header">No active note.</div>
            {!! Form::open(['action' => 'noteController@store', 'method' => 'post', 'id' => 'myForm']) !!}
                {!! Form::textarea("content", "", ['required'=>"true", 'class' => 'form-control', 'id' => 'userText']) !!}
            {!! Form::close() !!}
            </div>
            <div style="visibility:hidden;">
                {!! Form::open(['action' => 'noteController@delete', 'method' => 'delete', 'id' => 'myFormDelete']) !!}
                    {!! Form::hidden("note_id", "", ['id' => 'note_id']) !!}
                    {!! Form::textarea("content", "", ['required'=>"true", 'class' => 'form-control', 'id' => 'userTextDelete']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection

<script type="module">

import Note from "<?php echo asset('js/Note.js') ?>";
// Open -> number . for editing a note
// Delete -> number. for deleting a note
// close. close the showing window for help
// Save. saving the current note to database
// Game. go to game page
let userNotes = JSON.parse(`<?php echo json_encode($notes); ?>`);
let authenticated = "<?php echo Auth::check(); ?>";
const noteObj = new Note(userNotes, authenticated);

var speechRecognition;
let currentMode = noteObj.currentMode;
window.onload = function() {
    
    console.log(noteObj.currentMode);
    let modeDocument = document.getElementById("mode");
    modeDocument.innerHTML = currentMode[currentMode.length-1];
    let p = document.createElement("p");
    const textArea = document.getElementById("userText");
    textArea.appendChild(p);

    if("webkitSpeechRecognition" in window){
        speechRecognition = new webkitSpeechRecognition;
    }
    else if ("speechRecognition" in window) {
        speechRecognition = new speechRecognition;
    }
    else {
        alert("SPEECH-RECOGNITION UNAVAILABLE");
    }
    // see what we are saying as we are saying it
    speechRecognition.continuous = true;
    speechRecognition.interimResults = true;
    speechRecognition.lang = "en-US";
    speechRecognition.addEventListener("result", event => {
        noteObj.main(event, speechRecognition, modeDocument, textArea);
        // Hell Yeah !
    });

    speechRecognition.addEventListener("end", speechRecognition.start);
    speechRecognition.start();
}
</script>
    