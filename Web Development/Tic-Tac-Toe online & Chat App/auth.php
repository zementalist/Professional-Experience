<?php
session_start();
	$conn = new mysqli("localhost", "root", "", "mydb");
	$error_message = "";
	if($conn->connect_error) {
		die("CONNECT ERROR: " . $mysqli->connect_error);
		$error_message .= $mysqli->connect_error;
		$msg = $mysqli->connect_error;
	}
	else {
		;
	}
	/*$tableUser = "CREATE TABLE user(username TEXT, password TEXT, online TEXT)";
	$tableMsg = "CREATE TABLE msg(friendMsg TEXT, userMsg TEXT)";
	$tableUnreadMsg = "CREATE TABLE unreadMsg(friend TEXT, user TEXT)";*/
	$usersArray = array();
	if(isset($_POST['sent']) && $_POST['fname'] != "" && $_POST['fpass'] != "") {
		$usrname = $_POST['fname'];
		$usrpass = $_POST['fpass'];
		$_SESSION['usrname'] = $usrname;
		$_SESSION['password'] = $usrpass;
		$checkDupl = "SELECT * FROM user WHERE username = '" . $usrname . "'";
		$checkResult = $conn->query($checkDupl);
		if($checkResult->num_rows == 0) {
			$insertData = "INSERT INTO user(username, password, online) VALUES ('".$usrname."', '".$usrpass."', 'on')";
			$success = $conn->query($insertData);
			if($success === TRUE) {
				;
			}
			else {
				die("DATA ERROR: " . $conn->error);
				$error_message .= "   & " . $conn->error;
				$msg = 'Fuck';
				header('Location: http://localhost/login.php?msg=$msg');
			}

		}
		else {
			$checkPass = "SELECT password FROM user WHERE username = '" . $usrname ."'";
			$rightPass = $conn->query($checkPass);
			$rightPass = $rightPass->fetch_assoc();
			$rightPass = $rightPass['password'];
			if($usrpass == $rightPass) {
				$makeOnline = "UPDATE user SET online = 'on' WHERE username = '" . $usrname . "'";
				$runOnline = $conn->query($makeOnline);
				$msg = "LOGGED IN";
				$_SESSION['msg'] = $msg;
				header('Location: login.php');
			}
			else {
				$msg = "WRONG PASSWORD";
				$_SESSION['msg'] = $msg;
				header('Location: login.php');
			}
		}
	}
?>