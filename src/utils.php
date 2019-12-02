<?php

function createDb(){
  $conn = new mysqli("localhost", "root", "");
  $sql = "CREATE DATABASE IF NOT EXISTS c00216986db";
  if($conn->query($sql)){
    echo "Database created successfully";
  } else {
    echo "Database already exists";
    echo("Database error: " . $conn -> error);
  }
}

function createTable(){
  include("config.php");
  $sql = "CREATE TABLE users (
              id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              username VARCHAR(20) NOT NULL,
              password VARCHAR(64) NOT NULL,
              salt VARCHAR(64) NOT NULL,
              locked INT(1) NOT NULL,
              locktime DATETIME NOT NULL
  )";
  if($conn->query($sql)){
    echo "Table created successfully";
  } else {
    echo "Table already exists";
    echo("Table error: " . $conn -> error);
  }
}

function generateSalt() {
  $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  $charsLength = 62;
  $newSalt = "";
  for ($i = 0; $i < 63; $i++){
    $newSalt .= $chars[rand(0, $charsLength - 1)];
  }
  return $newSalt;
}

function insertUser($username, $password, $salt, $conn){
  $sql = "INSERT INTO users (id, username, password, salt)
          VALUES (NULL, '$username', '$password', '$salt')";
  if($conn->query($sql)){
    echo "User added. <a href='/src/login.php'>Login</a>";
    exit();
  } else {
    echo("User insert error: " . $conn -> error);
  }
}

function checkUserExists($username, $conn){
  $sql = "SELECT * FROM users WHERE username='$username'";
  if($conn->query($sql)){
    if($conn->affected_rows == 0){
      return true;
    } else {
      return false;
    }
  } else {
    echo("Query error: " . $conn -> error);
  }
}

function getUserData($username, $conn){
  $sql = "SELECT * FROM users WHERE username='$username'";
  if($conn->query($sql)){
    return $conn->query($sql);
  } else {
    echo("Query error: " . $conn -> error);
  }
}

function incrementLock($username, $locks, $db)
{
    $sql = "UPDATE users SET locked='$locks' WHERE username='$username'";
//increment lock
    if (!mysqli_query($db, $sql))
    {
  echo "Error updating lock: " . mysqli_error($db);
}
    echo "<div class='errorstyle' align='center'> <h5> Sorry - Incorrect login details for $username <br></h5></div>";
}
function lockOut($locks, $username, $db)
{
    $sql = "UPDATE users SET locked='$locks', locktime=((now() + INTERVAL 5 MINUTE)) WHERE username='$username'";
//set lock back to 0 and set a lockout time of 5 mins
    if (!mysqli_query($db, $sql))
    {
  echo "Error resetting lock and adding lockout: " . mysqli_error($db);
}
echo "<div class='errorstyle' align='center'> <h5> Sorry - Too many attempts - Locking account for $username </h5></div>";
}

function resetLocks($locks, $username, $db)
{
    $sql = "UPDATE users SET locked='$locks' WHERE username='$username'";
//set lock back to 0
    if (!mysqli_query($db, $sql))
    {
  echo "Error resetting lock and adding lockout: " . mysqli_error($db);
}
}

?>
