<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>UPDATE CATEGORY</h1>

        <br><br>
        
        <?php
        if(isset($_GET['id']))
        {
            //GET THE ID AND ALL OTHER DETAILS
            //echo "Getting the Data";
            $id = $_GET['id'];
            //CREATE SQL QUERY TO GET ALL OTHE DETAILS
            $sql = "SELECT * FROM tbl_category WHERE id=$id";

            //EXECUTE THE QUERY
            $res = mysqli_query($conn, $sql);

            //COUNT THE ROWS TO CHECKS WHTHER THE ID IS VALID OR NOT
            $count = mysqli_num_rows($res);

            if($count==1)
            {
                //GET ALL DATA
                $row = mysqli_fetch_assoc($res);
                $food_name = $row['food_name'];
                $current_image = $row['image_name'];
                $featured = $row['featured'];
                $active = $row['active'];


            }
            else 
            {
                //REDIRECT TO MANAGE CATEGORY WITH SESSION MESSAGE
                $_SESSION['no-category-found'] = "<div class='error'>Category not found.</div>";
                header('location:'.SITEURL.'admin/manage-category.php');
            }


        }
        else 
        {
            //REDIRECT TO MANAGE CATEGORY
            header('location:'.SITEURL.'admin/manage-category.php');
        }

        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">

        <tr>
            <td>Food Name: </td>
            <td>
                <input type="text" name="food_name" value="<?php echo $food_name; ?>"> 
            </td>
          </tr>

          <tr>
            <td>Current Image: </td>
            <td>
               <?php
               if($current_image != "")
               {
                //DISPLAY THE IMAGE
                ?>
                <img src="<?php echo SITEURL; ?>images/category/<?php echo $current_image; ?>" width="150px" >
                <?php
               }
               else 
               {
                //DISPLAY MESSAGE
                echo "<div class='error'>No image added.</div>";
               }
               ?>
            </td>
          </tr>

          <tr>
            <td>New Image: </td>
            <td>
                <input type="file" name="image" >
            </td>
          </tr>

            <tr>
            <td>Featured:</td>
            <td>
              <label class="toggle-switch">
                <input type="hidden" name="featured" value="No">
                <input type="checkbox" name="featured" value="Yes" <?php if($featured == 'Yes') echo 'checked'; ?>>
                <span class="slider"></span>
              </label>
            </td>
           </tr>

            <tr>
          <td>Active:</td>
          <td>
            <label class="toggle-switch">
              <input type="hidden" name="active" value="No">
              <input type="checkbox" name="active" value="Yes" <?php if($active == 'Yes') echo 'checked'; ?>>
              <span class="slider"></span>
            </label>
          </td>
          </tr>

         <tr>
            <td>
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>" width="90px" height="90px">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="Update Category" class="btn-add-category">
            </td>
         </tr>




        </table>

</form>

<?php 
  if(isset($_POST['submit']))
  {
    //echo "CLICKED";
    //1. GET ALL THE VALUES FROM OUR FORMS
    $id = $_POST['id'];
    $food_name = $_POST['food_name'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //2.UPDATING NEW IMAGE IF SELECTED
    //CHECK WHTHER IMAGE IS SELECTED OR NOT
    if(isset($_FILES['image']['name']))
    {
      //GET THE IMAGE DETAILS
      $image_name = $_FILES['image']['name'];

      //CHECK IF IMAGE AVAILABLE OR NOT
      if($image_name != "")
      {
        //IMAGE AVAILABLE
        //A. UPLOAD THE NEW IMAGE


           //AUTO RENAME OUR IMAGE
            //GET THE EXTENSION OF OUR IMAGE(jpg, png, gif, etc.) "specialfood1.jpg" -initial image name
            $ext = end(explode('.', $image_name));

            //RENAME THE IMAGE
            $image_name = "Food_Category_".rand(000, 999).'.'.$ext; //e.g. FOOD_CATEGORY_834.jpg -rename category

            $source_path = $_FILES['image']['tmp_name'];

            $destination_path = "../images/category/".$image_name;

            //FINALLY UPLOAD IMAGE
            $upload = move_uploaded_file($source_path, $destination_path);

            //CHECK WHTHER THE IMAGE IS UPLOADED OR NOT 
            //IF THE IMAGE IS NOT UPLOADED THEN WE WILL STOP THE PROCESS AND REDIRECT WITH ERROR MESSAGE
            if($upload==FALSE) 
            {
                //SET MESSAGE
                $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                //REDIRECT TO ADD CATEGORY PAGE
                header('location:'.SITEURL.'admin/manage-category.php');
                //STOP THE PROCESS
                die();

            }

        //B. REMOVE THE CURRENT IMAGE IF AVAILABLE
        if($current_image!="")
        {
          $remove_path = "../images/category/".$current_image;
          $remove = unlink($remove_path);
  
          //CHECK WHTHER THE IMAGE IS RMOVE OR NOT
  
          //IF FAILED TO REMOVE THEN DISPLAY MESSAGE AND STOP THE PROCESS
          if($remove==FALSE)
          {
            //FAILED TO REMOVE IMAGE
            $_SESSION['failed-remove'] = "<div class='error'>Failed to remove current image.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
            die(); //STOP THE PROCESS
          }
        }
       

      }
    
    else 
    {
      $image_name = $current_image;
    }
  }
  else 
  {
    $image_name = $current_image;
  }


    //3. UPDATE DATABASE
    $sql2 = "UPDATE tbl_category SET
    food_name = '$food_name',
    image_name = '$image_name',
    featured = '$featured',
    active = '$active'
    WHERE id=$id ";

    //EXECUTE TE=HE QUERY
    $res2 = mysqli_query($conn, $sql2);



    //4. REDIRECT TO MANAGE CATEGORY WITH MESSAGE
    //CHECK WHETHER EXECUTED OR NOT
    if($res2==TRUE)
    {
        //CATEGORY UPDATED
        $_SESSION['update'] = "<div class='success'>Category Updated Successfully!</div>";
        header('location:'.SITEURL.'admin/manage-category.php');
    }
    else 
    {
        //FAILED TO UPDATE CATEGORY
        $_SESSION['update'] = "<div class='error'>Ops! Failed to Update Category.</div>";
        header('location:'.SITEURL.'admin/manage-category.php');

    }

  }


?>


    </div>
</div>

<style type="text/css">
  /* Table Styles */
.tbl-30 {
  width: 100%;
  border-collapse: collapse;
  font-size: 14px;
}

.tbl-30 td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

.tbl-30 tr:last-child td {
  border-bottom: none;
}

.tbl-30 input[type="text"],
.tbl-30 input[type="file"] {
  width: 100%;
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

/* Toggle Switch Styles */
.toggle-switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 24px;
}

.toggle-switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 16px;
  width: 16px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
  border-radius: 50%;
}

input:checked + .slider {
  background-color: #4CAF50;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

.btn-add-category {
  background-color: #4CAF50;
  color: white;
  padding: 10px 18px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
}

.btn-add-category:hover {
  background-color: #45a049;
}
</style>

<?php include('partials/footer.php'); ?>


