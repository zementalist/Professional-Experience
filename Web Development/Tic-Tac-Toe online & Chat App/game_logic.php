<?php
session_start();
	$conn = new mysqli("localhost", "root", "", "mydb");
	$error_message = "";
	if($conn->connect_error) {
		die("CONNECT ERROR: " . $mysqli->connect_error);
		$error_message .= $mysqli->connect_error;
		$msg = $mysqli->connect_error;
	}
	$changeTurn = isset($changeTurn) ? $changeTurn : $_SESSION['playerTurn'];
	$cells = array("cell c1", "cell c2", "cell c3", "cell c4", "cell c5", "cell c6", "cell c7", "cell c8", "cell c9");
	$usrname = $_SESSION['usrname'];
	$oppoName = $_SESSION['friendName'];
	$imgNames = array("./assets/x.png", "./assets/o.png");
	$userIcon;
	$oppoIcon;
	$playerNames = array($usrname, $oppoName);

	function setBasicData($usrname, $oppoName, $imgNames, $playerNames, $conn) {
		$checkPrevData = $conn->query("SELECT * from tictac WHERE username = '$usrname' OR username = '$oppoName'");
		if($checkPrevData->num_rows == 1) {
			$playersNumber = $conn->query("SELECT playersState FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'")->fetch_assoc()['playersState'];
			if(isset($_SESSION['playerNumber'])) {
				if($playersNumber < 2 && $_SESSION['playerNumber'] != 1) {
					// if one player is absent and this one here is player 0
					$userIcon = $conn->query("SELECT userIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['userIcon'];
					$_SESSION['userIcon'] = $userIcon;
					$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['oppoIcon'];
					$_SESSION['oppoIcon'] = $oppoIcon;
					$playerTurn = $conn->query("SELECT turn from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['turn'];
					$_SESSION['playerTurn'] = $playerTurn;
					$icrementPlayers = "UPDATE tictac SET playersState = playersState + 1 WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'";
					$conn->query($icrementPlayers);
				}
				else {
					// players are ready, get turn
					$playerTurn = $conn->query("SELECT turn from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['turn'];
					$_SESSION['playerTurn'] = $playerTurn;
				}
			}
			else {
				if($playersNumber < 2) {
					// if player is first-time join and hasn't a number yet, get a data for him
					$userIcon = $conn->query("SELECT userIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['userIcon'];
					$_SESSION['userIcon'] = $userIcon;
					$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['oppoIcon'];
					$_SESSION['oppoIcon'] = $oppoIcon;
					$playerTurn = $conn->query("SELECT turn from tictac WHERE username = (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['turn'];
					$_SESSION['playerTurn'] = $playerTurn;
					$icrementPlayers = "UPDATE tictac SET playersState = playersState + 1 WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'";
					$conn->query($icrementPlayers);
					$_SESSION['playerNumber'] = $conn->query("SELECT playersState FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'")->fetch_assoc()['playersState'];
				}
			}
		}

		else if($checkPrevData->num_rows < 1) {
			// new Game
			$randomIcon = rand(0, 1);
			$randommIcon2 = $randomIcon == 0 ? 1 : 0;
			$userIcon = $_SESSION['userIcon'];
			$oppoIcon = $_SESSION['oppoIcon'];
			$playerTurn = $_SESSION['playerTurn'];
			$basicData = "INSERT INTO tictac(cell, username, oppoName, userIcon, oppoIcon, turn) VALUES('none', '" . $usrname . "', '" . $oppoName . "', '$userIcon', '$oppoIcon', '$playerTurn')";
			$result1 = $conn->query($basicData);
			$icrementPlayers = "UPDATE tictac SET playersState = playersState + 1 WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'";
			$conn->query($icrementPlayers);
		}
		echo '[' .$_SESSION['playerTurn'] .']';
	}
	function playTurn($usrname, $oppoName, $userIcon, $oppoIcon, $cell, $value, $changeTurn,$conn) {
		$playersNumber = $conn->query("SELECT playersState FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'")->fetch_assoc()['playersState'];
		$changeTurn = $oppoName;
		$_SESSION['playerTurn'] = $changeTurn;
		$value = $_SESSION['playerNumber'] == 1 ? $_SESSION['userIcon'] : $_SESSION['oppoIcon'];
		$insertTurn = "INSERT INTO tictac(cell, value, username, opponame, userIcon, oppoIcon, playersState, turn) VALUES('$cell', '$value', '$usrname', '$oppoName', '$userIcon', '$oppoIcon', '$playersNumber', '$changeTurn')";
		$result = $conn->query($insertTurn);
		echo "<img class='imgCard' src='$value'>";
	}
	function resetData($usrname, $oppoName, $userIcon, $oppoIcon ,$conn) {
		$imgNames = array("./assets/x.png", "./assets/o.png");
		$playerNames = array($_SESSION['usrname'], $_SESSION['friendName']);
		$randomIcon = rand(0, 1);
		$randommIcon2 = $randomIcon == 0 ? 1 : 0;
		$_SESSION['userIcon'] = $imgNames[$randomIcon];
		$_SESSION['oppoIcon'] = $imgNames[$randommIcon2];
		$_SESSION['playerTurn'] = $playerNames[$randomIcon];
		$playerTurn = $_SESSION['playerTurn'];
		$resetStatement = "DELETE FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'";
		$result = $conn->query($resetStatement);
		$basicData = "INSERT INTO tictac(cell, username, oppoName, userIcon, oppoIcon, turn) VALUES('none', '" . $usrname . "', '" . $oppoName . "', '$userIcon', '$oppoIcon', '$playerTurn')";
		$result1 = $conn->query($basicData);
	}
	function checkReset($usrname, $oppoName, $conn) {
		$checkStatement = "SELECT * FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'";
		$result = $conn->query($checkStatement);
		if($result->num_rows > 1) {
			return "false";
		}
		else {
			echo "true";
			return "true";
		}
	}
	function refreshSquares($usrname, $oppoName, $cells, $changeTurn, $conn) {
		$pt;
		$checkTurnProgress = $conn->query("SELECT * from tictac WHERE username = '$usrname' OR username = '$oppoName'");
		if($checkTurnProgress->num_rows != 0) {
			if($checkTurnProgress->num_rows % 2 != 0) {
				$pt = $conn->query("SELECT turn from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND cell = 'none'")->fetch_assoc()['turn'];
			}
			else {
				$pt = $conn->query("SELECT turn from tictac WHERE (username = '$usrname' OR username = '$oppoName') ORDER BY cell ASC LIMIT 1")->fetch_assoc()['turn'];
				
			}
		}
		$_SESSION['playerTurn'] = $pt;
		echo $_SESSION['playerTurn'];
		echo $_SESSION['playerNumber'] . "p" ." [" . $_SESSION['playerTurn'] .']' . $_SESSION['userIcon'];
		echo "<tr>";
		for($i = 1; $i <= 9; $i++) {
			$elementFound = true;
			$squares = "SELECT cell, value FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName' ORDER BY cell ASC";
			$result = $conn->query($squares);
			for($j = 0; $j < $result->num_rows; $j++) {
				$row = mysqli_fetch_array($result);
				$rowCell = $row['cell'];
				$rowValue = $row['value'];
				if(in_array($cells[$i-1], $row)) {
					echo '<td class="'. $rowCell .'" onclick="play(this)">
					<img class="imgCard" src="' . $rowValue . '">
				</td>';
				$elementFound = true;
				break;
				}
				else {
					$elementFound = false;
				}
			}
			if(!$elementFound) {
				echo '<td class="' . $cells[$i-1]. '" onclick="play(this)"></td>';
			}
			echo ($i == 3 || $i == 6 ? "</tr>" : "");
		}
	}
	function RUN($usrname, $oppoName, $imgNames, $playerNames ,$cells, $changeTurn, $userIcon, $oppoIcon, $conn) {
		if(isset($_REQUEST['setData'])) {
			setBasicData($usrname, $oppoName, $imgNames, $playerNames, $conn);
			$playerTurnExist = $conn->query("SELECT playersState from tictac WHERE (username = '$usrname' OR username = '$oppoName')");
			if($playerTurnExist->num_rows == 1 && !isset($_SESSION['playerTurn'])) {
				$_SESSION['playerTurn'] = $conn->query("SELECT turn from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['turn'];
			}
			$userIcon = $conn->query("SELECT userIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['userIcon'];
			$_SESSION['userIcon'] = $userIcon;
			$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['oppoIcon'];
			$_SESSION['oppoIcon'] = $oppoIcon;
			if($oppoIcon == $userIcon) {
				if($userIcon == "./assets/x.png") {
					$swapIcon = $conn->query("UPDATE tictac SET oppoIcon = './assets/o.png' WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'");
					$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['oppoIcon'];
					$_SESSION['oppoIcon'] = $oppoIcon;
				}
				else if ($userIcon == "./assets/o.png") {
					$swapIcon = $conn->query("UPDATE tictac SET oppoIcon = './assets/x.png' WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'");
					$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['oppoIcon'];
					$_SESSION['oppoIcon'] = $oppoIcon;
				}
			}
			$playersNumber = $conn->query("SELECT playersState FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'")->fetch_assoc()['playersState'];
			$_SESSION['playerNumber'] = ((($playersNumber == 1 || $playersNumber == 2) && !isset($_SESSION['playerNumber'])) ? $playersNumber : $_SESSION['playerNumber']);
			if($_SESSION['playerNumber'] == 1) {
				$userIcon = $_SESSION['userIcon'];
				$oppoIcon = $_SESSION['oppoIcon'];
				echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
			}
			else if ($_SESSION['playerNumber'] == 2) {
				$userIcon = $_SESSION['oppoIcon'];
				$oppoIcon = $_SESSION['userIcon'];
				echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
			}
			else {
				echo "<h4 style='color:red;'>You've Refreshed the page while the game is running, if you want to play again please click the button (reset)</h4>";
			}
			unset($_REQUEST['setData']);
		}
		if(isset($_REQUEST['cell']) && $_SESSION['playerTurn'] == $_SESSION['usrname']) {
			$cell = $_REQUEST['cell'];
			$value = $_SESSION['userIcon'];
			$userIcon = $_SESSION['userIcon'];
			playTurn($usrname, $oppoName, $_SESSION['userIcon'], $_SESSION['oppoIcon'], $cell, $value, $changeTurn,$conn);
		}
		if(isset($_REQUEST['refresh'])) {
			$squares = "SELECT cell, value FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'";
			$result = $conn->query($squares);
			if($result->num_rows > 1) {
				refreshSquares($usrname, $oppoName, $cells, $changeTurn, $conn);
			}
		}
		if(isset($_REQUEST['check'])) {
			if(checkReset($usrname, $oppoName, $conn) == "true") {
				$userIcon = $conn->query("SELECT userIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND (cell = 'none')")->fetch_assoc()['userIcon'];
				$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE (username = '$usrname' OR username = '$oppoName') AND cell = 'none'")->fetch_assoc()['oppoIcon'];
				if($oppoIcon == $userIcon) {
					if($userIcon == "./assets/x.png") {
						$swapIcon = $conn->query("UPDATE tictac SET oppoIcon = './assets/o.png' WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'");
						$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['oppoIcon'];
						$_SESSION['oppoIcon'] = $oppoIcon;
					}
					else if ($userIcon == "./assets/o.png") {
						$swapIcon = $conn->query("UPDATE tictac SET oppoIcon = './assets/x.png' WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'");
						$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['oppoIcon'];
						$_SESSION['oppoIcon'] = $oppoIcon;
					}
				}
				$playersNumber = $conn->query("SELECT playersState FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'")->fetch_assoc()['playersState'];
				$_SESSION['playerNumber'] = ((($playersNumber == 1 || $playersNumber == 2) && !isset($_SESSION['playerNumber'])) ? $playersNumber : $_SESSION['playerNumber']);
				if($_SESSION['playerNumber'] == 1) {
					$userIcon = $_SESSION['userIcon'];
					$oppoIcon = $_SESSION['oppoIcon'];
					echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
				}
				else if ($_SESSION['playerNumber'] == 2) {
					$userIcon = $_SESSION['oppoIcon'];
					$oppoIcon = $_SESSION['userIcon'];
					echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
				}
				else {
					echo "<h4 style='color:red;'>You've Refreshed the page while the game is running, if you want to play again please click on the button (reset)</h4>";
				}
			}
			else {

				if($_SESSION['playerNumber'] == 1) {
					$userIcon = $_SESSION['userIcon'];
					$oppoIcon = $_SESSION['oppoIcon'];
					echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
				}
				else if ($_SESSION['playerNumber'] == 2) {
					$userIcon = $_SESSION['oppoIcon'];
					$oppoIcon = $_SESSION['userIcon'];
					echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
				}
				else {
					echo "<h4 style='color:red;'>You've Refreshed the page while the game is running, if you want to play again please click on the button (reset)</h4>";
				}
			}
			unset($_REQUEST['check']);
		}
		if(isset($_REQUEST['reset'])) {
			resetData($usrname, $oppoName, $_SESSION['userIcon'], $_SESSION['oppoIcon'],$conn);
			setBasicData($usrname, $oppoName, $imgNames, $playerNames, $conn);
			$userIcon = $conn->query("SELECT userIcon from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['userIcon'];
			$_SESSION['userIcon'] = $userIcon;
			$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['oppoIcon'];
			$_SESSION['oppoIcon'] = $oppoIcon;
			if($oppoIcon == $userIcon) {
				if($userIcon == "./assets/x.png") {
					$swapIcon = $conn->query("UPDATE tictac SET oppoIcon = './assets/o.png' WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'");
					$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['oppoIcon'];
					$_SESSION['oppoIcon'] = $oppoIcon;
				}
				else if ($userIcon == "./assets/o.png") {
					$swapIcon = $conn->query("UPDATE tictac SET oppoIcon = './assets/x.png' WHERE cell = 'none' AND username = '$usrname' OR username = '$oppoName'");
					$oppoIcon = $conn->query("SELECT oppoIcon from tictac WHERE username = '$usrname' OR username = '$oppoName'")->fetch_assoc()['oppoIcon'];
					$_SESSION['oppoIcon'] = $oppoIcon;
				}
			}
			$playersNumber = $conn->query("SELECT playersState FROM tictac WHERE turn = '$usrname' OR turn = '$oppoName'")->fetch_assoc()['playersState'];
			$_SESSION['playerNumber'] = ((($playersNumber == 1 || $playersNumber == 2) && !isset($_SESSION['playerNumber'])) ? $playersNumber : $_SESSION['playerNumber']);
			if($_SESSION['playerNumber'] == 1) {
				$userIcon = $_SESSION['userIcon'];
				$oppoIcon = $_SESSION['oppoIcon'];
				echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
			}
			else if ($_SESSION['playerNumber'] == 2) {
				$userIcon = $_SESSION['userIcon'];
				$oppoIcon = $_SESSION['oppoIcon'];
				echo "<h4>You : <img src='$userIcon' style='width:15px;height:15px;'></h4><br><h4>$oppoName : <img src='$oppoIcon' style='width:15px;height:15px;'></h4>";
			}
			else {
				echo "<h4 style='color:red;'>You've Refreshed the page while the game is running, if you want to play again please click on the button (reset)</h4>";
			}
		}
	}
	RUN($usrname, $oppoName, $imgNames, $playerNames, $cells, $changeTurn, $_SESSION['userIcon'], $_SESSION['oppoIcon'],$conn);
?>