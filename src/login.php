<?php
  include("config.php");
  include("utils.php");
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $result = getUserData($username, $conn);

    if($result->num_rows == 0){
      echo "no user u pos";
    } else {
      while ($row = $result->fetch_assoc())
        {
          //generate the users hash based of password
          $thisSalt = $row['salt'];
          $hashedPassword = md5($password . $thisSalt);
          $thisPass = $row['password'];
          $locks = $row['locked'];
          $lockTime = $row['locktime'];
          $now = date("H:i:s",strtotime("now"));

          if($lockTime > $now)
            {
              echo "<div class='errorstyle' align='center'> <h5> Account locked for $username - try again later
              <input type='button' onclick= 'window.location = \"login.php\" '></h5></div>";
              exit();
            }
          if(strcmp($thisPass,$hashedPassword) == 0)
            {
              //successful login
              $_SESSION['username'] = $username;
              //reset locks
              $locks = 0;
              resetLocks($locks, $username, $conn);
              header("location: /src/welcome.php");
              exit();
            }
          if($locks < 2)
            {
              $locks = $locks + 1;
              incrementLock($username, $locks, $conn);
            }
          else
            {
              $locks = 0;
              lockOut($locks, $username, $conn);
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
			<form method = "POST">
                <label>Username: </label><input type="text" name="username" autocomplete="off" autofocus required/>
                <br/>
                <label>Password: </label><input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$" autocomplete="off" required/>
                <br/>
                <input type = "submit" value = "Login"/>
                <br/>
            </form>
		</div>
		</div>
	</body>
</html>
