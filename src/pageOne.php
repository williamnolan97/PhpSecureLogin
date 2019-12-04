<?php
  include("config.php");
  session_start();

  if(!ISSET($_SESSION['username'])){
		echo "You must be logged in to view this page <br>
		<a href='/src/login.php'>Login</a>" ;
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Page One</title>
	</head>
	<body>
      <h1>Hidden Page One</h1>
      <a href="/src/welcome.php">Welcome</a><br>
	</body>
</html>
