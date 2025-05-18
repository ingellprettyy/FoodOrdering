<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>
    .update-icon a{
        color: #ff4757;
        text-decoration: none;
    }

    .delete-icon a{
      color: #ff4757;
      text-decoration: none;
    }

    .change-password-icon a {
      color: #ff4757;
      text-decoration: none;
      margin: 0 4px;
    }


    .tbl-full {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
    }

    .tbl-full th {
      background-color: violet;
      color: white;
      padding: 12px;
      text-align: left;
    }

    .tbl-full td {
      border-bottom: 1px solid #ddd;
      padding: 10px;
    }

    .tbl-full tr {
      background-color: lavender;
    }

    .tbl-full tr:hover {
      background-color: skyblue;
    }


    .update-icon a {
      color: #B197FC;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      background-color: #9077f5;
      color: #fff;
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 15px;
      text-decoration: none;
      display: inline-flex;
    }

    .update-icon a i,
    .update-icon a .update-btn {
      background-color: #9077f5;
      padding: 4px 8px;
      border-radius: 4px;
      color: green;
    }

    .update-icon a:hover,
    .update-icon a:hover i,
    .update-icon a:hover .update-btn {
      background-color: #B197FC;
    }

    .update-icon a i {
      margin-right: 0px;
    }


    .delete-icon a {
      color: #B197FC;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      background-color: #9077f5;
      color: #fff;
      padding: 4px 8px;
      border-radius: 4px;
      font-weight: bold;
      font-size: 15px;
      text-decoration: none;
      display: inline-flex;
    }

    .delete-icon a i,
    .delete-icon a .delete-btn {
      background-color: #9077f5;
      padding: 4px 8px;
      border-radius: 4px;
      color: red;
    }

    .delete-icon a:hover,
    .delete-icon a:hover i,
    .delete-icon a:hover .delete-btn {
      background-color: #B197FC;
    }

    .delete-icon a i {
      margin-right: 0px;
    }


  </style>
</head>


<?php include('partials/menu.php'); ?>


        <!-- MAIN CONTENT SECTION STARTS -->
        <div class="main-content">
            <div class="wrapper">
               <h1>MANAGE CATEGORY</h1>

               <br /> <br />

               
        <?php 
        if(isset($_SESSION['add']))
        {
            echo $_SESSION['add'];
            unset($_SESSION['add']);
        }

        if(isset($_SESSION['remove']))
        {
            echo $_SESSION['remove'];
            unset($_SESSION['remove']);
        }

        if(isset($_SESSION['delete']))
        {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']);
        }

        if(isset($_SESSION['no-category-found']))
        {
            echo $_SESSION['no-category-found'];
            unset($_SESSION['no-category-found']);
        }

        if(isset($_SESSION['update']))
        {
            echo $_SESSION['update'];
            unset($_SESSION['update']);
        }

        if(isset($_SESSION['upload']))
        {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }

        

        
        ?>
        <br><br>



               <!-- BUTTON TO ADD ADMIN -->
               <a href="<?php echo SITEURL; ?>admin/add-category.php" class="btn-primary">Add Category</a>
               
               <br /> <br /> <br>
                 <table class="tbl-full">
                      <tr>
                        <th>Serial No.</th>
                        <th>Food Name</th>
                        <th>Image</th>
                        <th>Featured</th>
                        <th>Active</th>
                        <th>Actions</th>
                      </tr>

                      <?php 

                      //QUERY TO GET ALL CATEGORIES FROM DB
                      $sql = "SELECT * FROM tbl_category
                      ";


                     //EXECUTE QUERY
                     $res = mysqli_query($conn, $sql);

                     //COUNT ROWS
                     $count = mysqli_num_rows($res);

                     //CREATE SERIAL NUMBER VARIABLE AND ASSIGN VALUE AS 1
                     $sn=1;


                     //CHECK WHTHER WE HAVE DATA IN DB OR NOT
                     if($count>0)
                     {
                      //WE HAVE DATA IN DB
                      //GET THE DATA AND DISPLAY
                      while($row=mysqli_fetch_assoc($res))
                      {
                        $id = $row['id'];
                        $food_name = $row['food_name'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];

                        ?>
                            <tr>
                              <td><?php echo $sn++; ?>.</td>
                              <td><?php echo $food_name; ?></td>

                              <td>
                              <?php 
                                   //CHECK WHTEHER IMGE NAME IS AVAILABLE OR NOT
                                   if($image_name!="")
                                   {
                                    //DISPLAY IMAGE
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" width="50px" height="50px" >

                                    <?php
                                   }
                                   else 
                                   {
                                    //DISPLAY THE MESSAGE
                                    echo "<div class='error'>No image added.</div>";
                                   }
                               ?>
                              </td>


                              <td><?php echo $featured ?></td>
                              <td><?php echo $active ?></td>
                              <td>

                              <span class="update-icon">
                                      <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>">
                                          <i class="fas fa-edit"></i>
                                          <span class="update-btn">Update</span>
                                      </a>
                              </span>  

                              <span class="delete-icon">
                                      <a href="<?php echo SITEURL; ?>admin/delete-category.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>">
                                          <i class="fas fa-trash"></i>
                                          <span class="delete-btn">Delete</span>
                                     </a>
                              </span> 
                                     

                                  </td>
                            </tr>
                        <?php


                      }
                     }
                     else 
                     {
                      //WE DO NOT HAVE DATA
                      //WE WILL DISPLAY THE MESSAGE INSIDE TABLE
                      ?>

                      <tr>
                        <td colspan="6"><div class="error">No Category Added.</div></td>
                      </tr>

                      <?php
                     }
                      
                      
                      
                      ?>

                     

                    

                 </table>


            </div>
        </div>
        <!-- MAIN CONTENT SECTION ENDS -->


<?php include('partials/footer.php'); ?>