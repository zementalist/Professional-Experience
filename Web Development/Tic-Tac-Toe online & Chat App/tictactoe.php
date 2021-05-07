<?php
session_start();
	$_SESSION['online'] = 'on';
	if(!isset($_SESSION['usrname'])) { // user is not authenticated
		header('Location: login.php');
	}
	$imgNames = array("./assets/x.png", "./assets/o.png");
	$playerNames = array($_SESSION['usrname'], $_SESSION['friendName']);
	$randomIcon = rand(0, 1);
	$randommIcon2 = $randomIcon == 0 ? 1 : 0;
	$_SESSION['userIcon'] = $imgNames[$randomIcon];
	$_SESSION['oppoIcon'] = $imgNames[$randommIcon2];

	$_SESSION['playerTurn'] = $playerNames[$randomIcon];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Tic Tac Toe</title>
	<link rel="stylesheet" type="text/css" href="./assets/bootstrap.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="fontawesome.min.css"> -->
	<style type="text/css">
		#body {
			background: -webkit-linear-gradient(right, transparent 0%,#6F0FD5 50%,transparent 80%);
		}
		table {
		  width: 100%;
		  border-collapse: collapse;
		  margin-top: 10%;
		  background-color: white;
		  -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
   		 -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
   	      box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    	  border: 0.5px solid white;
    	  cursor: pointer;
    	  z-index: 1;
    	  position: relative;
		}
		td {
		  width: 33.333%;
		  border: 6px solid #222;
		}
		td::after {
		  content: '';
		  display: block;
		  margin-top: 100%;
		}
		td {
		  border: 6px solid #222;
		}
		td:first-of-type {
		  border-left-color: transparent;
		  border-top-color: transparent;
		}
		td:nth-of-type(2) {
		  border-top-color: transparent;
		}
		td:nth-of-type(3) {
		  border-right-color: transparent;
		  border-top-color: transparent;
		}
		tr:nth-of-type(3) td {
		  border-bottom-color: transparent;
		}
		h3 {
			color: #FF7000;
			box-shadow: 2px 2px lightgray;
			margin-top: 20%;
			font-size: 28px;
		}
		img {
			position: absolute;
			margin-left: 2%;
			margin-top: 2%;
		}
		.imgCard {
			position: absolute;
			margin-left: 4%;
			margin-top: 5%;
			width: 100px;
			height: 100px;
		}
		h4 {
			color: #FFA600;
			font-size: 20px;
			box-shadow: 2px 2px lightgray;
		}
		h2 {
			color: #FFA600;
			text-align: center;
		}
		.playRules {
			margin-top: 20rem;
		}
		#winner {
			margin-top: 25rem;
			display: none;
			opacity: 0;
			transition: 0.5s;
		}
		#winner-won {
			margin-top: 25rem;
			display: block;
			opacity: 1;
			transition: 0.5s;
		}
		.retro {
		  -webkit-box-sizing: content-box;
		  -moz-box-sizing: content-box;
		  box-sizing: content-box;
		  margin: 0 auto;
		  border: none;
		  font: normal 4em/normal "Anton", Helvetica, sans-serif;
		  color: rgb(112, 112, 112);
		  text-align: center;
		  text-transform: uppercase;
		  -o-text-overflow: clip;
		  text-overflow: clip;
		  letter-spacing: 10px;
		  text-shadow: 4px 4px 0 rgb(238,238,238) , 6px 6px 0 rgb(112,112,112) ;
		}
		.blue-3d-text {
		  text-transform: uppercase;
		  box-shadow: none;
		  -webkit-box-sizing: content-box;
		  -moz-box-sizing: content-box;
		  box-sizing: content-box;
		  border: none;
		  font: normal 4em/normal "Arvo", Helvetica, sans-serif;
		  color: rgb(228, 243, 249);
		  text-align: center;
		  -o-text-overflow: clip;
		  text-overflow: clip;
		  text-shadow: -2px -2px 1px rgb(255,255,255) , -1px -1px 1px rgb(255,255,255) , 1px 1px 1px rgba(232,247,255,0.901961) , 1px 1px 0 rgb(42,101,139) , 2px 2px 0 rgb(41,99,138) , 3px 3px 0 rgb(40,97,136) , 4px 4px 0 rgb(39,95,133) , 5px 5px 0 rgb(38,93,131) , 6px 6px 0 rgb(37,90,128) , 7px 7px 0 rgb(36,87,125) , 8px 8px 0 rgb(35,84,121) , 9px 9px 0 rgb(33,80,117) , 10px 10px 0 rgb(31,76,113) , 11px 11px 0 rgb(30,72,108) , 12px 12px 1px rgba(28,67,103,0.498039) , 14px 14px 12px rgba(5,13,20,0.498039) ;
		  -webkit-transition: all 201ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		  -moz-transition: all 201ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		  -o-transition: all 201ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		  transition: all 201ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		}

		.blue-3d-text:hover {
		  text-shadow: -2px -2px 1px rgb(255,255,255) , -1px -1px 1px rgb(255,255,255) , 1px 1px 1px rgba(232,247,255,0.901961) , 2px 3px 1px rgba(28,67,103,0.498039) , 5px 5px 12px rgba(5,13,20,0.498039) ;
		  -webkit-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		  -moz-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		  -o-transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		  transition: all 200ms cubic-bezier(0.42, 0, 0.58, 1) 10ms;
		}
		#cover {
		    position: relative;
		    background: transparent;
		    opacity: 0.8;
		}
		#logBtn {
			margin: 1rem;
			font-weight: 900;
			box-shadow: 2px 2px #9b59e1;
			transition: 0.2s;
		}
		#logBtn:hover {
			margin: 1.2rem;
			box-shadow: 0px 0px white;
			transition: 0.2s;
			background-color: lightgray;
			position: fixed;
		}
	</style>
