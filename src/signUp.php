<?php
  include('config.php');
  include('utils.php');

  if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $newSalt = generateSalt();
    $hash = md5($password . $newSalt);
    echo 'um hello';
    insertUser($username, $hash, $newSalt, $conn);
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
		<form method='POST'>
      <label>Username: </label><input type='text' name='username' title='Username must be between 5 and 20 characters long.' pattern="{5,20}" autocomplete="off" autofocus required/>
      <br>
      <label>Password: </label><input type='password' name='password' title='Password must be between 8 and 20 characters long and contain an UPPERCASE letter, a lowercase letter and a number.' pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,20}$" autocomplete="off" required/>
      <br>
      <input type='submit' value='Sign Up'/>
      <br>
    </form>
	</body>
</html>
