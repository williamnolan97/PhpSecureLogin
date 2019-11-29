<?php

  include('utils.php');

  createDb();
  createTable();

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Secure Application</title>
	</head>
	<body>
		<div id="body">
            <div id="main" align="center">
                <h1>Welcome to my Secure App Login Assignment<br><br>
                  Please <a href="/src/login.php">Login</a> or <a href="/src/signUp.php">Sign Up</a> to continue.
                </h1>
            </div>
		</div>
	</body>
</html>
