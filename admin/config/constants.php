<?php
  //START SESSION 
  session_start();

//CREATE CONSTANTS TO STORE NON REPEATING VALUES
define('SITEURL', 'http://localhost/FoodOrdering/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'foodordering');

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //DATABASE CONNECTION
$db_select = mysqli_select_db($conn, DB_NAME) or mysqli_close($conn);;  //SELECTING DATABASE


?>