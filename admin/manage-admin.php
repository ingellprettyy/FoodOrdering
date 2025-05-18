<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>

    .tbl-full {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
    }

    .tbl-full th {
      background-color: #4CAF50;
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

    .change-password-icon a {
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

    .change-password-icon a i,
    .change-password-icon a .edit-btn {
      background-color: #9077f5;
      padding: 4px 8px;
      border-radius: 4px;
      color: pink;
      text-decoration: none;
      display: inline-flex;
    }

    .change-password-icon a:hover,
    .change-password-icon a:hover i,
    .change-password-icon a:hover .edit-btn {
      background-color: #B197FC;
    }

    .change-password-icon a i {
      margin-right: 0px;
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
               <h1>MANAGE ADMIN</h1>
               
               <br /> 

               <?php 
               if(isset($_SESSION['add'])) 
               {
                echo $_SESSION['add'];   //DISPLAYING SESSION MESSAGE
                unset($_SESSION['add']);  //REMOVING SESSION MESSAGe
               }

               if(isset($_SESSION['delete'])) 
               {
                echo $_SESSION['delete'];   
                unset($_SESSION['delete']);  

               }

               if(isset($_SESSION['update'])) 
               {
                echo $_SESSION['update'];   
                unset($_SESSION['update']);  

               }

               if(isset($_SESSION['user-not-found'])) 
               {
                echo $_SESSION['user-not-found'];   
                unset($_SESSION['user-not-found']);  

               }

               if(isset($_SESSION['pwd-not-match'])) 
               {
                echo $_SESSION['pwd-not-match'];   
                unset($_SESSION['pwd-not-match']);  

               }

               if(isset($_SESSION['change-pwd'])) 
               {
                echo $_SESSION['change-pwd'];   
                unset($_SESSION['change-pwd']);  

               }


               ?>
               <br><br><br>



               <!-- BUTTON TO ADD ADMIN -->
               <a href="add-admin.php" class="btn-primary">Add Admin</a>
               
               <br /> <br /> <br>
                 <table class="tbl-full">
                      <tr>
                        <th>Serial No.</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Actions</th>
                      </tr>

                      <?php 
                      //QUERY TO GET ALL ADMIN
                       $sql = "SELECT * FROM tbl_admin";
                     //EXECUTE THE QUERY
                      $res = mysqli_query($conn, $sql);

                      //CHECK WHETER THE QUERY IS EXECUTED OR NOT
                      if($res==TRUE)
                      {
                        //COUNT ROWS TTO CHECK WHEHER WE HAVE DATA IN DATABASE OR NOT
                        $count = mysqli_num_rows($res);  //FUNCTION TO GET ALL THE ROWS IN DB

                        $sn=1;  //CREATE A VARIABLE AND ASSIGN THE VALUE

                        //CHEECK THE NUM OF ROWS 
                        if($count>0) 
                        {
                            //WE HAVE DATA IN DB
                            while($rows=mysqli_fetch_assoc($res))
                            {
                                //USING WHILE LOOP TO GET ALL THE DATA FROM DB
                                //AND WHILE LOOP WILL EXECUTE AS LONG AS WE HAVE ATA IN DB

                                //GET INDIVIDUAL DATA
                                $id=$rows['id'];
                                $full_name=$rows['full_name'];
                                $username=$rows['username'];

                                //display the values in our table
                                ?>
                                  <tr>
                                    <td><?php echo $sn++; ?>.</td>
                                    <td><?php echo $full_name; ?></td>
                                    <td><?php echo $username; ?></td>
                                    <td>
                                    <span class="change-password-icon">
                                      <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>">
                                        <i class="fas fa-key"></i>
                                        <span class="edit-btn">Edit</span>
                                      </a>
                                    </span>  

                                    <span class="update-icon">
                                      <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>">
                                          <i class="fas fa-edit"></i>
                                          <span class="update-btn">Update</span>
                                      </a>
                                    </span>  

                                    <span class="delete-icon">
                                      <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>">
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
                            //WE DO NOT HAVE DATA IN DB
                        }
                      }
                      ?>

                      
                 </table>



            </div>
        </div>
        <!-- MAIN CONTENT SECTION ENDS -->


<?php include('partials/footer.php'); ?>