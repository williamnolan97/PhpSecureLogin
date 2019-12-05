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
		<title>Welcome</title>
	</head>
	<body>
      <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
      <a href="/src/logout.php">Logout</a><br>
      <a href="/src/changePassword.php">Change Password</a><br>
      <h3>Hidden Pages</h3>
      <a href="/src/pageOne.php">Page One</a><br>
      <a href="/src/pageTwo.php">Page Two</a><br>
      <?php
        if(isset($_SESSION['admin'])){
          if($_SESSION['admin']){
            echo "<a href='/src/eventLog.php'>Event Log</a><br>";
          }
        }
      ?>
      <img src="https://i.imgur.com/BkDkTxY.jpg">
	</body>
</html>
