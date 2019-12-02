<?php
  include("config.php");
  include("utils.php");
  session_start();

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["username"];
    $password = $_POST["password"];
    $newSalt = generateSalt();
    $hash = md5($password . $newSalt);
    if(!checkUserExists($username, $conn)){
      echo "Sorry - Please choose a different username. <a href='/src/signUp.php'>Back</a>";
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
		<form method="POST">
      <label>Username: </label><input type="text" name="username" pattern="{5,20}" autocomplete="off" autofocus required/>
      <br>
      <label>Password: </label><input type="password" name="password" pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$" autocomplete="off" required/>
      <br>
      <input type="submit" value="Sign Up"/>
      <br>
    </form>
	</body>
</html>
