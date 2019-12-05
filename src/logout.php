<?php
	session_start();
	if(!ISSET($_SESSION['username'])){
		echo "You must be logged in to view this page <br>
		<a href='/src/login.php'>Login</a>" ;
		exit();
	} else {
		$_SESSION['username'] = null;
		session_unset() ;
		session_destroy();
		header("Location: /src/login.php");
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Logout</title>
		<link rel="stylesheet" href="app.css">
	</head>
	<body>
		<?php include("menu.php"); ?>
			<h1> Logging out... </h1>
			<p> Please wait to be redirected </p>
	</body>
</html>
