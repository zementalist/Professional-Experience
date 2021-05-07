<?php
session_start();
	$conn = new mysqli("localhost", "root", "", "mydb");
	$error_message = "";
	if($conn->connect_error) {
		die("CONNECT ERROR: " . $mysqli->connect_error);
		$error_message .= $mysqli->connect_error;
		$msg = $mysqli->connect_error;
	}
	$usrname;
	$usermsg;
	$friend;
	if(isset($_REQUEST['logout'])) {
		$usrname = $_SESSION['usrname'];
		$logoutMsg = $_REQUEST['logmsg'];
		$friend = isset($_SESSION['friendName']) ? $_SESSION['friendName'] : null;
		$friend = isset($friend) ? $friend : $_SESSION['oppoName'];
		$goOff = "UPDATE user SET online = 'off' WHERE username = '$usrname'";
		$conn->query($goOff);
		$checkZeroPlayers = $conn->query("SELECT playersState from tictac WHERE (username = '$usrname' OR username = '$friend') AND (turn = '$usrname' OR turn = '$friend') AND (cell = 'none')")->fetch_assoc()['playersState'];
		echo $checkZeroPlayers . "   " .gettype($checkZeroPlayers);
		if($checkZeroPlayers == 1) {
			$deleteBothPlayersGameData = "DELETE FROM tictac WHERE (username = '$usrname' OR username = '$friend') AND (turn = '$usrname' OR turn = '$friend')";
			$conn->query($deleteBothPlayersGameData);
		}
		$removeOnePlayer = "UPDATE tictac SET playersState = playersState - 1 WHERE (username = '$usrname' OR username = '$friend') AND (turn = '$usrname' OR turn = '$friend') AND cell = 'none'";
		$conn->query($removeOnePlayer);
		$_SESSION = array();
		unset($_REQUEST['logout']);
		session_destroy();
	}
	if(isset($_REQUEST['lminute'])) {
		$lastMinute = $_REQUEST['lminute'];
		$lastHour = $_REQUEST['lhour'];
		$nowMinute = $_REQUEST['nminute'];
		$nowHour = $_REQUEST['nhour'];
		if($lastHour > 0) {
			$lastseen = $lastHour;
			$storeDate = "UPDATE user SET lastseen = '" . "Last seen: " . $lastseen . " Day/s" . "' WHERE username = '" . $_SESSION['usrname'] . "'";
		}
		else if($lastMinute <= 0) {
			$lastseen = "Active Now";
			$storeDate = "UPDATE user SET lastseen = '" . $lastseen . "' WHERE username = '" . $_SESSION['usrname'] . "'";
		}
		else {
			$lastseen = $lastMinute;
			$storeDate = "UPDATE user SET lastseen = '" . "Last seen: " . $lastseen . " Minute/s" ."' WHERE username = '" . $_SESSION['usrname'] . "'";
		}
		$conn->query($storeDate);
		$selectFriendState = "SELECT lastseen FROM user WHERE username = '" . $_REQUEST['getFriendName'] . "'";
		$result = $conn->query($selectFriendState);
		$state = $result->fetch_assoc();
		$state = $state['lastseen'];
		echo '<br>' . '<span class="lastseen">'.$state. (strlen($state) == 10 ? "" :" ago"). '</span>';
		unset($_REQUEST['lminute']);
	}
	else if(isset($_REQUEST['msg'])) {
		$usermsg = $_REQUEST['msg'];
		$usrname = $_SESSION['usrname'];
		$friend = $_REQUEST['friendName'];
		$_SESSION['friendName'] = $friend;
		$select = "SELECT username, usermsg, friend FROM msg WHERE (friend ='" . $friend . "' AND username ='" . $usrname ."') OR (username ='" . $friend . "' AND friend ='" . $usrname . "')" ;
		$result = $conn->query($select);
		while($row = mysqli_fetch_array($result)) {
			if($row['username'] == $usrname) {
				echo "<p class='usrMsg'>" . $row['usermsg'] . "</p>";
			}
			else {
				echo "<p class='frndMsg'>" . $row['usermsg'] . "</p>"; 
			}
		}
		if(strlen($usermsg) > 0) {
			$insertMsg = "INSERT INTO msg(username, usermsg, friend) VALUES ('". $usrname . "', " . "'" . $usermsg . "', " . "'" . $friend . "')";
			$result = $conn->query($insertMsg);
		}
		else {
			$typing = $_REQUEST['typing'];
			$changeTyping = "UPDATE user SET typing = '" . $typing . "' WHERE username = '" . $usrname . "'";
			$result = $conn->query($changeTyping);
			$selectTypingFriend = "SELECT typing FROM user WHERE username = '" . $friend . "'";
			$result = $conn->query($selectTypingFriend);
			$result = $result->fetch_assoc();
			$result = $result['typing'];
			if($result == "yes") {
				echo "<span class='typing'>typing...</span>";
			}
		}
		unset($_REQUEST['msg']);
	}
	else if(isset($_REQUEST['userStatus'])) {
		$usrname = $_REQUEST['usrname'];
		$state = $_REQUEST['userStatus'];
		$changeState = "UPDATE user SET online = '" . $state . "' WHERE username = '" . $usrname . "'";
		$result = $conn->query($changeState);
		$sql = "SELECT username, online FROM user";
		$result = mysqli_query($conn, $sql);
		while ($row = mysqli_fetch_array($result)) {
		  if($row['username'] != $usrname && $row['online'] == 'on') {
			echo "<li class='userName online'><a onclick='transferName(this.innerHTML)'>" . $row['username'] . "</a></li>";
		  }
		  else if($row['username'] != $usrname && $row['online'] == 'off') {
		  	echo "<li class='userName offline'><a onclick='transferName(this.innerHTML)'>" . $row['username'] . "</a></li>";
		  }
		}
		unset($_REQUEST['userStatus']);
	}
?>