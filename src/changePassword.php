<?php
	include("config.php");
  include("utils.php");
	session_start();

	if (!isset($_SESSION['loggedIn'])) {
		session_destroy();
    header('location: /src/login.php');
    exit();
	} else {
		if(isset($_GET['submit'])) {
        $username = $_SESSION['username'];
  			$old = $_GET['oldpassword'];
  			$new = $_GET['newpassword1'];
  			$confirm = $_GET['newpassword2'];
				$CSRF = $_GET['CSRF'];

				if(!hash_equals($_SESSION['CSRF'], $CSRF)) {
					echo $_SESSION['CSRF'];
					echo $CSRF;
					$_SESSION['loginErrors'] = "CSRF did not verify, please log in and try again.";
					header('location: /src/login.php');
					exit();
				}

        $check = checkPasswordContains($new);
        if($check != "true"){
          $_SESSION['errors'] = $check;
          header("location: /src/changePassword.php");
          exit();
        }
        unset($_SESSION['errors']);
  			$row = getUserData($username, $conn);
  			$oldSalt = $row['salt'];
        $inputHashedPassword = md5($old . $oldSalt);
  			$oldHashedPassword = $row['password'];
  			$newHashedPassword = md5($new . $oldSalt);

  			if(strcmp($new, $confirm) != 0){
  					echo "New passwords do not match, try again! <br>
  					<a href='/src/changePassword.php'>Change Password</a>";
  					exit();
  			} else if(strcmp($oldHashedPassword,$inputHashedPassword) != 0) {
  					echo "Old Password Incorrect, try again! <br>
  					<a href='/src/changePassword.php'>Change Password</a>";
  					exit();
  			} else if(strcmp($oldHashedPassword,$newHashedPassword) == 0) {
  					echo "New password cannot be old password, try again! <br>
  					<a href='/src/changePassword.php'>Change Password</a>";
  					exit();
  			} else {
  					if(!updatePassword($newHashedPassword, $username, $conn)){
                echo "Password change unsuccessful, try again! <br>
      					<a href='/src/changePassword.php'>Change Password</a>";
  							exit();
  					}
  					else{
  							$_SESSION['username'] = null ;
  							session_unset();
  							session_destroy();
  							header("location: /src/login.php");
  							exit();
  					}
  			}
      }
		}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Change Password </title>
		<link rel="stylesheet" href="app.css">
	</head>
	<body>
		<?php include("menu.php"); ?>
		<h1>Change Password </h1>
    <?php if(ISSET($_SESSION['errors'])) { echo $_SESSION['errors']; } ?>
			<form method = "GET">
        <label>Old Password: </label><input type="password" name="oldpassword" autocomplete="off" autofocus required/>
        <br>
				<label>New Password: </label><input type="password" name="newpassword1" autocomplete="off" required/>
        <br>
				<label>Confirm New Password: </label><input type="password" name="newpassword2" autocomplete="off" required/>
        <br>
				<input type="hidden" name="CSRF" value="<?php echo $_SESSION['CSRF'];?>"/>
        <input type="submit" name="submit" value="Change Password"/>
        <br/>
      </form>
	</body>
</html>
