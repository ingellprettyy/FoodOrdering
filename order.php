<?php 
ob_start(); // Start output buffering
include('partials-front/menu.php'); 

//CHECK WHETHER FOOD ID IS SET OR NOT
if(isset($_GET['food_id'])) {
    //GET THE FOOD ID AND DETAILS OF THE SELECTED FOOD
    $food_id = $_GET['food_id'];
    //GET THE DETAILS OF THE SELECTED FOOD
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    //EXECUTE THE QUERY
    $res = mysqli_query($conn, $sql);
    //COUNT ROWS
    $count = mysqli_num_rows($res);
    //CHECK WHTEHER THE DATA IS AVAILABLE OR NOT
    if($count == 1) {
        //WE HAVE DATA
        //GET THE DATA FROM DB
        $row = mysqli_fetch_assoc($res);
        $food_name = $row['food_name'];
        $price = $row['price'];
        $image_name = $row['image_name'];
        $stock = $row['stock'];
    } else {
        //FOOD NOT AVAILABLE
        //REDIRECT TO HOMEPAGE
        header('location:'.SITEURL);
        ob_end_flush(); // End output buffering and send output
        exit(); // Ensure no further code is executed
    }
} else {
    //REDIRECT TO HOMEPAGE
    header('location:'.SITEURL);
    ob_end_flush(); // End output buffering and send output
    exit(); // Ensure no further code is executed
}
?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        <h2 class="text-center text-black">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order" onsubmit="return validatePayment()">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php 
                    //CHECK WHETHER IMAGE IS AVAILABLE OR NOT
                    if($image_name == "") {
                        //IMAGE NOT AVAILABLE
                        echo "<div class='error'>Image not available.</div>";
                    } else {
                        //IMAGE IS AVAILABLE
                        ?>
                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $food_name; ?>" class="img-responsive img-curve">
                        <?php
                    }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $food_name; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $food_name; ?>">

                    <p class="food-price">₱<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <select name="qty" class="input-responsive" required onchange="calculateTotal()">
                        <?php
                        for ($i = 1; $i <= min($stock, 200); $i++) {
                            echo "<option value=\"$i\">$i</option>";
                        }
                        if ($stock > 200) {
                            echo "<option value=\"200\">Out of Stock</option>";
                        }
                        ?>
                    </select>

                    <div class="order-label">Stock</div>
                    <?php
                    if ($stock <= 0) {
                        echo 'Out of Stock';
                    } else {
                        echo '<input type="text" name="stock" value="' . $stock . '" class="input-responsive" readonly>';
                    }
                    ?>

                    <div class="order-label">Total Amount:</div>
                    <input type="text" name="total" class="input-responsive" id="total" value="<?php echo $price; ?>" readonly>

                    <div class="order-label">Payment Method</div>
                    <input type="text" name="payment_method" class="input-responsive" value="Cash" readonly>

                    <div class="order-label">Payment Amount:</div>
                    <input type="number" name="payment_amount" class="input-responsive" id="payment_amount" min="<?php echo $price; ?>" onchange="calculateChange()" required>

                    <div class="order-label">Change</div>
                    <input type="text" name="change_amount" class="input-responsive" id="change" value="0" readonly>

                    <!-- Add the error message -->
                    <div id="payment_error" style="color: red;"></div>
                    <div id="payment_success" style="color: green;"></div>
                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary" onclick="validatePayment()">
                </div>
            </fieldset>
        </form> 

        <script>
        function calculateTotal() {
            const quantity = parseInt(document.querySelector('select[name="qty"]').value);
            const price = <?php echo $price; ?>;
            const totalAmount = quantity * price;
            document.querySelector('#total').value = '₱' + totalAmount;
            calculateChange();
        }

        function calculateChange() {
            const paymentAmount = parseFloat(document.querySelector('input[name="payment_amount"]').value);
            const totalAmount = parseFloat(document.querySelector('#total').value.replace('₱', ''));
            if (isNaN(paymentAmount) || paymentAmount < totalAmount) {
                document.querySelector('#change').value = 'Invalid Amount';
            } else {
                const change = paymentAmount - totalAmount;
                document.querySelector('#change').value = '₱' + change.toFixed(2);
            }
        }

        function validatePayment() {
            const paymentAmount = parseFloat(document.querySelector('input[name="payment_amount"]').value);
            const totalAmount = parseFloat(document.querySelector('#total').value.replace('₱', ''));
            if (isNaN(paymentAmount) || paymentAmount < totalAmount) {
                document.querySelector('#payment_error').textContent = 'Ops! You cannot proceed. Please settle your payment first.';
                document.querySelector('#payment_success').textContent = '';
                return false; // Prevent form submission
            } else {
                document.querySelector('#payment_error').textContent = ''; // Reset the error message
                document.querySelector('#payment_success').textContent = 'Payment Successful!'; // Display payment success message
                return true; // Allow form submission
            }
        }
        </script>

        <?php 
        //CHECK WHETHER SUBMIT BUTTON IS CLICKED OR NOT
        if(isset($_POST['submit'])) {
            //GET ALL THE DETAILS FROM FORM
            $food = $_POST['food'];
            $price = $_POST['price'];
            $qty = $_POST['qty'];
            $stock = $_POST['stock'];
            $payment_amount = $_POST['payment_amount'];

            $total = $price * $qty; //total = price * qty
            $order_date = date("Y-m-d h:i:sa"); //ORDER DATE
            $status = "Ordered"; //ORDERED, PROCESSING, SERVED, CANCELLED

            //SAVE THE ORDER IN DB
            //CREATE SQL TO SAVE DATA
            $sql2 = "INSERT INTO tbl_order SET
                food = '$food',
                price = $price,
                qty = $qty,
                stock = $stock,
                total = $total,
                order_date = '$order_date',
                status = '$status',
                payment_amount = $payment_amount";

            // Update the stock in the tbl_food table
            $new_stock = $stock - $qty;
            $sql3 = "UPDATE tbl_food SET stock = $new_stock WHERE id = $food_id";
            $res3 = mysqli_query($conn, $sql3);

            //EXECUTE QUERY
            $res2 = mysqli_query($conn, $sql2);

            //CHECK WHETHER QUERY EXECUTED OR NOT
            if($res2 == TRUE) {
                //QUERY EXECUTED AND ORDER SAVED
                $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                header('location:'.SITEURL);
                ob_end_flush(); // End output buffering and send output
                exit(); // Ensure no further code is executed
            } else {
                //FAILED TO SAVE ORDER
                $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
                header('location:'.SITEURL);
                ob_end_flush(); // End output buffering and send output
                exit(); // Ensure no further code is executed
            }
        }       
        ?>
    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<?php 
include('partials-front/footer.php'); 
ob_end_flush(); // End output buffering and send output
?>

    <style type="text/css">
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

    