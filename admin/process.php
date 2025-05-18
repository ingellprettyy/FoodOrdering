PROCESS.PHP

<?php
 if(isset($_POST['btn-send']))
 {
    //echo "Working";
    $Username = $_POST['uname'];
    $Email = $_POST['email'];
    $Subject = $_POST['subject'];
    $Msg = $_POST['msg'];

    if(empty($Username) || empty($Email) || empty($Subject) || empty($Msg))
    {
        header('location:contact.php?error');
    }
    else 
    {
        $to = "ruizangellyca@gmail.com";

        if(mail($to,$Subject,$Msg,$Email))
        {
            header("location:contact.php?success");
        }
    }
 }
 else
 {
    header("location:contact.php");
 }
?>