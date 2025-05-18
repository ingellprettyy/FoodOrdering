<?php
  //START SESSION 
  session_start();

//CREATE CONSTANTS TO STORE NON REPEATING VALUES
define('SITEURL', 'http://localhost/FoodOrdering/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'foodordering');

$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error()); //DATABASE CONNECTION
$db_select = mysqli_select_db($conn, DB_NAME) or mysqli_close($conn);;  //SELECTING DATABASE


?>

        <?php
        // GET ORDER DETAILS BASED ON ID
        $id = $_GET['id'];
        $sql = "SELECT * FROM tbl_order WHERE id = $id";
        $res = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($res);

        if ($count == 1) {
            // ORDER DETAILS FOUND
            $row = mysqli_fetch_assoc($res);

            $food = $row['food'];
            $price = $row['price'];
            $qty = $row['qty'];
            $total = $row['total'];
            $payment_amount = $row['payment_amount'];
          
            $order_date = $row['order_date'];
            $status = $row['status'];
        ?>

<div class="container">
<div class="wrapper">
    <h1>LYZELARK</h1>
    <p>Pobacion District 1, Silago So. Leyte<br>
    THIS IS AN ORDER SLIP ONLY<br>
    NOT VALID AS OFFICIAL RECEIPT</p>


       ****************************************************
         <h2> RECEIPT</h2> 
       ****************************************************
     
     

       <br>
       <div class="date">Date: <?php echo $order_date; ?></div>

-----------------------------------------------------------------------------<br>

       <table class="tbl-30">
        <tr>
            <th>Food</th>
            <th  class="qty-col">Quantity</th>
            <th>Price</th>
        </tr>
        <tr>
            <td><?php echo $food; ?></td>
            <td  class="qty-col"><?php echo $qty; ?></td>
            <td><?php echo $price; ?></td>
        </tr>
        

------------------------------------------------------------------------------<br>

        <tr>
            <th>Total</th>
            <th></th>
            <th>₱<?php echo $price; ?></th>
        </tr>
        <tr>
            <td>Cash</td>
            <td></td>
            <td>₱<?php echo $payment_amount; ?></td>
        </tr>
        
    </table>
--------------------------------------------------------------------------------<br>
<h1>THANK YOU!</h1>
------------------------------------------------------------------------------<br>

  
           
        <?php
        } else {
            // ORDER DETAILS NOT FOUND
            echo "<div class='error'>Order not found.</div>";
        }
        ?>

        <br><br>
        <a href="<?php echo SITEURL; ?>admin/manage-order.php" class="btn-manage-order no-print">Back</a>
        <a href="javascript:window.print();" class="btn-print no-print">Print</a>
    </div>
</div>

<style type="text/css">

h1, p {
  margin: 0; /* Reset the default margin */
  padding: 0; /* Reset the default padding */
}

  p {
    margin-bottom: 0%;
  }
 
 .container {
  width: 40%;
  height: 85%;
  text-align: center;
  background-color: #f5f5f5;
  border: 1px solid #ddd;
  padding: 40px 20px;
  margin-bottom: 10px;
 }

 .tbl-30 {
  width: 30%;
  margin: 0 auto;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
}

.tbl-30 th, .tbl-30 td {
  padding: 10px 40px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

.tbl-30 th {
  background-color: #f2f2f2;
  padding-top: 15px;
  padding-bottom: 15px;
  
}
 
.tbl-30 th.qty-col,
.tbl-30 td.qty-col {
  padding-left: 120px;
  text-align: right;
}

.btn-manage-order {
  background-color: green;
  color: white;
  padding: 10px 40px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  text-decoration: none;
  float: left;
  margin-bottom: 8px;
  font-size: 20px;
  margin-left: 50px;
}

.btn-manage-order:hover {
  background-color: #45a049;
}

.btn-print {
  background-color: darkblue;
  color: white;
  padding: 10px 40px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-weight: bold;
  text-decoration: none;
  float: left;
  margin-bottom: 8px;
  font-size: 20px;
  margin-left: 40px;
}

.btn-print:hover {
  background-color: blue;
}

.date {
  font-size: 16px;
  font-weight: bold;
  text-align: left;
  margin-top: 10px;
  margin-left: 100px;
}
@media print {
  .no-print {
    display: none;
  }
}
</style>



