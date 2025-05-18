<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


<?php include('partials/menu.php'); ?>

<div class="main-content">
  <div class="wrapper">
    <h1>UPDATE ADMIN</h1>

    <br><br>

             <?php 
             //1.GET THE ID OF SELECTED ADMIN
             $id=$_GET['id'];

             //2.CREATE SQL QUERY TO GET DETAILS
             $sql="SELECT * FROM tbl_admin WHERE id=$id";

             //3.EXECUTE THE QUERY
             $res=mysqli_query($conn, $sql);

             //CHECK WHEHER QUERY S EXECUTED OR NOT
             if($res==TRUE) 
             {
                //CHECK WHTHER DATA IS AVAILABLE OR NOT
                $count = mysqli_num_rows($res);
                //CHECK WHTHER WE HAVE ADMIN DATA OR NOT
                if($count==1)
                {
                    //GET THE DETAILS
                    // "Admin Available";
                    $row=mysqli_fetch_assoc($res);

                    $full_name = $row['full_name'];
                    $username = $row['username'];
                }
                else 
                {
                    //REDIRECT TO MANAGE ADMIN
                    header("location:".SITEURL.'admin/manage-admin.php');

                }
             }

               ?>

    <form action="" method="POST">
        <table class="tbl-30">
              <tr>
                    <td><i class="fa fa-user" style="color: #B197FC;"></i></td>
                    <td><input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                 </tr>

                 <tr>
                    <td> <i class="fa fa-user" style="color: #B197FC;"></i></td>
                    <td><input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                 </tr>


                 <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">

                    </td>
                 </tr>



        </table>
    </form>

  </div>

</div>

<?php 
  //CHECK WHTHER THE SUBMIT BUTTON IS CLICK OR NOT
  if(isset($_POST['submit']))
  {
    //echo "Button Clicked";
    //GET ALL THE VALUES FROM FORM TO UPDATE
    $id = $_POST['id'];
    //$full_name = $_POST['full_name'];
    //$username = $_POST['username'];

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);

    $username = mysqli_real_escape_string($conn, $_POST['username']);

    //CREATE SQL QUERY TO UPDATE ADMIN
    $sql = "UPDATE tbl_admin SET 
    full_name = '$full_name',
    username = '$username'
    WHERE id='$id' ";

    //EXECUTE QUERY
    $res = mysqli_query($conn, $sql);

    //CHECK WHTHER QUERY EXECUTED SUCCESSFULLY OR NOT
    if($res==TRUE) 
    {
        //QUERY EXECUTED AND ADMIN UPDATED
        $_SESSION['update'] = "<div class='success'>Admin Updated Succesfully!</div>";
        //REDIRECT TO MANAGE ADMIN PAGE
        header("location:".SITEURL.'admin/manage-admin.php');
    }

    else 
    {
        //FAILED TO UPDATE ADMIN
        $_SESSION['update'] = "<div class='error'>Ops! Failed to Delete Admin.</div>";
        //REDIRECT TO MANAGE ADMIN PAGE
        header("location:".SITEURL.'admin/manage-admin.php');
    }


  }
?>


<?php include('partials/footer.php'); ?>