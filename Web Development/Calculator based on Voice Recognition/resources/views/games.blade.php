@extends('layouts.app')

<link rel="stylesheet" href="{{asset('css/Games.css')}}">


@section("content")
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Guide</div>
                <div class="card-body text-center" style="padding:0 1.25rem 0 1.25rem;">
                    <p>
                        Great job!, Choose a game by its number
                    </p>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center text-center">
        <div class="col-md-6 col-lg-6 col-sm-6 col-12">
            <a href="{{ url('/ball') }}" class="game" discription="Bouncy Ball (1)">
                <div class="gameObject">
                    <img class="gameImg" src="https://www.mediafire.com/convkey/1b61/b99cxboax5886hfzg.jpg" alt="Bouncy Ball (1)">
                    <h5 class="gameTitle">Bouncy Ball (1)</h5>
                </div>
            </a>
        </div>
        <div class="col-md-6 col-lg-6 col-sm-6 col-12">
            <a href="{{ url('/tictactoe') }}" class="game" discription="Tic-Tac-Toe (2)">
                <div class="gameObject">
                    <img class="gameImg" src="https://www.mediafire.com/convkey/8bda/elwodebtk1qwrbczg.jpg" alt="Tic-Tac-Toe (2)">
                    <h5 class="gameTitle">Tic Tac Toe (2)</h5>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection

<script type="module">
    import Game from "<?php echo asset('js/Game.js') ?>";
    
    
    var speechRecognition;
    window.onload = function() {
        let games = document.getElementsByClassName("game");
        const gameObj = new Game(games.length, games);
    
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
            gameObj.main(event, speechRecognition);
            // Hell Yeah !
        });
        speechRecognition.addEventListener("end", speechRecognition.start);
        speechRecognition.start();
    }
</script>