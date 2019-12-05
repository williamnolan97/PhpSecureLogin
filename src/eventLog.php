<?php
  include("config.php");
  session_start();

  if(!ISSET($_SESSION['username'])){
		header("location: /src/login.php");
		exit();
	}
  if(ISSET($_SESSION['admin'])){
    if(!$_SESSION['admin']){
      header("location: /src/welcome.php");
      exit();
    }
  } else {
    header("location: /src/welcome.php");
    exit();
  }
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Event Log</title>
    <style>
      table, th, td {
          border: 1px solid black;
      }
    </style>
	</head>
	<body>
      <h1>Event Log</h1>
      <a href="/src/Welcome.php">Home</a><br>
      <h3>Login Logs</h3>
      <?php
        $sql = "SELECT * FROM eventLog";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          echo "<table><tr><th>IP</th><th>User Agent</th><th>Username</th><th>Successful</th></tr>";
          while($row = $result->fetch_assoc()) {
              echo "<tr><td>" . $row["ip"]. "</td><td>" . $row["userAgent"]. "</td><td>" . $row["username"]. "</td><td>" . $row["successful"]. "</td></tr>";
          }
          echo "</table>";
        } else {
            echo "0 results";
        }
      ?>
	</body>
</html>
