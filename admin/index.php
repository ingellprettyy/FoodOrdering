
<?php include('partials/menu.php'); ?>

        <!-- MAIN CONTENT SECTION STARTS -->
        <div class="main-content">
            <div class="wrapper">
               <h1>DASHBOARD</h1>
               


               <?php 
                 if(isset($_SESSION['login'])) 
                 {
                   echo $_SESSION['login'];   
                   unset($_SESSION['login']);  
                 }
               ?>

               <br><br>

               <div class="col-4 text-center">
              <?php
                 //SQL QUERY
                 $sql = "SELECT * FROM tbl_category";
                 //EXECUTE QUERY
                 $res = mysqli_query($conn, $sql);
                 //COUNT ROWS
                 $count = mysqli_num_rows($res);
              ?>
                 <h1><?php echo $count; ?></h1>
                 <br />
                 <b>Categories</b>
               </div>


               <div class="col-4 text-center">
               <?php
                 //SQL QUERY
                 $sql2 = "SELECT * FROM tbl_food";
                 //EXECUTE QUERY
                 $res2 = mysqli_query($conn, $sql2);
                 //COUNT ROWS
                 $count2 = mysqli_num_rows($res2);
              ?>
                 <h1><?php echo $count2; ?></h1>
                 <br />
                 <b>Foods</b>
               </div>


               <div class="col-4 text-center">
               <?php
                 //SQL QUERY
                 $sql3 = "SELECT * FROM tbl_order";
                 //EXECUTE QUERY
                 $res3 = mysqli_query($conn, $sql3);
                 //COUNT ROWS
                 $count3 = mysqli_num_rows($res3);
              ?>
                 <h1><?php echo $count3; ?></h1>
                 <br />
                 <b>Total Orders</b>
               </div>

           <div class="col-4 text-center">
            <?php
               //CRAETE SQL QUERY TO GET TOTAL REVENUE GENERATED
               //AGGREGATE FUNCTION IN SQL
               $sql4 = "SELECT SUM(total) AS Total FROM tbl_order WHERE status='Served'";

               //EXECUTE THE QUERY
               $res4 = mysqli_query($conn, $sql4);

               //GET THE VALUE
               $row4 = mysqli_fetch_assoc($res4);

               //GET THE TOTAL REVENUE
               $total_revenue = $row4['Total'];

            ?>
                 <h1>₱<?php echo $total_revenue; ?></h1>
                 <br />
                 <b>Revenue Generated</b>
               </div>

               <div class="text-center">
                        <?php
                        // DISPLAY RECENT ORDERS
                        $sql_recent_orders = "SELECT * FROM tbl_order ORDER BY id ASC";
                        $res_recent_orders = mysqli_query($conn, $sql_recent_orders);
                        

                        if (mysqli_num_rows($res_recent_orders) > 0)

                         {
                           echo '<h2 class="recent-orders-heading">Recent Orders:</h2><br><br>';
                           echo '<table class="recent-orders-table" >';
                           echo '<tr>';
                           echo '<th>Serial No.</th>';
                           echo '<th>Food</th>';
                           echo '<th>Price</th>';
                           echo '<th>Quantity</th>';
                           echo '<th>Order Date</th>';
                           echo '<th>Status</th>';
                           echo '<th>Total</th>';
                           echo '</tr>';


                           $sn = 1;
                           while ($row_recent_orders = mysqli_fetch_assoc($res_recent_orders)) {
                                 echo '<tr>';
                                 echo '<td>'.$sn.'.</td>';
                                 echo '<td>' . $row_recent_orders['food'] . '</td>';
                                 echo '<td>' . $row_recent_orders['price'] . '</td>';
                                 echo '<td style="text-align:center;">' . $row_recent_orders['qty'] . '</td>';
                                 echo '<td>' . $row_recent_orders['order_date'] . '</td>';
                                 echo '<td>' . $row_recent_orders['status'] . '</td>';
                                 echo '<td>₱' . $row_recent_orders['total'] . '</td>';
                                 echo '</tr>';
                                 $sn++;
                           }

                           echo '</table>';
                        } else {
                           echo 'No recent orders.';
                        }
                        ?>
                     </div>


               <div class="clearfix"></div>
        

            </div>
        </div>
        <!-- MAIN CONTENT SECTION ENDS -->

<?php include('partials/footer.php'); ?>

<style type="text/css">
    .recent-orders-table {
            width: 100%;
            border-collapse: collapse;
        }

    .recent-orders-table th,
   .recent-orders-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 3px solid pink;
            border-right: 1px solid #ddd; /* Add vertical line */
         }

   .recent-orders-table th {
            background-color: #758EB7;
            border-right: 1px solid #fff; /* Add vertical line */
            color: #fff; /* Change text color to white */
         }
   .recent-orders-table td {
      background-color: #FF7589;
      
         }

        .recent-orders-heading {
            margin-top: 10px;
            text-align: left;
         }

        .col-4 {
            width: 18%;
            background-color: #FF7B89;
            margin: 1%;
            padding: 2%;
            float: left;
         }
         
         h1 {
            color: #6F5F90;
         }
</style>
     