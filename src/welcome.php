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
		<title>Welcome</title>
	</head>
	<body>
      <h1>Welcome, <?php echo $_SESSION['username']; ?>!<br><br>
        <a href="/src/logout.php">Logout</a><br>
        <a href="/src/changePassword.php">Change Password</a><br>
        <img src="https://i.imgur.com/BkDkTxY.jpg">
      </h1>
	</body>
</html>
