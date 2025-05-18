<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

   <style>

   .tbl-30 {
      width: 30%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
      }

   .tbl-30 tr {
      border-bottom: 1px solid #ddd;
      }

   .tbl-30 td {
      padding: 10px;
      }

   .tbl-30 td:first-child {
      width: 30px;
      text-align: center;
      }

   .tbl-30 input[type="text"],
   .tbl-30 input[type="password"] {
      width: 100%;
      padding: 12px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
      }

   .btn-add-admin {
      background-color: #9077f5;
      color: #fff;
      border: none;
      padding: 8px 8px;
      border-radius: 4px;
      cursor: pointer;
      font-family: Cambria;
      font-weight: bold;
      font-size: 20px;
      margin-left: 59px;
      }

   .btn-add-admin:hover {
       background-color: #B197FC;
      }

   .tbl-30 tr:last-child td {
      text-align: left;
      }

   .tbl-30 td i  {
      font-size: 30px;
      color: #B197FC;
      }

  

   </style>

</head>

<?php include('partials/menu.php'); ?>


<div class="main-content">
            <div class="wrapper">
               <h1>ADD ADMIN</h1>

               <?php 
               if(isset($_SESSION['add'])) //CHECKING WHETHER THE SESSION IS SET OR NOT
               {
                echo $_SESSION['add'];   //DISPLAYING SESSION MESSAGE
                unset($_SESSION['add']);  //REMOVING SESSION MESSAGE


               }
               ?>
               <br>




               <form action="" method="POST">

               <table class="tbl-30">
                 <tr>
                 <td><i class="fa fa-user-circle" style="color: #B197FC; font-size: 40px;"></i></td>
                    <td><input type="text" name="full_name" placeholder="Enter Your Name">
                    </td>
                 </tr>

                 <tr>
                 <td><i class="fa fa-user-alt" style="color: #B197FC;"></i></td>
                    <td><input type="text" name="username" placeholder="Your Username">
                    </td>
                 </tr>

                 <tr>
                    <td><i class="fa fa-lock" style="color: #B197FC;"></i></td>
                    <td><input type="password" name="password" placeholder="Your Password">
                    </td>
                 </tr>


                 <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-add-admin">

                    </td>
                 </tr>


               </table>

               </form>
            </div>
</div>


<?php include('partials/footer.php'); ?>

<?php 
   //PROCESS THE VALUE FROM FORM AND SAVE IT IN DATABASE
   //CHECK WHETHER THE SUBMIT BUTTON IS CLICKED OR NOT
   
   if(isset($_POST['submit']))
   {
     //BUTTON CLICKED
     //echo"BUTTON CLICKED";

     //1.GET THE DATA FROM FORM
    //$full_name = $_POST['full_name'];
    //$username = $_POST['username'];
    //$password = md5($_POST['password']); //PASSWORD ENCRYPTION WITH MD5

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $raw_password = md5($_POST['password']); //PASSWORD ENCRYPTION WITH MD5
    $password = mysqli_real_escape_string($conn, $raw_password);

    //2. SQL QUERY TO SAVE DATA TO DATABASE
    $sql = "INSERT INTO tbl_admin SET
      full_name='$full_name',
      username='$username',
      password='$password'
    ";

    //3. EXECUTING QUERY AND SAVING DATA INTO DATABASE
    $res = mysqli_query($conn, $sql) or mysqli_close($conn);

    //4. CHECK WHETHER THE (QUERY IS EXECUTED) DATA IS INSERTED OR NOT AND DISPLAY APPROPRIATE MESSAGE
    if($res==TRUE)
    {
       //DATA INSERTED
       //echo "Data Inserted";
       //CREATE A SESSION VARIABLE TO DISPLAY MESSAGE
       $_SESSION['add'] = "<div class='success'>Admin Added Successfully!</div>";

       //REDIRECT PAGE TO MANAGE ADMIN
       header("location:".SITEURL.'admin/manage-admin.php');

    }

    else 
    {
        //FAILED TO INSERT DATA
       // echo "Failed to Insert Data";
       //CREATE A SESSION VARIABLE TO DISPLAY MESSAGE
       $_SESSION['add'] = "Ops! Failed to Add Admin.";

       //REDIRECT PAGE TO ADD ADMIN
       header("location:".SITEURL.'admin/add-admin.php');
    }

    
   }

 
   
?>