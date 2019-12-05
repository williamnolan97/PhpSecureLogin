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
  if(!isset($_SESSION['CSRF'])){
    $_SESSION['CSRF'] = bin2hex(random_bytes(32));
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
