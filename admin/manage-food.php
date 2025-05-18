<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>
    .update-icon a {
        color: #ff4757;
        text-decoration: none;
    }

    .delete-icon a{
        color: #ff4757;
        text-decoration: none;
    }

    
  </style>
</head>

<?php include('partials/menu.php'); ?>


        <!-- MAIN CONTENT SECTION STARTS -->
        <div class="main-content">
            <div class="wrapper">
               <h1>MANAGE FOOD</h1>

               <br /> <br />

               <?php 
                if(isset($_SESSION['add']))
                {
                    echo $_SESSION['add'];
                    unset($_SESSION['add']);
                }

                if(isset($_SESSION['delete']))
                {
                    echo $_SESSION['delete'];
                    unset($_SESSION['delete']);
                }

                if(isset($_SESSION['upload']))
                {
                    echo $_SESSION['upload'];
                    unset($_SESSION['upload']);
                }

                if(isset($_SESSION['unauthorize']))
                {
                    echo $_SESSION['unauthorize'];
                    unset($_SESSION['unauthorize']);
                }

                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
               
               ?>

               <!-- BUTTON TO ADD ADMIN -->
               <a href="<?php echo SITEURL; ?>admin/add-food.php" class="btn-primary">Add Food</a>
               
               <br /> <br />
                 <table class="tbl-full">
                      <tr>
                        <th>Serial No.</th>
                        <th>Food Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                      </tr>
                 
                      <?php 
                      //CREATE SQL QUERY TO GET ALL THE FOOD
                      $sql = "SELECT * FROM tbl_food ORDER BY id DESC";

                      //EXECUTE THE QUERY
                      $res = mysqli_query($conn, $sql);

                      //CHECK THE ROWS WHTHER WE HAVE FOODS OR NOT
                      $count = mysqli_num_rows($res);

                      //CREATE SERIAL NUMBER VARIABLE AND SET DEFAULT VALUE AS 1
                      $sn=1;

                      if($count>0)
                      {
                        //WE HAVE FOOD IN DB
                        //GET THE FFOODS FROM DB AND DISPLAY
                        while($row=mysqli_fetch_assoc($res))
                        {
                          //GET THE VALUE FROM INDIVIDUAL COLUMN
                          $id = $row['id'];
                          $food_name = $row['food_name'];
                          $price = $row['price'];
                          $stock = $row['stock'];
                          $image_name = $row['image_name'];
                          $featured = $row['featured'];
                          $active = $row['active'];
                          ?>
                          <tr>
                            <td><?php echo $sn++; ?>.</td>
                            <td><?php echo $food_name; ?></td>
                            <td>₱<?php echo $price; ?></td>
                            <td><?php echo $stock; ?></td>
                            <td>
                              <?php 
                              //CHCEKC WHTEHR WE HAVE IMAGE OR NOT
                              if($image_name=="")
                              {
                                //WE DO NOT HAVE IMAGE, DISPLAY ERROR ,ESSAGE
                                echo "<div class='error'>Image not Added.</div>";
                              }
                              else 
                              {
                                //we have image, display image
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>"width="70px" height="70px">
                                
                                <?php
                              }
                              ?>
                            </td>

                            <td><?php echo $featured; ?></td>
                            <td><?php echo $active; ?></td>
                            <td>
                            <span class="update-icon"> <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>"><i class="fas fa-edit"></i> Update </a></span>  
                            
                            </td>
                          </tr>


                          <?php

                        }
                      }
                      else 
                      {
                        //FOOD NOT ADDED IN DB
                        echo "<tr> <td colspan='7' class='error'>Ops! Food not Added Yet. </td></tr>";
                      }

                      //

                      
                      ?>
                     

                 </table>

            </div>
        </div>
        <!-- MAIN CONTENT SECTION ENDS -->

<style type="text/css">
  /* Manage Food Table Styles */
.tbl-full {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  margin-bottom: 20px;
}

.tbl-full th {
  background-color: #337ab7;
  color: #fff;
  padding: 10px;
  text-align: left;
}

.tbl-full td {
  border-bottom: 1px solid #ddd;
  padding: 10px;
}


.tbl-full .error {
  color: #dc3545;
  font-weight: bold;
}

.update-icon a,
.delete-icon a {
  color: #337ab7;
  text-decoration: none;
  margin-right: 10px;
}

.update-icon a:hover,
.delete-icon a:hover {
  color: #23527c;
}

.update-icon i,
.delete-icon i {
  margin-right: 5px;
}
</style>
<?php include('partials/footer.php'); ?>
