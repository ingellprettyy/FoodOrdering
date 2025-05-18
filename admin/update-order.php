<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>UPDATE ORDER</h1>
        <br><br>

        <?php
        //check whteher id is set or not
         if(isset($_GET['id']))
         {
             //GET other  DETAILS
             //echo "Getting the Data";
             $id = $_GET['id'];

             //GETA LL OTHER DETAILS BASE ON ITS ID
             //CREATE SQL QUERY TO GET ALL SEELECTED FOOD
             $sql = "SELECT * FROM tbl_order WHERE id=$id";
 
             //EXECUTE THE QUERY
             $res = mysqli_query($conn, $sql);

             //COUNT ROWS
             $count = mysqli_num_rows($res);

             if($count==1)
             {
                //DETAILS AVAILABLE
                //GET THE VALUE BASED ON QUERY EXECUTED
                $row = mysqli_fetch_assoc($res);

                //GET THE INIDIVIDUAL VALUES OF SELECTED FOOD
                    $food = $row['food'];
                    $price = $row['price'];
                    $qty = $row['qty'];
                    $status = $row['status'];
                    
             }
             else 
             {
                //DETAILS NOT AVAILABLE
                //REDIRECT TO MANAGE ORDER
                header('location:'.SITEURL.'admin/manage-order.php');

             }
 
         }
         else 
         {
             //REDIRECT TO MANAGE ORDER PAGE
             header('location:'.SITEURL.'admin/manage-order.php');
         }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
        <table class="tbl-30">

        <tr>
            <td>Food Name:</td>
            <td><b><?php echo $food; ?></b></td>
        </tr>

        <tr>
            <td>Price:</td>
            <td><b>₱<?php echo $price; ?></b></td>
        </tr>

        <tr>
            <td>Qty.</td>
            <td>
                <input type="number" name="qty" value="<?php echo $qty; ?>">
            </td>
        </tr>

        <tr>
            <td>Status</td>
            <td>
                <select name="status">
                    <option <?php if($status=="Ordered"){echo "selected";} ?> value="Ordered">Ordered</option>
                    <option <?php if($status=="Processing"){echo "selected";} ?>  value="Processing">Processing</option>
                    <option <?php if($status=="Served"){echo "selected";} ?>  value="Served">Served</option>
                    <option <?php if($status=="Cancelled"){echo "selected";} ?>  value="Cancelled">Cancelled</option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <input type="hidden" name="price" value="<?php echo $price; ?>">
                <input type="submit" name="submit" value="Update Order" class="update">
            </td>
        </tr>


    </table>
</form>

<?php 

//CHECK WHTHER UPDATE BUTTON IS CLICK OR NOT
if(isset($_POST['submit']))
{
    //echo "Clicked";
    //GET ALL THE VALUES FROM FORM
    $id = $_POST['id'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    
    

    $total = $price * $qty;

    $status = $_POST['status'];

    //UPDATE VALUES
    $sql2 = "UPDATE tbl_order SET
    qty = $qty,
    total = $total,
    status = '$status'
   
    WHERE id=$id ";

    //EXECUTE THE QUERY
    $res2 = mysqli_query($conn, $sql2);


    //CHECK WHETHER UPDATE OR NOT
    //REDIRECT TO MANAGE ORDER WITH MESSAGE
    if($res2==TRUE)
    {
        //UPDATED
        $_SESSION['update'] = "<div class='success'>Order Updated Successfully!</div>";
        header('location:'.SITEURL.'admin/manage-order.php');
    }
    else 
    {
        //FAILED TO UPDATE
        $_SESSION['update'] = "<div class='error'>Ops! Failed to Update Order.</div>";
        header('location:'.SITEURL.'admin/manage-order.php');

    }


}

?>
   
   
 
        


    </div>
</div>


<?php include('partials/footer.php'); ?>

<style type="text/css">
 /* Update Order Table Styles */
.tbl-30 {
  width: 30%;
  border-collapse: collapse;
  font-family: Arial, sans-serif;
  margin-bottom: 20px;
}

.tbl-30 tr {
  border-bottom: 1px solid #ddd;
}

.tbl-30 td {
  padding: 10px;
}

.tbl-30 td:first-child {
  font-weight: bold;
  width: 40%;
}

.tbl-30 td:last-child {
  width: 60%;
}

.tbl-30 input[type="number"],
.tbl-30 select {
  width: 100%;
  padding: 5px;
  border: 1px solid #ccc;
  border-radius: 3px;
}

.tbl-30 input[type="submit"].update {
  background-color: #337ab7;
  color: #fff;
  border: none;
  padding: 8px 15px;
  border-radius: 3px;
  cursor: pointer;
}

.tbl-30 input[type="submit"].update:hover {
  background-color: #23527c;
}
</style> 