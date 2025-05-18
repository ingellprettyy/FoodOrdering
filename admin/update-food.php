<?php include('partials/menu.php'); ?><div class="main-content">

<?php
        if(isset($_GET['id']))
        {
            //GET ALL DETAILS
            //echo "Getting the Data";
            $id = $_GET['id'];

            //CREATE SQL QUERY TO GET ALL SEELECTED FOOD
            $sql2 = "SELECT * FROM tbl_food WHERE id=$id";

            //EXECUTE THE QUERY
            $res2 = mysqli_query($conn, $sql2);

            //GET THE VALUE BASED ON QUERY EXECUTED
            $row2 = mysqli_fetch_assoc($res2);

            //GET THE INIDIVIDUAL VALUES OF SELECTED FOOD
            $food_name = $row2['food_name'];
            $description = $row2['description'];
            $price = $row2['price'];
            $stock = $row2['stock'];
            $current_image = $row2['image_name'];
            $current_category = $row2['category_id'];
            $featured = $row2['featured'];
            $active = $row2['active'];

        }
        else 
        {
            //REDIRECT TO MANAGE FOOD
            header('location:'.SITEURL.'admin/manage-food.php');
        }
?>



 <div class="main-content">
    <div class="wrapper">
        <h1>UPDATE FOOD</h1>

        <br><br>
        
       

    

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">

        <tr>
            <td>Food Name: </td>
            <td>
                <input type="text" name="food_name" value="<?php echo $food_name; ?>"> 
            </td>
          </tr>

          <tr>
            <td>Description: </td>
            <td>
                <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
            </td>
          </tr>

          <tr>
            <td>Price: </td>
            <td>
                <input type="number" name="price" value="<?php echo $price; ?>" >
            </td>
          </tr>

          <tr>
            <td>
                <label for="stock">Stock:</label>
            </td>
            <td>
                <input type="number" name="stock" id="stock" required>
            </td>
        </tr>


          <tr>
            <td>Current Image: </td>
            <td>
            <?php
               if($current_image == "")
               {
                //IMAGE NOT AVAILABLE
                echo "<div class='error'>Image not available.</div>";
               }
                else
                {
                   //IMAGE AVAILABLE
                   ?>
                   <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="90px" height="90px"  >
                <?php
                }
               ?>
            </td>
          </tr>


          <tr>
            <td>Category: </td>
            <td>
              <select name="category">

              <?php 
              //QUERY TO GET ACTIVE CATEGORIES
              $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

              //EXECUTE THE QUERY
              $res = mysqli_query($conn, $sql);

              //COUNT ROWS
              $count = mysqli_num_rows($res);

              //CHECK WHTHER CATEGORY IS AVAILABLE OR NOT
              if($count>0)
              {
                //CATEGORY AVAILABLE
                while($row=mysqli_fetch_assoc($res))
                {
                    $category_food = $row['food_name'];
                    $category_id = $row['id'];

                   // echo "<option value='$category_id'>$category_food</option>";
                   ?>
                   <option <?php if($current_category==$category_id){echo "selected";} ?> value="<?php echo $category_id; ?>"><?php echo $category_food; ?> </option>
                   <?php
                }
              }
              else
              {
                //CATEGORY NOT AVAILABLE
                echo "<option value='0'>CATEGORY Not Available.</option>";
              }


              
              ?>
                
              </select>
            </td>
          </tr>

          


          <tr>
            <td>Select New Image: </td>
            <td>
              <input type="file" name="image">
            </td>
          </tr>

          

          <tr>
            <td>Featured: </td>
            <td>
                <input <?php if($featured=="Yes"){echo "checked";} ?> type="radio" name="featured" value="Yes"> Yes

                <input <?php if($featured=="No"){echo "checked";} ?> type="radio" name="featured" value="No"> No
            </td>
          </tr>

          <tr>
            <td>Active: </td>
            <td>
                <input <?php if($active=="Yes"){echo "checked";} ?> type="radio" name="active" value="Yes"> Yes
                <input <?php if($active=="No"){echo "checked";} ?> type="radio" name="active" value="No"> No
            </td>
          </tr>

         <tr>
            <td>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
            <input type="submit" name="submit" value="Update Food" class="btn-secondary">
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
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $current_image = $_POST['current_image'];
    $category = $_POST['category'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    //2. UPLOAD ITHE IMAGE IF SELECTED
    //CHECK WHTHER UPLOAD BUTTON IS SELECTED OR NOT
    if(isset($_FILES['image']['name']))
    {
      //UPLOAD BUTTON CLICKED
      $image_name = $_FILES['image']['name'];  //NEW IMAGE NAME

      //CHECK IF IMAGE AVAILABLE OR NOT
      if($image_name != "")
      {
        //IMAGE AVAILABLE
        //A. UPLOAD THE NEW IMAGE


           //AUTO RENAME OUR IMAGE
            //GET THE EXTENSION OF OUR IMAGE(jpg, png, gif, etc.) "specialfood1.jpg" -initial image name
            $ext = end(explode('.', $image_name));

            //RENAME THE IMAGE
            $image_name = "Food-Name-".rand(000, 999).'.'.$ext; //e.g. FOOD_CATEGORY_834.jpg -rename category

            $src_path = $_FILES['image']['tmp_name'];

            $dest_path = "../images/food/".$image_name;

            //FINALLY UPLOAD IMAGE
            $upload = move_uploaded_file($src_path, $dest_path);

            //CHECK WHTHER THE IMAGE IS UPLOADED OR NOT 
            //IF THE IMAGE IS NOT UPLOADED THEN WE WILL STOP THE PROCESS AND REDIRECT WITH ERROR MESSAGE
            if($upload==FALSE) 
            {
                // FAILED TO UPLOAD
                $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                //REDIRECT TO Manage Food
                header('location:'.SITEURL.'admin/manage-food.php');
                //STOP THE PROCESS
                die();

            }

        //B. REMOVE THE CURRENT IMAGE IF AVAILABLE
        if($current_image!="")
        {
            //CURRENT IMAGE IS AVAILABLE
            //REMOVE IMAGE
          $remove_path = "../images/food/".$current_image;
          $remove = unlink($remove_path);
  
          //CHECK WHTHER THE IMAGE IS RMOVE OR NOT
  
          //IF FAILED TO REMOVE THEN DISPLAY MESSAGE AND STOP THE PROCESS
          if($remove==FALSE)
          {
            //FAILED TO REMOVE IMAGE
            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
            die(); //STOP THE PROCESS
          }
        } 

      }
      else
      {
        $image_name = $current_image; //DEFAULT IMAGE WHEN IMAGE IS NOT SELECTED
      }
  }
    
    else 
    {
      $image_name = $current_image; //deault when button is not clicked
    }


    ////3. UPDATE food DATABASE
    $sql3 = "UPDATE tbl_food SET
    food_name = '$food_name',
    description = '$description',
    price = $price,
    stock = '$stock',
    image_name = '$image_name',
    category_id = '$category',
    featured = '$featured',
    active = '$active'
    WHERE id=$id ";

    //EXECUTE TE=HE QUERY
    $res3 = mysqli_query($conn, $sql3);

//4. REDIRECT TO MANAGE CATEGORY WITH MESSAGE
    //CHECK WHETHER EXECUTED OR NOT
    if($res3==TRUE)
    {
        //FOOD UPDATED
        $_SESSION['update'] = "<div class='success'>Food Updated Successfully!<br><br><br></div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else 
    {
        //FAILED TO UPDATE FOOD
        $_SESSION['update'] = "<div class='error'>Ops! Failed to Update Food.<br><br><br></div>";
        header('location:'.SITEURL.'admin/manage-food.php');

    }

  }


 
  ?>

</div>

</div>

<style type="text/css">

.tbl-30 {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
  }

  .tbl-30 td {
    padding: 10px;
    border-bottom: 1px solid #ccc;
  }

  .tbl-30 input[type="text"],
  .tbl-30 input[type="number"],
  .tbl-30 textarea,
  .tbl-30 select {
    width: 100%;
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
  }

  .tbl-30 input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 3px;
    cursor: pointer;
  }

  .tbl-30 input[type="submit"]:hover {
    background-color: #45a049;
  }

  .tbl-30 .error {
    color: red;
  }

  .tbl-30 img {
    max-width: 100px;
    max-height: 100px;
  }

</style> 

<?php include('partials/footer.php'); ?>
