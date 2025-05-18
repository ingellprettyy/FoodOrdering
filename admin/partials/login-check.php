<?php 

//AUTHORIZATION OR ACCCESS CONTROL
 //CHCECK WHTHER THE USER IS LOGGED IN OR NOT
if(!isset($_SESSION['user'])) //IF USER SESSION IS NOT SET
{
    //USER IS NOT LOGGED IN
    //REDIRECT TO LOGIN PAGE WITH MESSAGE
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please login to access Admin Panel.</div>";

    //REDIRECT TO LOGIN PAGE
    header('location:'.SITEURL.'admin/login.php');
}
?>


