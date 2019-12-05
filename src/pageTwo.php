<?php
  include("config.php");
  session_start();

  if(!ISSET($_SESSION['username'])){
		header("location: /src/login.php");
		exit();
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Page Two</title>
	</head>
	<body>
      <h1>Hidden Page Two</h1>
      <a href="/src/welcome.php">Welcome</a><br>
	</body>
</html>
