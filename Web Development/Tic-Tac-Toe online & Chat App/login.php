<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHP</title>
	<link rel="stylesheet" type="text/css" href="./assets/bootstrap.min.css">
	<style type="text/css">
		.frame {
			margin-top: 20%;
			background-color: #1BB8F3;
			height: 120%;
			width: 100%;
			border: 1px solid blue;
		}
		label {
			font-size: 2rem;
			font-style: italic;
			text-shadow: -2px 2px lightyellow;
			stroke: black; 
		}
		#body {
			background:  -webkit-linear-gradient(top, transparent 0%,#6F0FD5 50%,transparent 80%);
		}
		label {
			margin-left: -10%;
		}
		label {
			margin-top: 5%;
		}
		.red {
			margin-left: 3%;
			color: red;
		}
		.green {
			margin-left: 3%;
			color: green;
		}
	</style>
		<script type="text/javascript">
			function gotoChat() {
			 <?php 
			 	if(isset($_SESSION['usrname']) && $_SESSION['msg'] != "WRONG PASSWORD") {
			 		header("Location: chat.php");
			 	}
			 ?>
			}
	</script>
</head>
<body id="body">
	<div class="container">
		<div class="all">
			<section class="row">
				<div class="col-md-2"></div>
				<div class="col-sm-8">
					<div class="frame">
						<h1 style="text-align: center; color: white; text-shadow: 1px 1px lightyellow;">Log in</h1>
						<form action="auth.php" method="post">
						  <div class="form-group form-inline" style="text-align: center;">
							<label for="fname">Username:</label>
							<input type="text" minlength="1" name="fname" class="form-control">
							<br>
							<label for="fpass">Password:</label>
							<input type="password" name="fpass" class="form-control" >
							<br>
							<br>
							<br>
							<div class="msg">
								<?php
									$myMsg;
									if(isset($_SESSION['msg']) && $_SESSION['msg'] == "WRONG PASSWORD") {
										$myMsg = $_SESSION['msg'];
										echo "<h4 class='red'>$myMsg</h4>";
									}
									if (isset($_SESSION['msg']) && $_SESSION['msg'] != "WRONG PASSWORD") {
										echo "<h4 class='green'>Welcome <strong>" . $_SESSION['usrname'] . "</strong><br> You logged in</h4>";
										echo '<script>setTimeout(gotoChat, 2000);</script>';
									}
								?>
							</div>
							<input type="submit" name="sent" value="Login" class="btn btn-primary form-control" style="width: 15%; margin-left: 3.5%;">
						  </div>
						</form>
					</div>
				</div>
				<div class="col-md-2">
				</div>
			</section>
		</div>
	</div>
</body>
</html>