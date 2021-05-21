@extends('layouts.app')
<style>
    #userText {
        text-align: center;
    }
    #header {
        background-color: cornflowerblue;
    }
    </style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-8 col-sm-8 col-lg-8">
            <div class="card">
                <div class="card-header">Guide</div>
                <div class="card-body">
                    <p><b>Solve</b> and <b>Calculate</b> your math expressions with your voice
                        An Auto-<b>Filter</b> runs when calculating an expression.
                        <br><b>Clear</b> the text to do another calculation.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-12">
            {!! Form::open(['method' => 'post', 'id' => 'myForm', "style" => "text-align:center;"]) !!}
                {!! Form::text("content", "", ['required'=>"true", 'class' => 'form-control', 'id' => 'userText','placeholder'=>'Ex: 10 + 100']) !!}
                <br>
                <input type="button" value="Calculate" class="form-control btn btn-primary" id="solveBtn" style="width:25%">
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12 col-sm-12 col-12">
            <h5>Result = <span id="result"></span></h5>
        </div>
    </div>
</div>

@endsection


<script type="module">

    import Calculator from "<?php echo asset('js/Calculator.js') ?>";
    // DELETE SCRIPT AND GO MAKE CALCULATOR.JS AND EXTEND FROM NOTE AND DO FUNCTION TO FILTER TEXT AND BE
    // READY FOR FETCHING JSON AND DATA 
    var speechRecognition;
    window.onload = function() {
        let resultElement = document.getElementById("result");
        let form = document.getElementById("myForm");
        let solveBtn = document.getElementById("solveBtn");
        const textArea = document.getElementById("userText");
        let calculator = new Calculator(resultElement);
        let p = document.createElement("p");
        textArea.appendChild(p);
        solveBtn.onclick = function() {
            calculator.solve(textArea.value);
        }
        form.onsubmit = function(e) {
            e.preventDefault();
        }
        
        if("webkitSpeechRecognition" in window){
            speechRecognition = new webkitSpeechRecognition;
        }
        else if ("speechRecognition" in window) {
            speechRecognition = new speechRecognition;
        }
        else {
            alert("SPEECH-RECOGNITION UNAVAILABLE");
        }
        speechRecognition.continuous = true;
        speechRecognition.interimResults = true;
        speechRecognition.lang = "en-US";
        speechRecognition.addEventListener("result", event => {
            calculator.main(event, speechRecognition, textArea);
        });
    
        speechRecognition.addEventListener("end", speechRecognition.start);
        speechRecognition.start();
    }
</script>