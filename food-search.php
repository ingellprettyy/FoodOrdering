<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
             //GET THE SEARCH KEYWORD
             //$search = $_POST['search'];  //OLD QUERY TO GET SEARCH
             $search = mysqli_real_escape_string($conn, $_POST['search']);
            ?>
            
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search; ?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php

            //SQL QUERY TO GET FOODS BASED ON SEARCH KEYWORD
            //$search = burger '; DROP database name;
            //"SELECT * FROM tbl_food WHERE food_name LIKE '%burger%' OR description LIKE '%burger%'";
            $sql = "SELECT * FROM tbl_food WHERE food_name LIKE '%$search%' OR description LIKE '%$search%'";

            //EXECUTE THE QUERY
            $res = mysqli_query($conn, $sql);

            //COUNT ROWS
            $count = mysqli_num_rows($res);

            //CHECK WHTER FOOD IS AVAILABLE OR NOT
            if($count>0)
            {
                //FOOD AVAILABLE
                while($row=mysqli_fetch_assoc($res))
                {
                //GET THE DETAILS
                $id = $row['id'];
                $food_name = $row['food_name'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                             //CHECK WHTHER IMAGE IS AVAILABLE OR NOT
                             if($image_name=="")
                             {
                                 //IMAGE NOT AVAILABLE
                                 echo "<div class='error'>Image not available.</div>";
                             }
                             else
                             {
                                 //IMAGE AVAILABLE
                                 ?>
                                  <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicken Hawain Pizza" class="img-responsive img-curve" >
                                 <?php

                             }



                            ?>
                           
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $food_name; ?></h4>
                            <p class="food-price">₱<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>

                            <a href="#" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                <?php





                }
            }
            else
            {
                //FOOD NOT AVAILABLE
                echo "<div class='error'>Food not found.</div>";

            }


            ?>



          
            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>


   