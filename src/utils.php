<?php

function createDb(){
  $conn = new mysqli('localhost', 'root', '');
  $sql = 'CREATE DATABASE IF NOT EXISTS c00216986db';
  if($conn->query($sql)){
    echo "Database created successfully";
  } else {
    echo "Database already exists";
    echo("Database error: " . $conn -> error);
  }
}

function createTable(){
  include('config.php');
  $sql = 'CREATE TABLE users (
              id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              username VARCHAR(20) NOT NULL,
              password VARCHAR(64) NOT NULL,
              salt VARCHAR(64) NOT NULL
  )';
  if($conn->query($sql)){
    echo "Table created successfully";
  } else {
    echo "Table already exists";
    echo("Table error: " . $conn -> error);
  }
}

function generateSalt() {
  $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
  $charsLength = 62;
  $newSalt = '';
  for ($i = 0; $i < 63; $i++){
    $newSalt .= $chars[rand(0, $charsLength - 1)];
  }
  return $newSalt;
}

function insertUser($username, $password, $salt, $conn){
  $sql = "INSERT INTO users (id, username, password, salt)
          VALUES (NULL, '$username', '$password', '$salt')";
  if($conn->query($sql)){
    echo 'um hey';
    echo "<div><h5> New user added
                <input type='button' value='Login' onclick= 'window.location = \"login.php\" '> </h5></div>";
    exit();
  } else {
    echo 'um tf you think you are';
    echo("Insert error: " . $conn -> error);
  }
}

?>
