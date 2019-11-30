<?php
session_start();
require('login.php');
?>
<html>
<head>

<title>Eventpost-Home</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>


<script src="https://apis.google.com/js/platform.js" async defer></script>
</head>
<body>
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
        $_SESSION['username']=$userProfile['given_name'];

	$_SESSION['token'] = $gClient->getAccessToken();
} else {
	$authUrl = $gClient->createAuthUrl();
}

if(isset($authUrl)) {
	echo '<a href="'.$authUrl.'"><img src="images/glogin.png" style="width:20%;height:10%;" alt=""/></a>';
} else {
	echo '<a href="logout.php?logout">Logout</a>';
}


?>

<div class="top_part" >
<label id="username" style="float: right; color:white; margin-right: 20px; margin-top: 40px;"></label>

<H1 class=>Eventpost</h1>
<script>
// auth2 is initialized with gapi.auth2.init() and a user is signed in.

if (auth2.isSignedIn.get()) {
  var profile = auth2.currentUser.get().getBasicProfile();
  console.log('ID: ' + profile.getId());
  console.log('Full Name: ' + profile.getName());
  console.log('Given Name: ' + profile.getGivenName());
  console.log('Family Name: ' + profile.getFamilyName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
}
</script>



<script> 
var session_name= document.getElementById('username').innerHTML="Welcome <?php echo $_SESSION['username'] ?> !";
</script>



<ul>
  <li><a href="index.php" class="active">Home</a></li>
  <li><a href="wall.php">Wall</a></li>
</ul>

</div>
<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

</div>
<div class="cuisine">Checkout cool events happening around you..</div>
<div style="width:50%;margin-left:25%;margin-right:25%">

<div class="cuisine">Explore the city</div>
<img src="images/party.jpg" style="width:100%;height:50%;"/>

<div class="cuisine">Find best shopping deals</div>
<img src="images/shopping.jpg" style="width:100%;height:50%;"/>


<div class="cuisine">Unwind at your favourite cafes</div>
<img src="images/cafes.jpg" style="width:100%;height:50%;"/>

<div class="cuisine">Enjoy art,music and more..</div>
<img src="images/theatre.jpg" style="width:100%;height:50%;"/>
</div>


<div class="cuisine">Want to spread the word?Login and POST about it :)!</div>



</body>
</html>

