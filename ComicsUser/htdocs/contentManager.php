<?php
/*
 * filename: contentManager.php
 * this code processes the delete images and users request
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
//	@session_start();
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");

	// there are images for this user
$headhtml = <<<EOT
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Content Manager</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta name="description" content="Part of SyntheticReality Comic Builder">
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="facebook application">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/ComicsUser/">
<!--	<link href="https://syntheticreality.net/ComicsUser" rel="canonical"> -->
	<link href="./css/normalize.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link href="./css/main.css" rel="stylesheet"> -->
	<link href="./css/PrivacyPolicy.css" media="screen" rel="stylesheet" type="text/css">
	<link href="./css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="./css/materialdesignicons.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="./css/SiteStyles.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./ComicsUser/favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./ComicsUser/favicon.ico" type="image/x-icon">
<!-- set up our cache choices -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, max-age=0, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
</head>
<body>
<!-- #echo var="QUERY_STRING_UNESCAPED" -->
<div class="pageWrapper" id="container el">
EOT;
echo $headhtml;

// get the facebook logout url
$location = "https://syntheticreality.net/ComicsUser/logout.php";
// check that form was actually submitted
if(!(isset($_POST['deleteALL']))){
	// no, get the no form msg
	require '/home/bitnami/ComicsUser/htdocs/Messages/noFormMsg.php';
	$_SESSION['logoutMsg'] = $logoutMsg;
	// Redirect to the logout URL													
	$seconds = 0;
	header ("Refresh: $seconds; URL=$location");
}

if(isset($_SESSION['oauth_id'])) {
	$UserID = ($_SESSION['oauth_id']);}
include '/home/bitnami/Storybook/htdocs/rrmdir.php';
require("/home/bitnami/includes/Comic.class.php");
	$comic = new Comic();
// Comics folder path
$Comics = '/home/bitnami/Comics/htdocs/';
require '/home/bitnami/ComicsUser/htdocs/ComicsUser.class.php';
	$user = new ComicsUser();

	// $userData = $user->returnUser($UserID);
	$userData = $user->returnUser($UserID);

	$Comicname = $userData['comic_name'];
	echo '<h2>User ID = '.$UserID.'</h2>';
	echo '<h2>Comic Name = '.$Comicname.'</h2>';

	//clean up comic files
	if(file_exists($Comics.$Comicname.'OGIMG.png')) {
		$result = unlink($Comics.$Comicname.'OGIMG.png');
		echo '<h2>Deleted '.$Comicname.'OGIMG.png</h2>';}
	if(file_exists($Comics.$Comicname.'.html')) {
		$result = unlink($Comics.$Comicname.'.html');
		echo '<h2>Deleted '.$Comicname.'.html</h2>';}
	if(file_exists($Comics.$Comicname.'.zip')) {
		$result = unlink($Comics.$Comicname.'.zip');
		echo '<h2>Deleted '.$Comicname.'.zip</h2>';}
	$folder = $Comics.$Comicname;
	rrmdir($folder);
	echo '<h2>Deleted '.$Comicname.' Folder</h2>';

	// clear the Storybook database
	//$imageList = $comic->listComic($Comicname, true);
	$imageList = $comic->deleteComic($Comicname);
	echo '<h2>Deleted '.$Comicname.' from Comic Database</h2>';
	
	// clear the User database
	$userData = $user->deleteUser($UserID);
	echo '<h2>Deleted '.$UserID.' from User Database</h2>';

	// Redirect to the logout URL													
	$seconds = 5;
	header ("Refresh: $seconds; URL=$location");

echo
	'<!-- ++++++++++++++++++++ -->'.
	'<!-- Java script section -->'.
	'<!-- Placed at the end of the document so the page loads faster -->'.
	'<script src="./js/jquery.min.js"></script>'.
	'<script src="./js/context.js"></script>'.
	'<script src="./js/swipe.js"></script>'.
	'<!-- End of the Java script section-->'.
	'<!-- ======================= -->'.
	'<script src="./js/isoblockLogo.js"></script>'.
	'</div></body></html>';

?>