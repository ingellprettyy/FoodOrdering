
<?php 

//INCLUDE CONSTANTS FILE
include('config/constants.php');

//echo "Delete Page"
//CHECK WHETHER THE ID AND IMAGE NAME VALUE IS SET OR NOT
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    //GET THE VALUE AND DELETE
    //echo "Get Value and Delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    //REMOVE THE PHYSICAL IMAGE FILE IS AVAILABLE
    if($image_name != "")
    {
        //IMAGE IS AVAILABLE SO REMOVE IT
        $path = "../images/category/".$image_name;
        //REMOVE THE IMAGE
        $remove = unlink($path);

        //IF FAILED T REMOVE IMAGE THEN ADD AN ERROR MESS AND STOP THE PROCESS
        if($remove==FALSE)
        {
            //SET THE SESSION MESSAGE
            $_SESSION['remove'] = "<div class='error'>Failed to Remove Category Image.</div>";
            //REDIRECT TO MANAGE CATEGORY PAGE
            header("location:".SITEURL.'admin/manage-category.php');
            //STOP THE PROCESS
            die();
        }
    }


    //DELETE DATA FROM DB
    //SQL QUERY TO DELETE DATA FROM DB
    $sql = "DELETE FROM tbl_category WHERE id=$id";

    //EXECUTE THE QUERY
    $res = mysqli_query($conn, $sql);

    //CHECK WHTHER DATA OS DELETE FROM DB OR NOT
    if($res==TRUE)
    {
        //SET SUCCESS MESSAGE AND REDIRECT
        $_SESSION['delete'] = "<div class='success'>Category Deleted Successfully!</div>";
        //REDIRECT TO MANAGE CATEGORY
        header("location:".SITEURL.'admin/manage-category.php');
    }
    else 
    {
        //SET FAILED MESSAGE AND REDIRECT
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Category.</div>";
        //REDIRECT TO MANAGE CATEGORY
        header("location:".SITEURL.'admin/manage-category.php');
    }

    //RD=EDIRECT TO MANAGE CATEGORY PAGE WITH MESSAGE
}
else 
{
    //REDIRECT TO MANAGE CATEGORY PAGE
    header("location:".SITEURL.'admin/manage-category.php');
}


?>
