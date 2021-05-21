@extends('layouts.app')

<link rel="stylesheet" href="{{asset('css/Tictactoe.css')}}">


@section("content")
<div class="container-fluid">
		<div class="row">
		  <div class="col-12 col-sm-2 inform">
			<h3>
				Player <span style='color:black;'>vs</span> Computer
			</h3>
			<div class="playRules">
				<div id="playerIcons">

				</div>
			</div>
			<div class="playTurn">
				<h3 id="turn">

				</h3>
			</div>
		  </div>
		  <div class="col-12 col-sm-8 content">
			<div class="container-fluid tic-container" id="board">
			  <div class="row tic-row">
				<div class="col-4 tic-box cell c1">1</div>
				<div class="col-4 tic-box cell c2">2</div>
				<div class="col-4 tic-box cell c3">3</div>
			  </div>
			  <div class="row tic-row">
				<div class="col-4 tic-box cell c4">4</div>
				<div class="col-4 tic-box cell c5">5</div>
				<div class="col-4 tic-box cell c6">6</div>
			  </div>
			  <div class="row tic-row">
				<div class="col-4 tic-box cell c7">7</div>
				<div class="col-4 tic-box cell c8">8</div>
				<div class="col-4 tic-box cell c9">9</div>
			  </div>
			</div>
		  </div>
		  <div class="col-12 col-sm-2 inform">
				<div>
					<input id="resetBtn" type="button" name="btn" class="btn btn-danger" value="Reset">
				</div>
				<br>
				<div id="winner">
					<h2 class="retro" id="retro">Winner:</h2>
					<h4 id="winnerText" class="blue-3d-text"></h4>
				</div>
		  </div>
		</div>
	  </div>
@endsection

<script src="<?php echo asset('js/tictactoeLogic.js') ?>"></script>
<script type="module">
	import Tictactoe from "<?php echo asset('js/Tictactoe.js') ?>";
    var speechRecognition;

	window.onload = function() {
		let cells = document.getElementsByClassName("cell");
		let resetBtn = document.getElementById("resetBtn");
		generateBasicData(); // run tictactoe logic
		let tictactoe = new Tictactoe(cells, resetBtn);    
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
            tictactoe.main(event, speechRecognition);
            // Hell Yeah !
        });
        speechRecognition.addEventListener("end", speechRecognition.start);
        speechRecognition.start();
	}
</script>