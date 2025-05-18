<?php 
//INCLUDE CONSTANTS.PHP FOR SITEURL
include('config/constants.php');
//1. DESTROY SESSION 
session_destroy(); //UNSETS $_SESSION['user']

//2. REDIRECT TO LOGIN PAGE
header("location:".SITEURL.'admin/login.php');



?>