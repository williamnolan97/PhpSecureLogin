<?php
  include("config.php");
  include("utils.php");
  session_start();

  if(!ISSET($_SESSION['userIp'])){
    $_SESSION['userIp'] = getUserIpAddr();
  }
  if(!ISSET($_SESSION['userAgent'])){
    $_SESSION['userAgent'] = getBrowser();
  }
  if(!ISSET($_SESSION['attempts'])){
    $_SESSION['attempts'] = getAttempts($_SESSION['userIp'], $_SESSION['userAgent'], $conn);
  }

  if(!checkUserLockedOut($_SESSION['userIp'], $_SESSION['userAgent'], $conn)){
    $_SESSION['locked'] = FALSE;
  } else {
    $_SESSION['locked'] = TRUE;
    header('location: /src/lockedOut.php');
  }

  if($_SESSION['locked']){
    header('location: /src/lockedOut.php');
  } else if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = sanitize($_POST["username"]);
    $password = $_POST["password"];

    $row = getUserData($username, $conn);

    if($row == 0) {
      $_SESSION['loginErrors'] = 'The username ' . $username . ' and password could not be authenticated at the moment<br>';
      insertLog($_SESSION['userIp'], $_SESSION['userAgent'], $username, FALSE, $conn);
      addAttempt($_SESSION['userIp'], $_SESSION['userAgent'], $conn);
      $_SESSION['attempts'] = getAttempts($_SESSION['userIp'], $_SESSION['userAgent'], $conn);
      if($_SESSION['attempts'] >= 5){
        $_SESSION['locked'] = TRUE;
        unset($_SESSION['attempts']);
        lockoutUser($_SESSION['userIp'], $_SESSION['userAgent'], $conn);
      }
    } else {
      unset($_SESSION['loginErrors']);
      $thisSalt = $row['salt'];
      $hashedPassword = md5($password . $thisSalt);
      $thisPass = $row['password'];
      if(strcmp($thisPass,$hashedPassword) == 0) {
          session_regenerate_id();
          $_SESSION['username'] = $username;
          $_SESSION['loggedIn'] = TRUE;
          if($username == "ADMIN"){
            $_SESSION['admin'] = TRUE;
          }
          insertLog($_SESSION['userIp'], $_SESSION['userAgent'], $username, TRUE, $conn);
          exit();
      } else {
        $_SESSION['loginErrors'] = 'The username ' . $username . ' and password could not be authenticated at the moment';
        insertLog($_SESSION['userIp'], $_SESSION['userAgent'], $username, FALSE, $conn);
        addAttempt($_SESSION['userIp'], $_SESSION['userAgent'], $conn);
        $_SESSION['attempts'] = getAttempts($_SESSION['userIp'], $_SESSION['userAgent'], $conn);
        if($_SESSION['attempts'] >= 5){
          $_SESSION['locked'] = TRUE;
          unset($_SESSION['attempts']);
          lockoutUser($_SESSION['userIp'], $_SESSION['userAgent'], $conn);
        }
      }
    }
  }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Login</title>
	</head>
	<body>
		<h1>Login</h1>
    <?php if(ISSET($_SESSION['loginErrors'])) { echo $_SESSION['loginErrors']; } ?>
    <form method = "POST">
        <label>Username: </label><input type="text" name="username" autocomplete="off" autofocus required/>
        <br/>
        <label>Password: </label><input type="password" name="password" autocomplete="off" required/>
        <br/>
        <input type = "submit" value = "Login"/>
        <br/>
    </form>
	</body>
</html>
