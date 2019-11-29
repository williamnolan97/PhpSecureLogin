<?php

function createDb(){
  $conn = new mysqli('localhost', 'root', '');
  $sql = 'CREATE DATABASE IF NOT EXISTS C00216986DB';
  if($conn->query($sql)){
    echo "Database created successfully";
  } else {
    echo "Database already exists";
  }
}

function createTable(){
  include('config.php');
  $sql = 'CREATE TABLE Users (
              id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
              username VARCHAR(20) NOT NULL,
              password VARCHAR(64) NOT NULL,
              salt VARCHAR(64) NOT NULL
  )';
  if($conn->query($sql)){
    echo "Table created successfully";
  } else {
    echo "Table already exists";
  }
}


?>
