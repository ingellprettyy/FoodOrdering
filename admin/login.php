<?php include('config/constants.php'); ?>

<html>
<head>
    <title>LOGIN PAGE</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   
</head>

<body>
<center>
    <div class="container">

    <div class="login">
        <h1 class="text-center">LOGIN FORM</h1>
        <br>

        <?php 
        if(isset($_SESSION['login'])) 
        {
         echo $_SESSION['login'];   
         unset($_SESSION['login']);  
        }

        if(isset($_SESSION['no-login-message'])) 
        {
         echo $_SESSION['no-login-message'];   
         unset($_SESSION['no-login-message']);  
        }


        ?>
        <br><br>

   </div>
     <!-- LOGIN FORM STARTS HERE -->
  <form action="" method="POST" class="text-center">

  <div class="image">
  <img src="user.png" alt="Sign Up"> 
  </div> 

  <container name="form">
 

  <i class="fa fa-user" style="color: #B197FC;"> Username:</i>
  <input type="text" name="username" placeholder="Enter Username">
  <br><br>

  <i class="fa fa-lock" style="color: #B197FC;"> Password:</i>
  <input type="password" name="password" placeholder="Enter Password">
  <br><br>

  <input type="submit" name="submit" value="Login">
  <br><br>
    <!-- LOGIN FORM ENDS HERE -->


        <p class="text-center">CREATED BY: <a href="www.facebook.com">A.L RUIZ</a></p>


</center>
</form>

    </div>


<style type="text/css">

h1 {
    font-family: MV Boli;
    font-size: 35px;
}

.login {
    color: red;

}

.image img {
    display: block;
    margin: 0 auto;
    margin-bottom: 3%;
    padding-top: 10px;
    padding: 0px 0;
    width: 70px;
    height: 70px;
  

}


.container{
    width: 30%;
    height: 60%;
    padding-top: 3%;
    padding-bottom: 3%;
    margin: 7% 30%;
    background-color: pink;
    border-radius: 18px;
    box-shadow: 10px 10px 50px red;
    border: 5px solid violet;
    display: flex; 
  flex-direction: column;

  }

  .container input[type="submit"] {
  width: 40%;
  padding: 10px 15px;
  background-color: green;
  color: #fff;
  border: 2px;
  border-radius: 10px;
  cursor: pointer;
  font-family: Tw Cen MT;
  color: white;
  margin: 2%;
  font-weight: bold;
  font-size: 20px;
}

.container input[type="submit"]:hover {
  background-color: red;
  box-shadow: 0 0 50px white;
  border-radius: 10px;
  border: 2px solid peach;
  font-family: Tw Cen MT;
}

.text-center {
    text-align: center;
    margin-top: 2%
}

.success {
    color: #00b894;
}
.error {
    color: #d63031;

}

</style>
</body>
</html>

<?php 

//CHECK WHTHER THE SUBMIT BUTTON IS CLICKED OR NOT

if(isset($_POST['submit']))
{
    //PROCESS FOR LOGIN

    //1. GET THE DATA FROM LOGIN FORM
    //$username = $_POST['username'];
    //$password = md5($_POST['password']);

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $raw_password = md5($_POST['password']);
    $password = mysqli_real_escape_string($conn, $raw_password);
   

    //2. SQL TO CHECK WHTEHER USERNAME AND PASS EXIST OR NOT
    $sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

    //3. EXECUTE THE QUERY
    $res = mysqli_query($conn, $sql);

    //4. COUNT ROWS TO CHECK WHTER USER EXIST OR NOT
    $count = mysqli_num_rows($res);

    if($count==1)
    {
        //USER AVAILABLE AND LOGIN SUCCESS
        $_SESSION['login'] = "<div class='success'>Login Successfully!</div>";
        $_SESSION['user'] = $username; //TO CHCECK WHTHER USER IS LOGIN OR NLT AND LOG OUT WILL UNSET IT

        //REDIRECT TO HOME PAGE/DASHBOARD
        header('location:'.SITEURL.'admin/');
    }
    else 
    {
        //USER NOT AVAILABLE AND LOGIN FAILED
        $_SESSION['login'] = "<div class='error text-center'>Username or Password did not match.</div>";
        //REDIRECT TO HOME PAGE/DASHBOARD
        header('location:'.SITEURL.'admin/login.php');

    }
}

?>