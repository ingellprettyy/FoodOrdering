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



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu ">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

             <?php
            //DISPLAY FOODS THAT ARE ACTIVE
            $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
            
             //EXECUTE THE QUERY
            $res = mysqli_query($conn, $sql);

            //COUNT ROWS 
            $count = mysqli_num_rows($res);

            //CHECK WHTEHER FOOD IS AVAILABLE OR NOT
            if($count>0)
            {
                //FOODS AVAILABLE
                while($row=mysqli_fetch_assoc($res))
                {
                    //GET ALL THE AVLUES
                    $id = $row['id'];
                    $food_name = $row['food_name'];
                    $description = $row['description'];
                    $price = $row['price'];
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
                                  <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicken Hawain Pizza" class="img-responsive img-curve" width="90px" height="90px">
                                 <?php

                             }
                            ?>
                            
                        </div>

                        <div class="food-menu-desc">
                            <h4><?php echo $food_name; ?></h4>
                            <p class="food-price"><b>₱<?php echo $price; ?><b></p>
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
                //FOOD NOT AVAILABLE\
                echo "<div class='error'>Food not found.</div>";
            }
            ?>

          

           

            <div class="clearfix"></div>

            

        </div>

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