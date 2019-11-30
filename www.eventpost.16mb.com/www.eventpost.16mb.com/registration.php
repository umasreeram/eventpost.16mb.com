<?php
require('db.php');

// If form submitted, insert values into the database.
if (isset($_REQUEST['username'])){
        // removes backslashes
	$username = $_REQUEST['username'];
        //escapes special characters in a string
	$username = mysqli_real_escape_string($con,$username); 
	$email = stripslashes($_REQUEST['email']);
	$email = mysqli_real_escape_string($con,$email);
	$password = $_REQUEST['password'];
	$enc_password = md5($password);
	$phone = stripslashes($_REQUEST['phone']);
	$phone = mysqli_real_escape_string($con,$phone);
	$address = stripslashes($_REQUEST['address']);
	$address = mysqli_real_escape_string($con,$address);
	
        $query = "INSERT into `users1` (username, password, email, phone, address)
        VALUES ('$username', '$enc_password', '$email', '$phone', '$address')";
        $result = mysqli_query($con,$query);
        if($result){   
        echo "<script>alert('Registered!');</script>";
        }
    }
?>


	