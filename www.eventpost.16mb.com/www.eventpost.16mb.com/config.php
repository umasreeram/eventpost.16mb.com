<?php
session_start();
include_once("src/Google_Client.php");
include_once("src/contrib/Google_Oauth2Service.php");
######### edit details ##########
$clientId = '218434434007-u6onnuskas4ff8nlfo7vu9o9u4dr79gg.apps.googleusercontent.com'; //Google CLIENT ID
$clientSecret = '8Pv-UurXQdKm44cdpLf4oL7J'; //Google CLIENT SECRET
$redirectUrl = 'http://www.eventpost.16mb.com';  //return url (url to script)
$homeUrl = 'http://www.eventpost.16mb.com';  //return to home

##################################

$gClient = new Google_Client();
$gClient->setApplicationName('eventpost');
$gClient->setClientId($clientId);
$gClient->setClientSecret($clientSecret);
$gClient->setRedirectUri($redirectUrl);

$google_oauthV2 = new Google_Oauth2Service($gClient);
?>