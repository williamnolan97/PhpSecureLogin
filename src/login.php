<?php
  include("config.php");
  include("utils.php");
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = getUserData($username, $conn);

    if($result->num_rows == 0) {
      $_SESSION['loginErrors'] = 'The username ' . $username . ' and password could not be authenticated at the moment';
      if(!ISSET($_SESSION['userIp'])){
        $_SESSION['userIp'] = getUserIpAddr();
      }
      if(!ISSET($_SESSION['userAgent'])){
        $_SESSION['userAgent'] = getBrowser();
      }
      insertLog($_SESSION['userIp'], $_SESSION['userAgent'], $username, FALSE, $conn);
    } else {
      unset($_SESSION['loginErrors']);
      while ($row = $result->fetch_assoc()) {
          $thisSalt = $row['salt'];
          $hashedPassword = md5($password . $thisSalt);
          $thisPass = $row['password'];
          if(strcmp($thisPass,$hashedPassword) == 0) {
              $_SESSION['username'] = $username;
              if(!ISSET($_SESSION['userIp'])){
                $_SESSION['userIp'] = getUserIpAddr();
              }
              if(!ISSET($_SESSION['userAgent'])){
                $_SESSION['userAgent'] = getBrowser();
              }
              insertLog($_SESSION['userIp'], $_SESSION['userAgent'], $username, TRUE, $conn);
              if($username == "ADMIN"){
                $_SESSION['admin'] = TRUE;
              }
              exit();
          } else {
            $_SESSION['loginErrors'] = 'The username ' . $username . ' and password could not be authenticated at the moment';
            if(!ISSET($_SESSION['userIp'])){
              $_SESSION['userIp'] = getUserIpAddr();
            }
            if(!ISSET($_SESSION['userAgent'])){
              $_SESSION['userAgent'] = getBrowser();
            }
            insertLog($_SESSION['userIp'], $_SESSION['userAgent'], $username, FALSE, $conn);
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
