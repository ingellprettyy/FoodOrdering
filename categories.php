<?php include('partials-front/menu.php'); ?>



    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

        <?php 
        //SQL QUERY TO DISPLAY CATEGORIES THAT ARE ACTIVE
        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";

        //EXECUTE THE QUERY
        $res = mysqli_query($conn, $sql);

        //COUNT ROWS 
        $count = mysqli_num_rows($res);


       //CHECK WHTEHER CATEGORIES IS AVAILABLE
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
                            //IMAGE NOT AVAILABLE
                            echo "<div class='error'>Image not found.</div>";
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
             echo "<div class='error'>Category not found</div>";
        }
?>
                        
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <?php include('partials-front/footer.php'); ?>

    <style type="text/css">
                 .float-container box-3 {
                    display: flex;
                    flex-direction: column;
                    height: 100%; /* Set the desired height for each item */
                        }

                .float-container box-3 .float-item {
                        flex: 1; /* Distribute the available space equally among the three items */
                        width: 100%; /* Set the width to 100% to occupy the entire horizontal space */
                        transition: transform 0.3s; /* Add transition for smooth effect */
                        }

                .float-container box-3 .float-item:hover {
                    transform: translateX(10px); /* Apply a translate transform on hover */
                }

                .categories {
                    background-color: pink;
                }
</style>