<?php 

//INCLUDE CONSTANTS.PHP FILE HERE
include('config/constants.php');

//1.GET THE ID OF ADMIN TO BE DELETED
$id = $_GET['id'];

//2.CREATE SQL QUERY TO DELETE ADMIN
$sql = "DELETE FROM tbl_admin WHERE id=$id";

//EXECUTE THE QUERY
$res = mysqli_query($conn, $sql);

//CHECK WHTHER THE QUERY IS EXECUTED SUCCESSFULLY OR NOT
if($res==TRUE) 
{
    //QUERY EXECUTED SUCCESSSFULLY AND ADMIN DELETED
    //echo "Admin Deleted";
    //CREATE SESSION VARIABLE TO DISPLAY MESSAGE
    $_SESSION['delete'] = "<div class='success'>Admin Deleted Sucessfully!</div>";
    //REDIRECT TO MANAGE ADMIN PAGE
    header('location:'.SITEURL.'admin/manage-admin.php');
}

else 
{
    //FAILED TO DELETE ADMIN
    //echo "Failed to Delete Admin";

    $_SESSION['delete'] = "<div class='error'>Failed to Delete Admin. Please Try Again.</div>";
    header('location:'.SITEURL.'admin/manage-admin.php');
}
//3.REDIRECT TO MANAGE ADMIN PAGE WITH MESSAGE(SUCCESS OR FAILED)
?>