<?php
  include("config.php");
  include("utils.php");
  session_start();

  if(ISSET($_SESSION['username'])){
		header("location: /src/welcome.php");
		exit();
	}
  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $newSalt = generateSalt();
    $hash = md5($password . $newSalt);
    $check = checkPasswordContains($password);
    if($check != "true"){
      $_SESSION['errors'] = $check;
      header("location: /src/signUp.php");
      exit();
    }
    unset($_SESSION['errors']);
    if(!checkUserExists($username, $conn)){
      echo "Sorry. Please choose a different username. <a href='/src/signUp.php'>Back</a>";
      exit();
    } else {
      insertUser($username, $hash, $newSalt, $conn);
    }
  }
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Sign Up</title>
	</head>
	<body>
    <h1>Sign Up</h1>
    <?php if(ISSET($_SESSION['errors'])) { echo $_SESSION['errors']; } ?>
		<form method="POST">
      <label>Username: </label><input type="text" name="username" autocomplete="off" autofocus required/>
      <br>
      <label>Password: </label><input type="password" name="password" autocomplete="off" required/>
      <br>
      <input type="submit" value="Sign Up"/>
      <br>
    </form>
	</body>
</html>
