<?php include('partials-front/menu.php'); ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-6 m-auto">
                <div class="card mt-5">
                    <div class="card-title">
                        <h2 class="text-center py-2">CONTACT US</h2>
                        <hr>
                    <?php
                        $Msg = "";
                        if(isset($_GET['error']))
                        {
                            $Msg = "Please Fill in the Blanks";
                            echo '<div class="alert alert-danger">'.$Msg.'</div>';
                        }

                        if(isset($_GET['success']))
                        {
                            $Msg = "Message Sent Successfully!";
                            echo '<div class="alert alert-success">'.$Msg.'</div>';
                        }
                       
                    ?>

                    </div>
                    <div class="card-body">
                        <form method="POST" action="process.php">
                            <input type="text" name="uname" placeholder="Enter Your Username" class="form-control mb-2">
                            <input type="email" name="email" placeholder="Email" class="form-control mb-2">
                            <input type="text" name="subject" placeholder="Subject" class="form-control mb-2">
                            <textarea name="msg" class="form-control mb-2" placeholder="Write Your Message"></textarea>
                            <button class="btn btn-success" name="btn-send">SUBMIT</button>
                        </form>
                    </div>

                </div>

            </div> 

        </div>
    </div>
</body>
</html>

<style type="text/css">
    .container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.card {
  background-color: #f5f5f5;
  border-radius: 5px;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

.card-title {
  text-align: center;
  padding-bottom: 10px;
}

.card-body {
  padding: 10px;
}

.form-control {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  margin-bottom: 10px;
}

textarea.form-control {
  height: 150px;
}

.btn {
  background-color: #4caf50;
  color: #fff;
  font-weight: bold;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.btn:hover {
  background-color: red;
}

.btn-success {
  background-color: #28a745;
  color: #fff;
  border: none;
}

.btn-success:hover {
  background-color: #218838;

}

.alert {
    font-family: Cambria;
    text-align: left;
    padding: 8px 10px;
    color: red;
    background-color: peachpuff;
}
</style>