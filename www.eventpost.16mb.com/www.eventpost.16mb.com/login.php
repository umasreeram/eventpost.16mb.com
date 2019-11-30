<?php
require('db.php');
session_start();
// If form submitted, insert values into the database.
if (isset($_POST['username'])&&isset($_POST['password'])){
        // removes backslashes
	$username = $_REQUEST['username'];
        //escapes special characters in a string
	$username = mysqli_real_escape_string($con,$username);
	$password = $_REQUEST['password'];
	$check_password= md5($password);
	//Checking is user existing in the database or not
        $query = "SELECT * FROM `users1` WHERE username='$username' AND password='$check_password'";
	$result = mysqli_query($con,$query) or die(mysql_error());
	$rows = mysqli_num_rows($result);
        if($rows==1){
		
	    $_SESSION['username'] = $username;
	  header("Location: index.php");
        }
	else
        {
	echo '<script>alert("Please check username/password.");
window.location= "loginregister.php";
</script>';
	}
}
	
?>