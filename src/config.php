<?php
  define("DB_SERVER", "localhost");
  define("DB_USERNAME", "root");
  define("DB_PASSWORD", "");
  define("DB_NAME", "c00216986db");
  $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
  if ($conn->connect_error) {
        $conn->close();
    }
  date_default_timezone_set('Europe/Dublin');
?>