</head>
<body id="body" onload="setBasicData();intervalRefresh = setInterval(refreshSquares, 1000);setInterval(checkResetButton, 3000);">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-3 col-2"> 
						<h3>
							<?php
							  echo $_SESSION['usrname'] . " <span style='color:black;font-size:20px;'>vs</span> " . $_SESSION['friendName'];
							?>
						</h3>
						<div class="playRules">
							<div id="playerIcons">
								
							</div>
						</div>
						<div class="playTurn">
							<h3 id="turn">
								Loading...
							</h3>
						</div>
						<div>
							<input id="resetBtn" style="position: absolute; width: 50%;margin-top: 65px;" type="button" name="btn" class="btn btn-danger" value="Reset" onclick="reset()" title="Only first-joined player can reset!">
						</div>
					</div>
					<div class="col-md-6 col-8">
						<div id="cover">
							<table id="board">
								<tr>
									<td class="cell c1" onclick="play(this)"></td>
									<td class="cell c2" onclick="play(this)"></td>
									<td class="cell c3" onclick="play(this)"></td>
								</tr>
								<tr>
									<td class="cell c4" onclick="play(this)"></td>
									<td class="cell c5" onclick="play(this)"></td>
									<td class="cell c6" onclick="play(this)"></td>
								</tr>
								<tr>
									<td class="cell c7" onclick="play(this)"></td>
									<td class="cell c8" onclick="play(this)"></td>
									<td class="cell c9" onclick="play(this)"></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-md-3 col-2">
						<input type="button" name="logout" value="Log Out" class="btn btn-muted" id="logBtn" onclick="logout()"> 
						<div id="winner">
							<h2 class="retro" id="retro">Winner:</h2>
							<h4 id="winnerText" class="blue-3d-text"> <?php echo $_SESSION['usrname'] ?> </h4>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		var intervalRefresh;
		var xhttp = new XMLHttpRequest();
		var playerIcons = document.getElementById("playerIcons");
		var playerNumber;
		var usrname = "<?php echo $_SESSION['usrname']; ?>"
		var oppoName = "<?php echo $_SESSION['friendName']; ?>";
		var board = document.getElementById('board');
		var userIcon = "<?php echo $_SESSION['userIcon']; ?>";
		var oppoIcon = "<?php echo $_SESSION['oppoIcon']; ?>";
		var cover = document.getElementById("cover");
		var turn = document.getElementById("turn");
		function setBasicData() {
			var text;
			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					if(this.responseText.includes('['+usrname+']')) {
						playerTurnName = usrname;
						text = this.responseText.replace('['+usrname+']', "");
					}
					else if(this.responseText.includes('['+oppoName+']')) {
						playerTurnName = oppoName;
						text = this.responseText.replace('['+oppoName+']', "");
					}
					turn.innerHTML = (playerTurnName == usrname ? "Your turn" : playerTurnName + "'s turn");//
					playerIcons.innerHTML = text;
				}
			}
			xhttp.open("GET", "game_logic.php?setData=" + true);
			xhttp.send();
		}
		function imgType(cell) {
			var text = String(cell.innerHTML);
			if(text.includes("./assets/o.png")) {
				return "./assets/o.png";
			}
			else if(text.includes("./assets/x.png")) {
				return "./assets/x.png";
			}
			else {
				return 'none';
			}
		}
		function checkResetButton() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				var text;
				if(this.readyState == 4 && this.status == 200) {
					text = this.responseText;
					if(text.includes("true")) { // includes true if a user reset the game
						// wait for play, set rules, remove (true) to get a text with game data, clear winnerTXT, clear cells
						intervalRefresh = setInterval(refreshSquares, 1000);
						setBasicData();
						text = text.replace("true", "");
						console.log("YES INCLUDES TRUE");
						if(document.getElementById("winner-won")) {
							document.getElementById("winner-won").setAttribute("id","winner");
						}
						cover.style.background = "transparent";
						board.innerHTML = '<tr><td class="cell c1" onclick="play(this)"></td><td class="cell c2" onclick="play(this)"></td><td class="cell c3" onclick="play(this)"></td></tr><tr><td class="cell c4" onclick="play(this)"></td><td class="cell c5" onclick="play(this)"></td><td class="cell c6" onclick="play(this)"></td></tr><tr><td class="cell c7" onclick="play(this)"></td><td class="cell c8" onclick="play(this)"></td><td class="cell c9" onclick="play(this)"></td></tr>';
					}

					playerIcons.innerHTML = text;
				}
			}
			xhttp.open("GET", "game_logic.php?check=" + 'true');
			xhttp.send();
			setBasicData();
		}
		function win() {
			var winMethods = [ ['c1', 'c2', 'c3'], ['c4', 'c5', 'c6'], ['c7', 'c8', 'c9'], ['c1', 'c4', 'c7'], ['c2', 'c5', 'c8'], ['c3', 'c6', 'c9'], ['c1', 'c5', 'c9'], ['c3', 'c5', 'c7'] ];
			var userWon = 0;
			var oppoWon = 0;
			var counter = 0;
			console.log(playerNumber);
			for(var i = 0; i < winMethods.length; i++) {
				userWon = 0;
				oppoWon = 0;
				for(var j = 0; j < winMethods[i].length; j++) {
					var cell = document.getElementsByClassName(winMethods[i][j])[0];
					if(cell.innerHTML.length == 0) {
						counter++;
					}
					if(cell.innerHTML.length > 0 && imgType(cell) == userIcon && playerNumber == 1) {
						userWon++;
						if(userWon == 3) {
							document.getElementById("retro").innerHTML = "WINNER:";
							document.getElementById("winnerText").innerHTML = usrname;
							if(document.getElementById("winner")) {
								document.getElementById("winner").setAttribute("id", "winner-won");
							}
							return true;
						}
					}
					else if(cell.innerHTML.length > 0 && imgType(cell) == oppoIcon && playerNumber == 1){
						oppoWon++;
						if(oppoWon == 3) {
							document.getElementById("retro").innerHTML = "WINNER:";
							document.getElementById("winnerText").innerHTML = oppoName;
							if(document.getElementById("winner")) {
								document.getElementById("winner").setAttribute("id", "winner-won");
							}
							return true;
						}
					}
					else if(cell.innerHTML.length > 0 && imgType(cell) == userIcon && playerNumber == 2) {
						userWon++;
						if(userWon == 3) {
							document.getElementById("retro").innerHTML = "WINNER:";
							document.getElementById("winnerText").innerHTML = oppoName;
							if(document.getElementById("winner")) {
								document.getElementById("winner").setAttribute("id", "winner-won");
							}
							return true;
						}
					}
					else if(cell.innerHTML.length > 0 && imgType(cell) == oppoIcon && playerNumber == 2){
						oppoWon++;
						if(oppoWon == 3) {
							document.getElementById("retro").innerHTML = "WINNER:";
							document.getElementById("winnerText").innerHTML = usrname;
							if(document.getElementById("winner")) {
								document.getElementById("winner").setAttribute("id", "winner-won");
							}
							return true;
						}
					}
				}
			}
			if(counter == 0 && (oppoWon != 3 && userWon != 3)) {
				document.getElementById("winnerText").innerHTML = "";
				document.getElementById("retro").innerHTML = "DRAW!";
				console.log("WTF");
				if(document.getElementById("winner")) {
					document.getElementById("winner").setAttribute("id", "winner-won");
				}
				return true;
			}
			return false;
		}
		function play(cell) {
			if(cell.innerHTML == "") {
				xhttp.onreadystatechange = function() {
					if(this.readyState == 4 && this.status == 200) {
						cell.innerHTML = this.responseText;
					}
				}
				xhttp.open("GET", "game_logic.php?cell=" + cell.className + "&iconPlayed=" + userIcon);
				xhttp.send();
			}
		}
		function reset() {
			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					playerIcons.innerHTML = this.responseText;
				}
			}
			xhttp.open("GET", "game_logic.php?reset=" + true);
			xhttp.send();
			if(document.getElementById("winner-won")) {
				document.getElementById("winner-won").setAttribute("id","winner");
			}
			cover.style.background = "transparent";
			board.innerHTML = '<tr><td class="cell c1" onclick="play(this)"></td><td class="cell c2" onclick="play(this)"></td><td class="cell c3" onclick="play(this)"></td></tr><tr><td class="cell c4" onclick="play(this)"></td><td class="cell c5" onclick="play(this)"></td><td class="cell c6" onclick="play(this)"></td></tr><tr><td class="cell c7" onclick="play(this)"></td><td class="cell c8" onclick="play(this)"></td><td class="cell c9" onclick="play(this)"></td></tr>';
			intervalRefresh = setInterval(refreshSquares, 1000);
			setBasicData();
		}
		function refreshSquares() {
			var playerTurnName;
			var text;
			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					if(this.responseText.length > 0) {
						if(this.responseText.includes("1p") || this.responseText.includes("2p")) {
							if(this.responseText.includes("1p")) {
								playerNumber = 1;
								text = this.responseText.replace("1p", "");
								userIcon = text.substring(0, text.indexOf("<tr>"));
								if(userIcon.includes("./assets/x.png")) {
									userIcon = "./assets/x.png";
									oppoIcon = "./assets/o.png";
									text = text.replace(userIcon, "");
								}
								else if(userIcon.includes("./assets/o.png")) {
									userIcon = "./assets/o.png";
									oppoIcon = "./assets/x.png";
									text = text.replace(userIcon, "");
								}
							}
							else {
								playerNumber = 2;
								document.getElementById("resetBtn").setAttribute("disabled", "");
								text = this.responseText.replace("2p", "");
								userIcon = text.substring(0, text.indexOf("<tr>"));
								if(userIcon.includes("./assets/x.png")) {
									userIcon = "./assets/x.png";
									oppoIcon = "./assets/o.png";
									text = text.replace(userIcon, "");
								}
								else if(userIcon.includes("./assets/o.png")) {
									userIcon = "./assets/o.png";
									oppoIcon = "./assets/x.png";
									text = text.replace(userIcon, "");
								}
							}
						}
						if(win()) {
							clearInterval(intervalRefresh);
							cover.style.background = "gray";
						}
						if(this.responseText.includes('['+usrname+']')) {
							playerTurnName = usrname;
							text = text.replace('['+usrname+']', "");
							text = text.replace(usrname, "");
						}
						if(this.responseText.includes('['+oppoName+']')) {
							playerTurnName = oppoName;
							text = text.replace('['+oppoName+']', "");
							text = text.replace(oppoName, "");
						}
						turn.innerHTML = (playerTurnName == usrname ? "Your turn" : playerTurnName + "'s turn");//
						board.innerHTML = text;
					}
				}
			}
			xhttp.open("GET", "game_logic.php?refresh=" + true);
			xhttp.send();
		}
		function logout() {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					window.location = "login.php";
				}
			}
			xhttp.open("GET", "messages.php?logout=" + true + "&logmsg=" + "logged out successfuly");
			xhttp.send();
		}
	</script>
</body>
</html>
