<?php
  include("config.php");
  include("utils.php");
  session_start();

  if (!isset($_SESSION['loggedIn'])) {
		session_destroy();
    header('location: /src/login.php');
    exit();
	}

  if(!isset($_SESSION['lastActiveTime'])){
    $_SESSION['lastActiveTime'] = time();
    $_SESSION['loggedInTime'] = time();
  } else {
    checkActivity($_SESSION['lastActiveTime'], $_SESSION['loggedInTime']);
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
