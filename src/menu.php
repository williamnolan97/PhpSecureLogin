<?php

if (!isset($_SESSION['loggedIn'])) {
  echo "<ul>
          <li><a href='index.php'>Home</a></li>
          <li><a href='login.php'>Login</a></li>
          <li><a href='signUp.php'>Sign Up</a></li>
        </ul>";
} else{
  if(ISSET($_SESSION['admin'])){
    echo "<ul>
            <li><a href='welcome.php'>Home</a></li>
            <li><a href='pageOne.php'>Page One</a></li>
            <li><a href='pageTwo.php'>Page Two</a></li>
            <li><a href='eventLog.php'>Event Log</a></li>
            <li><a href='logout.php'>Logout</a></li>
          </ul>";
  } else {
    echo "<ul>
            <li><a href='welcome.php'>Home</a></li>
            <li><a href='pageOne.php'>Page One</a></li>
            <li><a href='pageTwo.php'>Page Two</a></li>
            <li><a href='logout.php'>Logout</a></li>
          </ul>";
  }
}
?>
