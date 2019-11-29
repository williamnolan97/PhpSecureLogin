<?php
  define('DB_SERVER', 'localhost');
  define('DB_USERNAME', 'root');
  define('DB_PASSWORD', '');
  define('DB_Name', 'C00216986DB');
  $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
  if(mysqli_connect_errno()){
    trigger_error("Unable to connect to database");
  }
?>
