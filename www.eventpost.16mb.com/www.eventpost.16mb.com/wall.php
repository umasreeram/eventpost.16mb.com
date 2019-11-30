<?php
session_start();
require('login.php');
?>
<html>
<head>

<title>Eventpost-Home</title>
<link rel="stylesheet" type="text/css" href="mystyle.css">

<link rel="stylesheet" type="text/css" href="mypost.css">
<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
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
        $_SESSION['uid']=$userProfile['id'];
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
</head>
<body>
<div class="top_part" >
<label id="username" style="float: right; color:white; margin-right: 20px; margin-top: 40px;"></label>
<H1 class=>Eventpost</h1>

<script> 
var session_name= document.getElementById('username').innerHTML="Welcome <?php echo $_SESSION['username'] ?> !";
</script>

<ul>
  <li><a href="index.php" >Home</a></li>
  <li><a href="wall.php" class="active">Wall</a></li>
</ul>


</div>

<?php 
if(isset($_SESSION['username']))
{
if(isset($_POST['title']) && isset($_POST['info']))
    {
      if(!empty($_POST['title'])&&!empty($_POST['info']))
      {
      $uid=$_SESSION['uid'];
      $username=$_SESSION['username'];
      $title=$_POST['title'];
      $info=$_POST['info'];


	$query=mysqli_query($con,"insert into `posts` values('$uid','$username','$title','$info')");
		if($query)
		{
		echo '<script type="text/javascript">alert("Updated successfully");</script>';
		}
		else
		{
		echo '<script type="text/javascript">alert("Did not update in the database");</script>';
		}




      }
      else
      {

        echo '<script type="text/javascript">alert("Please fill all the details");</script>';
       }

    }

}
else
{
echo '<script type="text/javascript">alert("To publish or view  post kindly Login");</script>';
}
?>



<div id="google_translate_element"></div><script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
}
</script><script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>



	<div class="login">
	<form method="post" action="wall.php" style="width: 50% ; margin-left:0;margin-right:0; float: left;">
	<fieldset>
	<legend>POST</legend>
	<input type="text" name="title" id="title" placeholder="title" required>
	<textarea name="info" placeholder="What's trending?" required></textarea>
	<input type="submit" name="login" value="POST" method="POST">
	</fieldset>
	</form>
	</div>



<div class="wall" style="width:50%;float:left" >

<?php 

if(isset($_SESSION['username']))
{
$query="SELECT * from `posts` ";
  if($query_result = mysqli_query($con,$query))
  {

    if(mysqli_num_rows($query_result)>0){

      while($row=mysqli_fetch_assoc($query_result)){


?>

<div class="placard">

        <div class="placard_desc">
        <h3><?php echo $row['title']; ?></h3>

        <h4>User:<?php echo $row['username']; ?></h4>

        <h5><?php echo $row['info']; ?></h5>

        </div>
       
 </div>

<?php   
$ctr++;          
      }
   //$result->free();
    }
  }
}
?>

</div>


</body>
</html>

	