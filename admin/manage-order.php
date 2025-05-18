<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <style>
    .update-icon {
        color: #ff4757;
        font-family: Arial;
    }

    .delete-icon {
        color: #ff4757;
    }

    
  </style>
</head>




<?php include('partials/menu.php'); ?>


        <!-- MAIN CONTENT SECTION STARTS -->
        <div class="main-content">
            <div class="wrapper">
               <h1>MANAGE ORDER</h1>

               <br /> <br />

               <?php 
                if(isset($_SESSION['update']))
                {
                    echo $_SESSION['update'];
                    unset($_SESSION['update']);
                }
                
               ?>

               <br><br>

                 <table class="tbl-full">
                      <tr>
                        <th>S.N. </th>
                        <th>Food</th>
                        <th>Price</th>
                        <th>Qty.</th>
                        <th>Total</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Actions</th>

                      </tr>

                      <?php
                      //GET ALL ORDERS FROM DB
                      $sql = "SELECT * FROM tbl_order ORDER BY id DESC"; //DISPLAY THE LATEST ORDER

                      //EXECUTE THE QUERY
                      $res = mysqli_query($conn, $sql);

                      //COUNT THE ROW
                      $count = mysqli_num_rows($res);

                      $sn = 1; //CREATE A SERIAL NUMBER AND SET ITS INITIAL TO 1

                      if($count>0)
                      {
                        //ORDER AVAILABLE
                        while($row=mysqli_fetch_assoc($res))
                        {
                          //GET ALL THE ORDER DETAILS
                          $id = $row['id'];
                          $food = $row['food'];
                          $price = $row['price'];
                          $qty = $row['qty'];
                          $total = $row['total'];
                          $order_date = $row['order_date'];
                          $status = $row['status'];
                          ?>
                          <tr>
                              <td><?php echo $sn++; ?>.</td>
                              <td><?php echo $food; ?></td>
                              <td><?php echo $price; ?></td>
                              <td><?php echo $qty; ?></td>
                              <td><?php echo $total; ?></td>
                              <td><?php echo $order_date; ?></td>

                              <td>
                                <?php
                                //Ordered, On Delivery, Delivered, Cancelled

                                if($status=="Ordered")
                                {
                                  echo "<label>$status</label>";
                                }
                                elseif($status=="Processing")
                                {
                                  echo "<label style='color: orangered;'>$status</label>";
                                }
                                elseif($status=="Served")
                                {
                                  echo "<label style='color: green;'>$status</label>";
                                }
                                elseif($status=="Cancelled")
                                {
                                  echo "<label style='color: red;'>$status</label>";
                                }
                                ?>
                              </td>

                              <td>
                              <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id; ?>" class="update">Update</a>
                              <a href="<?php echo SITEURL; ?>admin/view-order-details.php?id=<?php echo $id; ?>" class="view">View Details</a>
                              </td>
                          </tr>


                          <?php
                        }
                      }
                      else
                      {
                        //ORDER NOT AVAILABLE
                        echo "<tr><td colspan='12' class='error'>Orders not Available</td></tr>";
                      }
                      ?>

                      

                 </table>


                 

            </div>
        </div>
        <!-- MAIN CONTENT SECTION ENDS -->
        
     
<?php include('partials/footer.php'); ?>



<style type="text/css">
 /* Table Styles */
.tbl-full {
  width: 100%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
}

/* Table Header Styles */
.tbl-full th {
  background-color: #333;
  color: #fff;
  padding: 10px;
  text-align: left;
}

/* Table Cell Styles */
.tbl-full td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

/* Alternating Row Styles */
.tbl-full tr:nth-child(even) {
  background-color: #f2f2f2;
}

/* Status Label Styles */
.tbl-full td label {
  padding: 5px 10px;
  border-radius: 3px;
  font-size: 14px;
  font-weight: bold;
}

/* Status Label Colors */
.tbl-full td label[style*="color: green"] {
  background-color: #dff0d8;
  color: #3c763d;
}

.tbl-full td label[style*="color: orangered"] {
  background-color: #fcf8e3;
  color: #8a6d3b;
}

.tbl-full td label[style*="color: red"] {
  background-color: #f2dede;
  color: #a94442;
}

/* Action Button Styles */
.tbl-full td a.update,
.tbl-full td a.view {
  display: inline-block;
  padding: 5px 10px;
  background-color: #337ab7;
  color: #fff;
  text-decoration: none;
  border-radius: 3px;
  margin-right: 5px;
}

.tbl-full td a.update:hover,
.tbl-full td a.view:hover {
  background-color: #23527c;
}
</style>



