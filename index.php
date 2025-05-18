<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php

    if(isset($_SESSION['order'])) 
    {
     echo $_SESSION['order'];   
     unset($_SESSION['order']);  

    }
    ?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

        <?php 
        //CREATE SQL QUERY TO DISPLAY CATEGORIES FROM DB
        $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

        //EXECUTE THE QUERY
        $res = mysqli_query($conn, $sql);

        //COUNT ROWS TO CHECK WHTHER CATEGORY IS AVAILABLE OR NOT
        $count = mysqli_num_rows($res);

        if($count>0)
        {
            //CATEGORIES AVAILABLE
            while($row=mysqli_fetch_assoc($res))
            {
                //GET THE VALUE LIKE ID FOODNAME IMAGENAME
                $id = $row['id'];
                $food_name = $row['food_name'];
                $image_name = $row['image_name'];
                ?>
                  <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                    <div class="box-3 float-container">
                        <?php
                        //CHECK WHTHER IF IMAGE IS AVAILABLE OR NOT
                        if($image_name=="")
                        {
                            //DISPLAY MESSAGE
                            echo "<div class='error'>Image not available.</div>";
                        }
                        else 
                        {
                            //IMAGE AVAILABLE
                            ?>
                           
                            <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="Pizza" class="img-responsive img-curve" width="500px" height="500px">
                            <?php
                        }
                        ?>

                     
                       <h3 class="float-text text-white"><?php echo $food_name; ?></h3>
                    </div>
                  </a>
                <?php


            }
        }
        else 
        {
            //CATEGORIES NOT AVAILABLE
            echo "<div class='error'>Category not added</div>";
        }


        ?>

      


            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php
            
            //GETTING FOODS FROM DATABASE THAT ARE ACTIVE AND FEATURED
            //SQL QUERY
            $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 30";
            
             //EXECUTE THE QUERY
            $res2 = mysqli_query($conn, $sql2);

            //COUNT ROWS 
            $count2 = mysqli_num_rows($res2);

            //CHECK WHTEHER FOOD IS AVAILABLE OR NOT
            if($count2>0)
            {
                //FOOD AVAILABLE
                while($row=mysqli_fetch_assoc($res2))
                {
                    //GET ALL THE AVLUES
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
                                     <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve" width="90px" height="90px">
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

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->


    <?php include('partials-front/footer.php'); ?>

    <style type="text/css">
    
         .food-menu-box {
            padding: 25px;
            margin-bottom: 15px;
            width: 40%;
            height: 45%;
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

   