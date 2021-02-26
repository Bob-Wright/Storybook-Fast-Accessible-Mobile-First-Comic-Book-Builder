<?php
/* Share.php
 * this code processes the Facebook Share dialog
*/

// disable error reporting for production
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// check that form was actually submitted
if(!($_SERVER["REQUEST_METHOD"] == "POST")) {
	$location = './closeSession.php';
	header ("Refresh: 0; URL=$location");
}
// Start session
//	@session_start();
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");
//require "/home/bitnami/ComicsUser/htdocs/Login.php";

$head1 = <<<EOT
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Share Page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Storybook">
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="facebook application">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/ComicsUser/">
<!--	<link href="https://syntheticreality.net" rel="canonical"> -->
	<link href="./css/normalize.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link href="./CSS/main.css" rel="stylesheet"> -->
	<link href="./css/PrivacyPolicy.css" media="screen" rel="stylesheet" type="text/css">
	<link href="./css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css">
	<link href="./css/materialdesignicons.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="./css/SiteStyles.css" media="screen" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon">
<!-- set up our cache choices -->
<meta http-equiv="Cache-Control" content="no-cache, no-store, max-age=0, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="Mon, 26 Jul 1997 05:00:00 GMT">
</head>
<style>
#prevpagebutton {
	font-family: 'Roboto Slab', serif; 
	font-weight: bold;
	font-size: 2.4vw;
}
#nextpagebutton {
	font-family: 'Roboto Slab', serif; 
	font-weight: bold;
	font-size: 2.4vw;
}
#galleryFooter{
	text-align: center;
	font-family: 'Roboto Slab', serif; 
	font-weight: bold;
	font-size: 1.8vw;
	margin: auto;
	width: 100%;
	border: .2vw solid red;
	background: #f0f0f0;
}
</style>
<body style="cursor: default;">
<!--------------------------------------->
<!-- Include the facebook javascript SDK -->
<script>
window.fbAsyncInit = function() {
	FB.init({
		appId      : '1297101973789783',
		xfbml      : true,
		version    : 'v8.0'
	});
	FB.AppEvents.logPageView();
};
(function(d, s, id){
	var js, fjs = d.getElementsByTagName(s)[0];
	if (d.getElementById(id)) {return;}
	js = d.createElement(s); js.id = id;
	js.src = "//connect.facebook.net/en_US/sdk.js";
	fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
</script>
<div class="pageWrapper" id="container el">
EOT2;
echo $head2;

$logolist = file_get_contents("https://syntheticreality.net/Images/IsoBlock.LL");
if((substr($logolist, -1)) == ',') {    // strip trailing comma
	$logolist = substr($logolist, 0, -1);
}
$logofiles = explode(",", $logolist);
$logocount = count($logofiles);
$js_array = json_encode($logofiles);

echo
'<!-- ++++++++++++++++++++++ -->'.
'<!-- Logo and name -->'.
'<header class= "myHeader" id="myHeader">'.
'<script>'.
'var logocount = '.$logocount.';'.
'var logoindex = logocount - 1;'.
'function toggleLogo() {'.
'var logo = '.$js_array.';'.
'var logofile = logo[logoindex];'.
'document.getElementById("Logo").src = "https://syntheticreality.net/Images/" + logofile;'.
'if(logoindex == 0) {'.
'logoindex = logocount-1;'.
'}else{'.
'logoindex = logoindex - 1;'.
'}}'.
'</script>'.
'<img class="Logo" id="Logo" src = "https://syntheticreality.net/Images/'.$logofiles[1].'" alt="Logo"><button class="toggleLogo" onclick="toggleLogo()"></button><div class="sitename" id="sitename" >IsoBlock</div>'.
'<span class="siteSubtitle">Synthetic Reality Division</span>'.
'</header>'.
'<button class="toggleMenu" id="toggleMenu"><div><a href="https://syntheticreality.net/Comics/Comics.html"><strong><span class="mdi mdi-home"></span></strong></a></div></button>';

$body1 = <<< BODY1
<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- the message -->
<div class="article-wrapper">
<article class="textcontent">
<h1 style="text-align:center;margin-top:1vw;">Share Page</h1>
<h2 style="text-align:center;">The Storybook Comic Book Builder completed successfully. This page will let you share the Comic to Facebook.</h2>

<p id="shareSuccess" style="display: none;">The Facebook Share dialog completed successfully.<br>You may share the Comic again or you may logout.</p>
<p id="shareFailedNotice" style="display: none;">There was an error Sharing the image to Facebook.<br>You may try again or you may logout.</p>

<!-- Create a custom share button with a unique id -->
<img id="shareButton" src="https://syntheticreality.net/ComicsUser/Images/facebook-share-comic-button.png">

<!-- logout of Comic share button -->
<div id="logoutButton"><a id="logoutButtonURL" href="https://syntheticreality.net/Storybook/closeSession.php"><img src="https://syntheticreality.net/ComicsUser/Images/facebook-logout-button.png"></a></div>
BODY1;
echo $body1;

//if(isset($_SESSION['userData'])) {
	//echo '<p>SESSION userData<br>'; print_r($_SESSION['userData']); echo'</p>';
// create a dummy <div> element to send data to javascript
echo '<div id="ComicNameValue" style="opacity: 0;">'.$_SESSION['userData']['gallery_name'].'</div>';
// Logout of ComicsUser AND Facebook button
$logoutURL = $_SESSION['logoutURL'];

	echo
	'</article>'.
	'</div>'.
	'<footer id="myFooter">'.
	'<div id="galleryFooter"><a id="prevpagebutton" href="../Comics/Comics.html">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
	echo date ("F d Y H:i:s.", getlastmod()).'</div>'.
	'</footer>';

$body2 = <<< BODY2
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<script src="./js/jquery.min.js"></script>
<script src="./js/context.js"></script>
<script src="./js/logoSwap.js"></script>
<script src="./js/swipe.js"></script>
<script src="./js/isoblockLogo.js"></script>

//<!-- Call Share Dialog on the custom button using button id -->
<script>
$(document).ready( function() {
	document.getElementById("shareButton").onclick = function() {
	var keyValue = document.getElementById("ComicNameValue").innerHTML;
	console.info("keyValue "+keyValue);
	FB.ui(
	{
	method: 'share',
	display: 'popup',
	href: 'https://syntheticreality.net/Comics/'+keyValue+'.html'
	}, 
	function(response) {
	if (response && !response.error_message) {
	document.getElementById("shareFailedNotice").style.display = "none";
	document.getElementById("shareSuccess").style.display = "block";
	document.getElementById("logoutButtonURL").href = "https://syntheticreality.net/ComicsUser/closeSession.php";
	var logoutButtonURL = document.getElementById("logoutButtonURL").href;
	console.info("logoutButtonURL "+logoutButtonURL);
	} else {
	document.getElementById("shareSuccess").style.display = "none";
	dcument.getElementById("shareFailedNotice").style.display = "block";
	}
	});
	}
})
</script>
<!-- +++++++++++++++++++++++ -->
<!-- End of the web page -->
</div>
</body>
</html>';
BODY2;
echo $body2;
?>