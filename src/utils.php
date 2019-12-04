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
              username VARCHAR(30) NOT NULL,
              password VARCHAR(64) NOT NULL,
              salt VARCHAR(64) NOT NULL
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
    echo "User " . $username . " added. <a href='/src/login.php'>Login</a>";
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

function checkPasswordContains($password){
  $error = "";
  if(strlen($password) < 8 || strlen($password) > 32){
    $error .= "Password must be between 8 and 32 characters long.<br>";
  }
  if(!preg_match('/[A-Z]/', $password)){
    $error .= "Password must contain at least one uppercase letter.<br>";
  }
  if(!preg_match('/[a-z]/', $password)){
    $error .= "Password must contain at least one lowercase letter.<br>";
  }
  if(!preg_match('/[0-9]/', $password)){
    $error .= "Password must contain at least one number.<br>";
  }
  if(!preg_match('[\W]', $password)){
    $error .= "Password must contain at least one special character.<br>";
  }
  if($error != ""){
    return $error;
  } else {
    return "true";
  }
}

function updatePassword($password, $username, $conn){
  $sql = "UPDATE users SET password = '$password' WHERE username='$username'";
  if($conn->query($sql)){
    return true;
  } else {
    echo("Password update error: " . $conn -> error);
    return false;
  }
}

?>
