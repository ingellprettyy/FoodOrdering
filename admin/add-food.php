<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>ADD FOOD</h1>

        <br><br>

        <?php 
        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        
        
        ?>


        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">

                <tr>
                    <td>Food Name: </td>
                    <td>
                        <input type="text" name="food_name" placeholder="Food Name">

                    </td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food."></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
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
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">

                        <?php 
                            //Create PHP Code to display categories from Database
                             //1. Create SQL to get all active categories
                             $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

                             //executing query
                             $res = mysqli_query($conn, $sql);

                            //Count rows to check whether we have categories or not
                              $count = mysqli_num_rows($res);

                             //If count is greater than zero, we have categories else we do not have categories
                             if($count>0)
                                {
                                    //we have categories
                                    while($row=mysqli_fetch_assoc($res))
                                    {
                                        //get the details of categories 
                                        $id = $row['id'];
                                        $food_name = $row['food_name'];

                                        ?>
                                        <option value="<?php echo $id; ?>"><?php echo $food_name; ?></option>
                                        <?php
                                    }   

                                }

                                else 
                                {
                                    //we do not have category

                                    ?>
                                    <option value="0">No Category Found</option>
                                    <?php
                                }


                                ?>

                        </select>
                    </td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio"  name="featured" value="Yes"> Yes
                        <input type="radio"  name="featured" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio"  name="active" value="Yes"> Yes
                        <input type="radio"  name="active" value="No"> No
                    </td>
                </tr>

                <tr>
                    <td colspan="2"> 
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>



            </table>
        </form>



        <?php 

          //CHECK WHETHER THE BUTTON IS CLICKED OR NOT
          if(isset($_POST['submit']))
          {
            //ADD THE FOOD IN DATABASE
            //echo "CLICKED";

            //1. GET THE DATA FROM FORM
            $food_name = $_POST['food_name'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $stock = $_POST['stock'];
            $category = $_POST['category'];

            //check whther radio button for featured and active are checked or not
            if(isset($_POST['featured']))
            {
                $featured = $_POST['featured'];
            }
            else 
            {
                $featured = "No"; //SETTING THE DEFAULT VALUE
            }

            if(isset($_POST['active']))
            {
                $active = $_POST['active'];
            }
            else 
            {
                $active = "No"; //SETTING THE DEFAULT VALUE
            }


            //2. UPLOAD THE IMAGE IF SELECTED
            //CHECK WHETHER TH SELECT IMAGE IS CLICKED OR NOT AND UPLOAD THE IMAGE ONLY IF THE IMAGE IS SELECTED
            if(isset($_FILES['image']['name']))
            {
                //GET THE DETAILS OF THE SELECTED IMAGE
                $image_name = $_FILES['image']['name'];

                //CHECK WHTHER IMAGE IS SELECTED OR NOT AND UPLOAD IMAGE ONLY IF SELECTED
                if($image_name!="")
                {
                    //IMAGE IS SELECTEED
                    //A. RENAME THE IMAGE
                    //GET THE EXTENSION OF SELECTED IMAGE (JPEG, PNG,ETC.)
                    $ext = end(explode('.', $image_name));



                    //CREATE NEW NAME FOR IMAGE
                    $image_name = "Food-Name-".rand(0000,9999).'.'.$ext; //NEW IMAGE NAME MAYBE "FOOD-NAME-657"



                    //B. UPLOAD THE IMAGE
                    //GET THE SRC PATH AND DESTINATION PATH

                    //SOURCE PATH IS THE CURRENT LOCATION OF THE IMAGE
                    $src = $_FILES['image']['tmp_name'];

                    //destination path for the image to be uploaded
                    $dst = "../images/food/".$image_name;

                    //FINALLY UPLOAD THE FOOD IMAGE
                    $upload = move_uploaded_file($src, $dst);

                    //CHECK WHETHER IMAGE UPLOADED OR NOT
                    if($upload==FALSE) 
                    {
                        //FAILED TO UPLOAD THE IMAGE
                        //REDIRECT TO ADD FOOD PAGE WITH ERROR MESSAGE
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('location:'.SITEURL.'admin/add-food.php');
                        //STOP THE PROCESS
                        die();
        
                    }


                }


            }
            else
            {
                $image_name = ""; //SETTING DEFAULT VALUE AS BLANK
            }


            //3. INSERT INTO DB

            //CREATE SQL QUERY TO SAVE OR ADD FOOD
            //FOR NUMERICAL WE DONT NEED TO PASS VALUE INSIDE QUOTES '' BUT FOR STRING VALUE IT IS COMPULSORY T ADD QUOTES ''
            $sql2 = "INSERT INTO tbl_food SET
            food_name ='$food_name',
            description ='$description',
            price = $price,
            stock = $stock,
            image_name = '$image_name',
            category_id = $category,
            featured = '$featured',
            active = '$active'
            ";

            //EXECUTE QUERY
            $res2 = mysqli_query($conn, $sql2);

            //CHECK WHTHER DATA IS INSERTED OR NOT
            //4. REDIRECT WITH MESSAGE TO MANAGE FOOD PAGE
            if($res2==TRUE)
            {
                  //DATA INSERTED SUCCESSFULLY
                  $_SESSION['add'] = "<div class='success'>Food Added Successfully!<br><br><br></div>";
                  header('location:'.SITEURL.'admin/manage-food.php');

            }
            else 
            {
                //FAILED TO INSERT DATA
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.<br><br><br></div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }


            
          }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>