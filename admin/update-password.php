<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>CHANGE PASSWORD</h1>
        <br><br>

      <?php 
        if(isset($_GET['id']))
        {
            $id=$_GET['id'];
        }
      ?>









        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current Password: </td>
                    <td>
                        <input type="password" name="current_password" placeholder="Old Password">
                    </td>
                </tr>

                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm New Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                   </td>
                    
                </tr>



            </table>

        </form>
    </div>
</div>

<?php 
  //CHECK WHTHER THE SUBMIT BUTTON IS CLICK OR NOT
  if(isset($_POST['id']))
  {
    //echo "Clicked";

    //1. GET THE DATA FROM FORM
    $id=$_POST['id'];
    //$current_password= md5($_POST['current_password']);
    //$new_password= md5($_POST['new_password']);
    //$confirm_password= md5($_POST['confirm_password']);

    $old_password= md5($_POST['current_password']);
    $current_password = mysqli_real_escape_string($conn, $old_password);

    $change_password= md5($_POST['new_password']);
    $new_password = mysqli_real_escape_string($conn, $change_password);

    $add_password= md5($_POST['confirm_password']);
    $confirm_password = mysqli_real_escape_string($conn, $add_password);


    //2. CHECK WHTHER THE USER WITH CURRENT ID AND CURRENT PASSWORD EXISTS OR NOT
    $sql = "SELECT * FROM tbl_admin WHERE id=$id AND password='$current_password'";

    //EXCUTE THE QUERY
    $res = mysqli_query($conn, $sql);

    if($res==TRUE) 
    {
        //check whther data s available or not
        $count=mysqli_num_rows($res);

        if($count==1) 
        {
            //USER EXISTS AND PASSWORD CAN BE CHANGE
             //"USER FOUND";

             //CHCECK WHTEHER THE NEW PASSWORD AND CONFIRM MATCH OR NOT
             if($new_password==$confirm_password)
             {
                //UPDATETHE PASSWORD
                //echo "Password Match";
                $sql2 = "UPDATE tbl_admin SET
                password='$new_password' 
                WHERE id=$id";

                //EXCUTE THE QUERY
                $res2 = mysqli_query($conn, $sql2);

                //CHECK WHTHER QUERY IS EXECUTED OR NOT
                if($res2==TRUE) 
                {
                    //DISPLAY SUCCESS 
                //REDIRECT TO MANAGE ADMIN WITHSUCCES MESSAGE
                $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully! </div>";
                //REDIRECT THE USER
                header("location:".SITEURL.'admin/manage-admin.php');

                }
                else 
                {
                    //ERROR MESSAGE
                    //REDIRECT TO MANAGE ADMIN WITH ERROR MESSAGE
                $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password! </div>";
                //REDIRECT THE USER
                header("location:".SITEURL.'admin/manage-admin.php');
                }
             }
             else 
             {
                //REDIRECT TO MANAGE ADMIN WITH ERROR MESSAGE
                $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match. </div>";
                //REDIRECT THE USER
                header("location:".SITEURL.'admin/manage-admin.php');

             }
        }
        else 
        {
            //USER DOES NOT EXIST SET MESSAGE AND REDIRECT
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found. </div>";
            header("location:".SITEURL.'admin/manage-admin.php');
        }

    }

    //3. CHEKC WHWTHER THE NEW PASSWORD AND CONFIRM PASSWORD MTCH OR NOT


    //4. CHANGE PASS IF ALLL ABOVE IS TRUE

  }


?>





<?php include('partials/footer.php'); ?>