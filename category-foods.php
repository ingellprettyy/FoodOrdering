
<?php include('partials-front/menu.php'); ?>

<?php
//CHECK WHTHER ID IS PASSED OR NOT
if(isset($_GET['category_id']))
{
    //CATEGORY ID IS SET AND GET THE ID
    $category_id = $_GET['category_id'];

    //GET THE CATEGORY NAME BASED ON CATEGORY ID
    $sql = "SELECT food_name FROM tbl_category WHERE id=$category_id";

    //EXECUTE THE QUERY
    $res = mysqli_query($conn, $sql);

    //GET THE VALUE FROM DB
    $row = mysqli_fetch_assoc($res);
    //GET THE CATEGORY NAME
    $category_name = $row['food_name'];
}
else
{
    //CATEGORY NOT PASSED
    //REDIRECT T THE MAIN PAGE
    header('location:'.SITEURL);
}
?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <h2>Foods on <a href="#" class="text-white">"<?php echo $category_name; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            //SQL QUERY TO GET FOODS BASED ON SELECTED CATEGORY
             $sql2 = "SELECT * FROM tbl_food WHERE category_id=$category_id";
            
             //EXECUTE THE QUERY
            $res2 = mysqli_query($conn, $sql2);

            //COUNT ROWS 
            $count2 = mysqli_num_rows($res2);

            //CHECK WHTEHER FOOD IS AVAILABLE OR NOT
            if($count2>0)
            {
                //FOOD IS AVAILABLE
                while($row2=mysqli_fetch_assoc($res2))
                {
                    $id = $row2['id'];
                    $food_name = $row2['food_name'];
                    $price = $row2['price'];
                    $description = $row2['description'];
                    $image_name = $row2['image_name'];
                    ?>
                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($image_name=="")
                                       {
                                        //IMAGE NOT AVAILABLE
                                        echo "<div class='error'>Image not available.</div>";
                                        }
                                    else
                                        {
                                       //IMAGE AVAILABLE
                                       ?>
                                         <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                      <?php

                                       }
                                
                                
                                ?>

                            </div>

                            <div class="food-menu-desc">
                                <h4><?php echo $food_name; ?></h4>
                                <p class="food-price">₱<?php echo $price; ?></p>
                                <p class="food-detail">
                                   <?php echo $description; ?><br>
                                <br>

                                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>





                    <?php
                }
            }
            else
            {
                //FOOD NOT AVAILABLE
                echo "<div class='error'>Food not available.</div>";
            }
            ?>



           

            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>

    <style type="text/css">
          .container {
            padding: 30px;
            margin-bottom: 15px;
            width: 85%;
            height: 85%;
            }
         
            .container img {
                width: 95px;
                height: 95px;
            }

            .btn-primary{
                    background-color: #ff6b81;
                    color: white;
                    cursor: pointer;
                    padding: 10px 15px;
                    border: none;
                    border-radius: 5px;
                    font-weight: bold;
                   text-transform: uppercase;
                    transition: background-color 0.3s ease;
                }

            .btn-primary:hover {
                color: white;
                background-color: #ee5253;
            }
            

          


    </style>