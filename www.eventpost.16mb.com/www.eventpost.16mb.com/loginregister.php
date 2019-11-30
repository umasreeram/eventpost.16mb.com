<?php
require('registration.php');
session_start();
?>
<?php
include_once("config.php");
include_once("includes/functions.php");

//print_r($_GET);die;

if(isset($_REQUEST['code'])){
	$gClient->authenticate();
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
	$gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken()) {
	$userProfile = $google_oauthV2->userinfo->get();
	//DB Insert
	$gUser = new Users();
	$gUser->checkUser('google',$userProfile['id'],$userProfile['given_name'],$userProfile['family_name'],$userProfile['email'],$userProfile['gender'],$userProfile['locale'],$userProfile['link'],$userProfile['picture']);
	$_SESSION['google_data'] = $userProfile; // Storing Google User Data in Session
	header("location: account.php");
	$_SESSION['token'] = $gClient->getAccessToken();
} else {
	$authUrl = $gClient->createAuthUrl();
}

if(isset($authUrl)) {
	echo '<a href="'.$authUrl.'"><img src="images/glogin.png" alt=""/></a>';
} else {
	echo '<a href="logout.php?logout">Logout</a>';
}

?>
<html>
<head>
<title>Eventpost-Login/Register</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link rel="stylesheet" type="text/css" href="loginregister.css">
<script src="https://apis.google.com/js/platform.js" async defer></script>
<meta name="google-signin-client_id" content="218434434007-u6onnuskas4ff8nlfo7vu9o9u4dr79gg.apps.googleusercontent.com">

</head>
<body>
<div class="top_part" >
<H1 class=>Eventpost</h1>
</div>

<div class="g-signin2" data-onsuccess="onSignIn"></div>

        <div class="login_register">
	<div class="register">
	<form method="post" style="width: 60% ; margin: auto; float: center;">
	<fieldset>
	<legend >Register</legend>
	<input type="text" name="username" id="username" placeholder="name" required>
	<input type="email" name="email" id="email" placeholder="email" required>
	<input type="password" name="password" placeholder="password" required>
        <textarea name="address" placeholder="address" required></textarea>
	<input type="text" name="phone" placeholder="phone number" required>
	<input type="submit" name="register" value="register" onclick="validate()">
	</fieldset>
	</form>
	</div>



	<div class="login">
	<form method="post" action="login.php" style="width: 60% ; margin: auto; float: center;">
	<fieldset>
	<legend>Login</legend>
        
	<input type="text" name="username" placeholder="name" required>
	
	<input type="password" name="password" placeholder="password" required>
	<input type="submit" name="login" value="login" >
	</fieldset>
	</form>
        
	</div>
        </div>

<script>
function validate()
{

var email= document.personal_info.email.value;

var check_name=/^[a-zA-Z][a-zA-Z ]+[a-zA-Z]*$/
var check_num=/^[0-9]{10}$/
var check_email=/^[a-zA-Z][a-zA-Z\d]+[._]?[a-zA-Z\d]*@[a-zA-Z]+(.[a-zA-Z]+){1,2}$/


if(check_email.test(email))
{
send_registration_email();
}
else 
{
alert("invalid email address");
}

}


function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
  window.location.href='http://www.eventpost.16mb.com';
}


</script> 


<a href="#" onclick="signOut();">Sign out</a>
<script>
  function signOut() {
    var auth2 = gapi.auth2.getAuthInstance();
    auth2.signOut().then(function () {
      console.log('User signed out.');
    });
  }

</script>

</body>
</html>
		