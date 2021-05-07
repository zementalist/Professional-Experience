<?php
session_start();
	$_SESSION['online'] = 'on';
	if(!isset($_SESSION['usrname'])) {
		header('Location: login.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Chat</title>
	<link rel="stylesheet" type="text/css" href="./assets/bootstrap.min.css">
	<!-- <link rel="stylesheet" type="text/css" href="fontawesome.min.css"> -->
	<style type="text/css">
		.frame {
			margin-top: 20%;
			background-color: #1BB8F3;
			height: 120%;
			width: 100%;
			border: 1px solid blue;
		}
		#body {
			background:  -webkit-linear-gradient(right, transparent 0%,#6F0FD5 50%,transparent 80%);
		}
		.friendsList {
			width: 100%;
			height: 300%;
			background-color: white;
			border: 1px solid black;
			box-shadow: 2px -2px white;
			border-radius: 12.5%;
			margin-top: 10%;
		}
		.offline:after {
		    /*Bullet symbol code */
		    content: '\2022';
		    /* Bullet color */
		    color: gray;
		    font-size: 25px;
		    padding-right: 0.3em;
		    text-shadow: 1px 1px grey;
		}
		.online:after {
		    /*Bullet symbol code */
		    content: '\2022';
		    /* Bullet color */
		    color: lightgreen;
		    font-size: 35px;
		    padding-right: 0.3em;
		    text-shadow: 1px 1px grey;
		}
		.offline .online {
		    /* Text color */
		    color: black;
		    list-style-type: none;
		    font-size: 1.4rem;
		}
		.userName {
			font-size: 1.5rem;
			margin: 1%;
		}
		.lastseen {
			font-size: 14px;
			color: gray;
			text-decoration-line: none;
		}
		.chatBox {
			width: 50%;
			height: auto;
			background-color: lightgray;
			border: 5px solid lightgray;
			margin-left: 25%;
			margin-top: 20%;
			display: none;
		}
		.frndMsg {
			text-align: left;
			background-color: rgba(0, 0, 255, 0.4);
			font-size: 20px;
			border: 1px solid transparent;
			border-radius: 5%;
		}
		.usrMsg {
			text-align: right;
			background-color: rgba(0, 255, 0, 0.4);
			font-size: 20px;
			border: 1px solid transparent;
			border-radius: 10%;
		}
		#userHeader {
			background-color: lightblue;
			text-align: center;
		}
		#chatHead {
			text-decoration-line: underline;
		}
		#msgs {
			margin-top: 5%;
			overflow: scroll;
			max-height: 300px;
		}
		.typing {
			text-align: left;
			font-size: 14px;
			color: gray;
		}
		#gameButton {
			margin-left: 42%;
			display: none;
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
<body id="body" onload="getLastSeen()">
	<?php
		$conn = new mysqli("localhost", "root", "", "mydb");
		if($conn->connect_error) {
			die("CONNECT ERROR: " . $mysqli->connect_error);
		}
		else {
			;
		}
		$goOnline = "UPDATE user SET online = 'on' WHERE username = '" . $_SESSION['usrname'] . "'";
		$result = $conn->query($goOnline);
	?>
	<div class="container">
		<div class="all">
			<section class="row">
				<div class="col-md-2">
					<div class="friendsList">
						<h2 style="text-align: center; background-color: lightblue;">Friends</h2>
						<ul type="none" id="userlist">

						</ul>
					</div>
				</div>
				<div class="col-md-8">
					<div class="chatBox" id="chatBox">
						<h4 id="userHeader"></h4>
						<div id="msgs"  onmouseup="stopScroll()">
							<!--<?php
									$sql = "SELECT username,friend,usermsg FROM msg WHERE  (friend ='" . $friend . "' AND username ='" . $_GET['usrname'] ."') OR (username ='" . $friend . "' AND friend ='" . $_GET['usrname'] . "')" ;
									$result = mysqli_query($conn, $sql);
									while ($row = mysqli_fetch_array($result)) {
									  if($row['username'] == $_GET['usrname']) {
										echo "<p class='usrMsg'>" . $row['usermsg'] . "</p>";
									  }
									  else {
									  	echo "<p class='frndMsg'>" . $row['usermsg']. "</p>";
									}
									}
							?>-->
						</div>
						<input id="input" type="text" name="message" placeholder="Enter a Message" class="form-control" onkeyup="sendMsg(this.value, event)" data-emojiable="true">
					</div>
					<br>
					<div id="gameButton">
						<input id="btn" type="button" name="playGame" class="btn btn-success" value="Play tic-tac-toe" onclick="playTic()">
					</div>
				</div>
				<div class="col-md-2">
					<input type="button" name="logout" value="Log Out" class="btn btn-muted" id="logBtn" onclick="logout();">
				</div>
			</section>
		</div>
	</div>
	<script type="text/javascript">
		var state = "on";
		var friendName, user, scrolling, lastSeen;
		var globalFriendName;
		function getLastSeen() {
			setTimeout(getLastSeen, 3000);
		    var lastDay = localStorage.getItem("day");
		    var lastHour = localStorage.getItem("hour");
		    var lastMinute = localStorage.getItem("minute");
		    var d = new Date();
		    var day = d.getDay();
		    var hour = d.getHours();
		    var minute = d.getMinutes();
		    if (lastDay && lastHour && lastMinute) {
		        lastSeen = {
		        	'day':day - lastDay,
		        	'hour': hour - lastHour,
		        	'minute': minute - lastMinute
		        };
		    }
		    var xhttp =new XMLHttpRequest();
		    xhttp.onreadystatechange = function() {
		    	if(this.readyState == 4 && this.status == 200) {
		    		document.getElementById("userHeader").innerHTML = "<span id='chatHead'>" +globalFriendName + "</span>" + this.responseText;
		    	}
		    }
		    xhttp.open("GET", "messages.php?lminute=" + lastSeen['minute'] + "&lhour="+lastSeen['hour']+"&nminute=" + minute + "&nhour=" + hour + "&getFriendName=" + globalFriendName);
		    xhttp.send();
		}
		function updateLastSeen() {
			var userOnline = "<?php if($_SESSION['state'] = 'on') {echo 1;} ?>";
			if(userOnline == 1) {
				var d = new Date();
			    var day = d.getDay();
			    var hour = d.getHours();
			    var minute = d.getMinutes();
				localStorage.setItem("day", day);
			    localStorage.setItem("hour", hour);
			    localStorage.setItem("minute", minute);
			}
		}
		updateLastSeen();
		function transferName(username) {
			globalFriendName = username;
			startScroll();
			document.getElementById("userHeader").innerHTML = username;
			document.getElementById("userHeader").innerHTML += "<br><span class='lastseen'>Last Seen: " + getLastSeen() + " ago</span>";
			document.getElementById("chatBox").style.display = "block";
			document.getElementById('gameButton').style.display = "block";
			friendName = username;
			var usrname = "<?php echo $_SESSION['usrname']?>";
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					document.getElementById("msgs").innerHTML = this.responseText;
				}
			}
			xhttp.open("GET", "messages.php?msg="+''+"&usrname="+usrname + "&friendName="+friendName +"&online=" + state + "&typing=" + 'no', true);
			xhttp.send();
		}
		setInterval(sendMsg, 1000);
		function sendMsg(msg, event) {
			var key;
			if(window.event) {
				key = event.keyCode;
			}
			var date = new Date();
			var xhttp = new XMLHttpRequest();
			var usrname = "<?php echo $_SESSION['usrname']?>";
			if(document.getElementById("input").value.length == 0) {
				;
			}
			if(key == 13) {
				state = 'on';
				startScroll();
				updateLastSeen();
				xhttp.onreadystatechange = function() {
					if(this.readyState == 4 && this.status == 200) {
						document.getElementById("msgs").innerHTML = this.responseText;
					}
				}
					xhttp.open("GET", "messages.php?msg="+msg+"&usrname="+usrname + "&friendName="+friendName +"&online=" + state+ "&typing=" + 'no', true);
					xhttp.send();
					clearInterval(timer);
					timer = "undefined";
					document.getElementById("input").value = "";
			}
			else if (document.getElementById("input").value.length == 0) {
				xhttp.onreadystatechange = function() {
					if(this.readyState == 4 && this.status == 200) {
						document.getElementById("msgs").innerHTML = this.responseText;
					}
				}
					xhttp.open("GET", "messages.php?usr="+usrname + "&friendName="+friendName + "&typing=" + 'no' + "&msg="+'', true);
					xhttp.send();
			}
			else if(document.getElementById("input").value.length > 0) {
				xhttp.onreadystatechange = function() {
					if(this.readyState == 4 && this.status == 200) {
						document.getElementById("msgs").innerHTML = this.responseText;
					}
				}
					xhttp.open("GET", "messages.php?usr="+usrname + "&friendName="+friendName + "&typing=" + 'yes' + "&msg="+''+"&online=" + state, true);
					xhttp.send();
			}
		}
		function startScroll() {
			scrolling = setTimeout(startScroll, 1000);
			if(document.getElementById("chatBox").style.display == "block") {
		    	var objDiv = document.getElementById("msgs");
				objDiv.scrollTop = objDiv.scrollHeight;
			}
		}
		function stopScroll() {
			clearTimeout(scrolling);
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
		function detectmob() {
		  var check = false;
		  (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
		  return check;
		};
		function updateUserList() {
			setTimeout(updateUserList, 3000);
			user = "<?php echo $_SESSION['usrname']; ?>";
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if(this.readyState == 4 && this.status == 200) {
					document.getElementById("userlist").innerHTML = this.responseText;
				}
			}
			xhttp.open("GET", "messages.php?usrname="+user+"&userStatus="+state);
			xhttp.send();
			if(timer == "undefined") {
				timer = setInterval(function() {
					state = "off";}, 120000);
			}
		}
		function playTic() {
			const xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if(this.readyState === XMLHttpRequest.DONE) {
					window.location.replace("./tictactoe.php");
				}
			}
			xhttp.open("GET", "tictactoe.php?usrname=" + user + "&friendName=" + globalFriendName);
			xhttp.send()
		}
		updateUserList();
		var timer = setInterval(function() {
			state = "off";
		}, 120000);
	</script>
</body>
</html>