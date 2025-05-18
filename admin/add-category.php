<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>ADD CATEGORY</h1>
        <br><br>

        <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        if(isset($_SESSION['failed-remove']))
        {
            echo $_SESSION['failed-remove'];
            unset($_SESSION['failed-remove']);
        }
        
        
        ?>

        <!--ADD CATEGRORY FORM STARTS -->
        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
           <tr>
            <td>Food Name: </td>
            <td>
                <input type="text" name="food_name" placeholder="Category Title"> 
            </td>
          </tr>

          <tr>
            <td>Select Image: </td>
            <td>
                <input type="file" name="image">
            </td>
          </tr>

          <tr>
          <td>Featured:   </td>
            <td>
              <label class="toggle-switch">
              <input type="hidden" name="active" value="No">
                <input type="checkbox" name="active" value="Yes">
                <span class="slider"></span>
              </label>
            </td>
          </tr>

          <tr>
            <td>Active:   </td>
            <td>
              <label class="toggle-switch">
              <input type="hidden" name="active" value="No">
                <input type="checkbox" name="active" value="Yes">
                <span class="slider"></span>
              </label>
            </td>
           
          </tr>
     
          <tr>
            <td colspan="2">
                <input type="submit" name="submit" value="Add Category" class="btn-add-category">
            </td>
          </tr>
    

    
        </table>

       </form>

       <!--ADD CATEGRORY FORM ENDS -->

       <?php 
       //CGECK WHTHER THE SUBMIT BUTTON IS CCKED OR NOT
       if(isset($_POST['submit']))
       {
         // echo "Clicked";

         //1. GET THE VALUE FROM CAEGORY FORM
         $food_name = $_POST['food_name'];

         //FOR RADIO INPUT, WE NEED TO CHECK WHTHER THE BUTTON IS SELECTED OR NOT
         if(isset($_POST['featured']))
         {
             //GET THE VALUE FROM FORM
             $featured = $_POST['featured'];
         }
         else 
         {
            //SET THE DEFAULT VALUE
            $featured = "No";
         }

         if(isset($_POST['active']))
         {
            $active = $_POST['active'];
         }
        else  
        {
         $active = "No";
        }

        //CHEC WHTHER IMAGE IS SELECTED OR NOT AND SET THE VALUE FOR IMAGE NAME ACCORDINGLY
       // print_r($_FILES['image']);

       // die(); //BREAK THE CODE HERE

       if(isset($_FILES['image']['name']))
       {
        //UPLOAD IMAGE
        //TO UPLOAD IMAGE WE NEED IMAGE NAME AND SOURCE PATH AND DESTINATION PATH
        $image_name = $_FILES['image']['name'];

        //UPLOAD THE IMAGE ONLY IF IMAGE IS SELECTED
        if($image_name != "")
        {

        
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
                header('location:'.SITEURL.'admin/add-category.php');
                //STOP THE PROCESS
                die();

            }

      }


       }
      else 
      {
        //DONT UPLOAD IMAGE AND SET THE IMAGE NAME VALUE AS BLANK
        $image_name="";
      }
        //2. Create SQL Query to insert category into database
        $sql = "INSERT INTO tbl_category SET
            food_name='$food_name',
            image_name='$image_name',
            featured='$featured',
            active='$active'
            ";

            //3. execute the query and save to database.
            $res = mysqli_query($conn, $sql);

            //4. Chevk whether the query executed or not and data added or not.
            if($res==TRUE)
            {
                //Query executed and category added
                $_SESSION['add'] = "<div class='success'>Category Added Successfully!</div>";
                //Redirected to Manage Category Page
                header('location:'.SITEURL.'admin/manage-category.php');
            }
            else
            {

                //FAILED TO ADD CATEGORY
                $_SESSION['add'] = "<div class='error'>Ops! Failed to Add Category.</div>";
                //Redirected to Manage Category Page
                header('location:'.SITEURL.'admin/add-category.php');
                

            }
       
          }
       
       ?>

    </div>
</div>

<style type="text/css">

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

.tbl-30 input[type="radio"] {
  margin-right: 5px;
}

.btn-add-category {
  background-color: #4CAF50;
  color: white;
  padding: 8px 8px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-left: 315px;
  font-family: Cambria;
  font-weight: bold;
  font-size: 18px;
}

.btn-add-category:hover {
  background-color: #45a049;
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

input:focus + .slider {
  box-shadow: 0 0 1px #4CAF50;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}


</style>






<?php include('partials/footer.php'); ?>