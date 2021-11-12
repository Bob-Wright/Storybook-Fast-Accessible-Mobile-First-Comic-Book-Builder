<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// -----------------------
// Start session
//require_once '../session2DB/Zebra.php';
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");
include './ZipListOfFilesOrFolders.php';
include './rrmdir.php';
require("/home/bitnami/includes/Comic.class.php");
	$Comic = new Comic();
// Comics folder path
$Comics = '/home/bitnami/Comics/htdocs/';
require("/home/bitnami/ComicsUser/htdocs/ComicsUser.class.php");
//require("/home/bitnami/includes/ComicImages.class.php");

$head1 = <<< EOT1
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Storybook Creator</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Comics by Bob Wright">
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="comics,art,drawing,sketching,watercolor,ink,pencils,artist,graphics,poetry,illustration">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/Storybook/">
	<link href="https://syntheticreality.net" rel="canonical">
    <!-- Bootstrap core CSS -->
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="./css/mdb.min.css">
	<link rel="stylesheet" href="./css/LiteThemes.css">
	<link href="./css/ComicCreator.css" rel="stylesheet" type="text/css">
	<link href="./css/ComicBuilder.css" rel="stylesheet" type="text/css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="../favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
<style>
input[type=text]:focus {
  background-color: GreenYellow;
}
input[type=submit]:focus {
  background-color: GreenYellow;
}
input[type=checkbox]:focus {
  background-color: GreenYellow;
}
input[type=file]:focus {
  background-color: GreenYellow;
}
textarea:focus {
  background-color: GreenYellow;
}
a:focus {
  background-color: GreenYellow;
}
</style>
</head>
<!-- End of the HTML head section-->
<!-- =========================== -->

<!-- Build out the page -->
<!-- +++++++++++++++++++++++ -->
<body class="container-fluid main-container d-flex flex-column align-items-top #929fba mdb-color lighten-3">
<!--#include file="./includes/browserupgrade.ssi" -->
<script>
// use <img onload="countdown()" src="./images/1x1pixel.png">
// and <h2>There are <span id="timeLeft"></span> seconds remaining.</h2>

// simple on timeout change page
//function timeoutDelay() {
//	setTimeout(loadPage, 16*1000);
//}
//function loadPage() {
//	alert("reached timeoutDelay");
	//window.location.replace("https://syntheticreality.net/Comics/Comics.php");
//};

// timeout with countdown timer
var timecount = 16;
function countdown() {
	timecount = timecount - 1;
	if (timecount === 0) { loadPage();}
	timecount = checkTime(timecount);
	document.getElementById('timeLeft').innerHTML = timecount;
	setTimeout(countdown, 1000);
}
function checkTime(timecount) {
	if (timecount < 10) {timecount = "0" + timecount};  // pad numbers < 10*
	  return timecount;
}
function loadPage() {
	//alert("reached timeoutDelay");
	//window.location = self.location.href;  //Reloads current page for test
	window.location.replace("https://syntheticreality.net/Storybook/closeComicBuilder.php");
	//window.location.replace("https://syntheticreality.net/ComicBuilder.php");
}
function idleTimer() {
    window.onmousemove = resetTimer; // catch mouse
    //window.onmousedown = resetTimer;
    window.onclick = resetTimer;
    window.onscroll = resetTimer; // scrolling
    window.onkeypress = resetTimer;  // keyboard
function resetTimer() {
	clearTimeout();
	timecount = 16;
	console.info("Timer Reset");
}
}
idleTimer();
</script>
<main class="pageWrapper row flex-row row-no-gutters justify-content-center" id="container">
<div class="col-sm-12 px-sm-0" style="opacity: 0;"><br></div>
<header><center><img id="Logo" src = "./images/IsoBlockLOGO.gif" alt="rotating IsoBlock sphere" width="20%" height="auto"></center>
<h2 class="sr-only">This is the entry page for the Storybook comic book creator.</h2>
</header>
<div class="col-sm-12 px-sm-0" style="opacity: 0;"><br></div>

<!-- ++++++++++++++++++++ -->
<!--  build comic pages -->
<!-- ++++++++++++++++++++ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- announce who we are -->
<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox">
<h1 style="color:blue;">Storybook Comic Book Creator</h1>
</section>
EOT2;
echo $head2;

//echo 'ID = '.session_id();
// if(isset($_COOKIE['Storybook'])) {
	//echo '<h2>'. ($_COOKIE['Storybook']) .'</h2><br>';}

// see if we are hosting the web Comic
$host = false;
if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {$host = true;}
	if((!(isset($_SESSION['Comicsaved']))) || ((isset($_SESSION['Comicsaved'])) && ($_SESSION['Comicsaved'] == 0))) {
		if($host == true) {
			echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 redBox"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">This page creates and hosts a Comic web page using the content that you supplied. It also makes a ZIP archive of the Comic for you to optionally download.</h2></section>';
		} else {
			echo
				'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 redBox"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">This page creates a ZIP archive download for an Comic webpage using the information that you supplied.</h2><hr style="width: 60vw;height: .3vw;background-color: blue;"><p style="color: #a00020;background: #ffff00;padding: 1vw;">After the Comic archive is generated and prepared for downloading it will be deleted. There is no storage on this site for the generated web Comic archives. The only way to preserve your web Comic is to download it.</p></section>';
		}
	}

//$timeout = ini_get('max_execution_time');
//echo '<p>Execution Timeout in seconds: '.$timeout.'</p>';

// check display session array
$Comicname = '';
if((isset($_SESSION['Comicsaved'])) && ($_SESSION['Comicsaved'] === 0)) {
	if((isset($_SESSION['Comicname'])) && ($_SESSION['Comicname'] != '')) {
		$Comicname = $_SESSION['Comicname'];
		echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
			'<h3>Comic Data from SESSION</h3>'.
			'<div id="configValues">';
			include '/home/bitnami/Storybook/htdocs/getConfigValues.php';
			echo
			'</section>';
	} else {
		echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
			'<h3>No Comic Data from SESSION</h3>'.
			'</section>';
	}
} else {
	if((isset($_SESSION['Comicname'])) && ($_SESSION['Comicname'] != '')) {
		$Comicname = $_SESSION['Comicname'];}
}

// see if options are enabled and we have a query string
$ComicFoldername = '';
$skippyLives = false;
if($host == true) {
	$saveC = true;
	} else {
	$saveC = false;}
$saveDB = 0;
$useC = false;
if((getenv('QUERY_STRING') != '') && (file_exists("/home/bitnami/includes/options.txt"))) {
	// parse query
	$qstring = getenv('QUERY_STRING');
	// echo '<p>'.$qstring.'</p>';
	parse_str($qstring, $pstrings);
	//echo '<p>'; echo var_dump($pstrings); echo '</p>';
	// see if valid URL query string keys exist
	if(array_key_exists('skippy', $pstrings)) {
		$skippyLives = true; }
	if((array_key_exists('saveC', $pstrings)) || ($host === true)) {
		$saveC = true; }
	if(array_key_exists('saveDB', $pstrings)) {
		$saveDB = 1; }
	if(array_key_exists('useC', $pstrings)) {
		$useC = true; }

	// retrieve Configuration value selections from a file?
	if(array_key_exists('Comic', $pstrings)) {
		$ComicFoldername = $pstrings['Comic'];
		if(file_exists($Comics.$ComicFoldername.'/'.$ComicFoldername.'.php')) {
			include $Comics.$ComicFoldername.'/'.$ComicFoldername.'.php';
			$_SESSION['ComicFoldername'] = $ComicFoldername;
			echo
				'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
				'<h3>Comic Data from the Saved Configuration File</h3>'.
				'<div id="configValues">';
				include '/home/bitnami/Storybook/htdocs/getConfigValues.php';
			echo
				'</div>'.
				'</section>';
		} else {
			echo
				'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 msgBox">'.
				'<h3>No Saved Configuration File '.$Comics.$ComicFoldername.'/'.$ComicFoldername.'.php found</h3>'.
				'</section>';
			$ComicFoldername = '';
			$_SESSION['ComicFoldername'] = '';
		}
	}
}

if(($Comicname == '') && ($ComicFoldername == '')) {
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #ff8800 warning-color-dark lighten-4 px-sm-0 redBox">'.
	'<h2>No Comic specified!&emsp;No HTML File was written.</h2><br>'.
	'<p>This operation requires a specified comic -<br></p>'.
	'<p>Returning to the Comics gallery page.<br></p></section>';
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 orngBox"  style="padding-bottom: 0;" id="ComicFooter">'.
	'<p>&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">'.
	'<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">'.
	'<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73 c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63 0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30 -10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177 c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42 13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37 -7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0 -5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88 -51z"/>'.
	'</g></svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
	echo date ("F d Y H:i:s.", getlastmod()).'</p>'.
	'</footer></main>';
	echo
	'<script>setTimeout(function(){window.location.replace("https://syntheticreality.net/Storybook/closeComicBuilder.php");}, 9000);</script></body></html>';
	die();
}

// check to see if we are to use existing content or make a new HTML file
if($useC == false) {
if(!(isset($_SESSION['Comicsaved']))) {$_SESSION['Comicsaved'] = 0;}
if($_SESSION['Comicsaved'] == 0) {
	if(($ComicFoldername != '') && (file_exists($Comics.$ComicFoldername.'/'.$ComicFoldername.'.php'))) {
		echo
		'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 redBox">'.
		'<h2>Storybook will use the Saved Configuration values</h2>';
		$Comicname = $ComicFoldername;
	} else {
		echo
		'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 h2x-sm-0 redBox">'.
		'<h2>Storybook will use the SESSION Configuration values</h2>';
	}
	echo
	// Comic.php actually generates and saves the web page
	'<form id="saveComic" action="./makeComic.php" method="post">'.
	'<label>Create the Comic:<br><input type="text" id="Comicname" name="Comicname" size="64" value="'.$Comicname.'" hidden tabindex="-1">'.
	//'<input type="submit" hidden>'.
	'<input type="submit" value=" Click to create the Comic! " tabindex="1"></label>'.
	'</form>'.
	'</section><br>';
	//echo '<script>document.getElementById("saveComic").submit();</script>';
	// set the Comicsaved flag in Comic
	// $_SESSION['Comicsaved'] = 1;
} else {
	// be sure Storybook created the web page
	if(file_exists($Comics.$Comicname.'.html')) {
		//credit the post
		//facebook user?
		if(isset($_SESSION['oauth_id']) && ($_SESSION['oauth_id'] != ''))  {
			$UserID = ($_SESSION['oauth_id']);
			// Initialize User class
			$user = new ComicsUser();
			//echo '<p>SESSION UserData<br>'; print_r($UserData); echo'</p>';
			//credit the post
			$userComic = $user->updateComic($UserID, $Comicname);
			$userPosts = $user->updatePosts($UserID, 1);
			$userData = $user->returnUser($UserID);
			$_SESSION['userData'] = $userData;
		}
		// email user login?
		if(isset($_SESSION['email_id']) && ($_SESSION['email_id'] != ''))  {
			$email_id = $_SESSION['email_id'];
			include("/home/bitnami/Storybook/htdocs/config/dbConnect.php");
			$sqlQuery = mysqli_query($connection, "SELECT * FROM users WHERE email = '$email_id' ");
			$countRow = mysqli_num_rows($sqlQuery);

			if($countRow == 1){
				while($rowData = mysqli_fetch_array($sqlQuery)){
					$update = mysqli_query($connection, "UPDATE users SET posts = posts + 1 WHERE email = '$email_id' ");
					if($update){
					   $_SESSION['postcount'] = '<div class="alert alert-success">
							  User posts count changed
							</div>
					   ';
					}
				}
			} else {
			   $_SESSION['passwd_verified'] = '<div class="alert alert-success">
				  Verification error
				</div>
			   ';
			}
		}
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 msgBox"><h2 style="color: #6600d0;background: #ffff00;padding: 1vw;">The&nbsp;<span id="Comicname">'.$Comicname.'</span>&nbsp;Web Comic Files were created using the information that you supplied along with the ';
		if((isset($_SESSION['ComicFoldername'])) && ($_SESSION['ComicFoldername'] != '')) {
			echo
			'Saved Configuration values</h2>';
		} else {
			echo
			'SESSION Configuration values</h2>';
		}
		if(isset($_SESSION['oauth_id']) && ($_SESSION['oauth_id'] != ''))  {
			echo //note tabindex value
			'<h2 class="#b0bec5 blue-grey lighten-3" style="color:indigo;padding: 1vw;">You may Share your Comic to Facebook.</h2>'.
			'<form id="shareForm" name="shareForm"action="../ComicsUser/Share.php" method="post">'.
			'<label>Share the comic on Facebook:<br><input class="checkbox" type="checkbox" id="shareCheckbox" name="shareCheckbox" value="1" checked hidden tabindex="-1">'.
			'<input type="submit" value="&emsp; Share your Comic on Facebook.&emsp;" tabindex="3"></label></form>';
		}
		if($skippyLives == true) {
			echo
			'<img onload="countdown()" src="./images/1x1pixel.png" alt="dummy image for timer">'.
			'<br>';
			if($host == true) {
				echo
				'<div id="timeoutMsg"><h3>You will be redirected to your newly created Comic page in <span id="timeLeft"></span> seconds.</h3></div>';
			} else {
				echo
				'<div id="timeoutMsg"><h3>You will be returned to the Storybook Comics home page in <span id="timeLeft"></span> seconds.</h3>';
			}
			//echo
			 //<hr class="new4">';
		}
	echo
		'</section>';
	}
}
}

if(($useC === true) && !(file_exists($Comics.$Comicname.'.html'))) {
	echo
	'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #ff8800 warning-color-dark lighten-3 px-sm-0 redBox">'.
	'<h2>No HTML file is present!</h2><br>';
	echo
	'<p>The use current option ($useC) needs a current HTML file!<br></p>'.
	'<p>Returning to the Comics gallery page.<br></p></section>';
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 orngBox" id="ComicFooter">'.
	'<p>&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">'.
	'<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">'.
	'<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73 c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63 0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30 -10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177 c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42 13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37 -7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0 -5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88 -51z"/>'.
	'</g></svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
	echo date ("F d Y H:i:s.", getlastmod()).'</p>'.
	'</footer></main>';
	echo
	'<script>setTimeout(function(){window.location.replace("https://syntheticreality.net/Storybook/closeComicBuilder.php");}, 9000);</script></body></html>';
	die();
}

// if no skippy option present create the ZIP
if((isset($_SESSION['Comicsaved'])) && ($_SESSION['Comicsaved'] == 1)) {
if(($skippyLives == false) && (file_exists($Comics.$Comicname.'.html'))) {
	$ziplist = $Comics.$Comicname.', '. $Comics.'Fonts, '. $Comics.$Comicname.'.html, '. $Comics.'favicon.ico ,'. $Comics.'Robots.txt, '. $Comics.'js, '. $Comics.'css';
	if(file_exists($Comics.$Comicname.'OGIMG.webp')) {
		$ziplist .= ', '. $Comics.$Comicname.'OGIMG.webp';
	}
	if(file_exists($Comics.$Comicname.'OGIMG.jpg')) {
		$ziplist .= ', '. $Comics.$Comicname.'OGIMG.jpg';
	}
	if(file_exists($Comics.$Comicname.'.card')) {
		$ziplist .= ', '. $Comics.$Comicname.'.card';
	}
	if(file_exists($Comics.'coversImg/'.$Comicname.'CARD.jpg')) {
		$ziplist .= ', '. $Comics.'coversImg/'.$Comicname.'CARD.jpg';
	}
	if(file_exists($Comics.'coversImg/'.$Comicname.'CARD.gif')) {
		$ziplist .= ', '. $Comics.'coversImg/'.$Comicname.'CARD.gif';
	}
	if(file_exists($Comics.'coversImg/'.$Comicname.'CARD.webp')) {
		$ziplist .= ', '. $Comics.'coversImg/'.$Comicname.'CARD.webp';
	}
	//echo 'The ZIP contents will be<br>'.$ziplist.'<br>';
	if(file_exists($Comics.$Comicname.'.zip')) { //make a new zip file
		$result = unlink($Comics.$Comicname.'.zip');}
	Zip($ziplist, $Comics.$Comicname.'.zip', true);

	//clean up Comic files?
	if($saveC === false) {
		if(file_exists($Comics.$Comicname.'OGIMG.webp')) {
			$result = unlink($Comics.$Comicname.'OGIMG.webp');}
		if(file_exists($Comics.$Comicname.'OGIMG.jpg')) {
			$result = unlink($Comics.$Comicname.'OGIMG.jpg');}
		if(file_exists($Comics.$Comicname.'.html')) {
			$result = unlink($Comics.$Comicname.'.html');}
		if(file_exists($Comics.$Comicname.'.card')) {
			$result = unlink($Comics.$Comicname.'.card');}
		if(file_exists($Comics.'coversImg/'.$Comicname.'CARD.jpg')) {
			$result = unlink($Comics.'coversImg/'.$Comicname.'CARD.jpg');}
		if(file_exists($Comics.'coversImg/'.$Comicname.'CARD.gif')) {
			$result = unlink($Comics.'coversImg/'.$Comicname.'CARD.gif');}
		if(file_exists($Comics.'coversImg/'.$Comicname.'CARD.webp')) {
			$result = unlink($Comics.'coversImg/'.$Comicname.'CARD.webp');}
		$folder = $Comics.$Comicname;
		rrmdir($folder);
	}

	if ($saveDB == 0) {
		require("/home/bitnami/includes/ComicImages.class.php");
			$comic = new ComicImages();
		// clean the temporary Storybook database
		//$imageList = $comic->listComicImages($Comicname);
		$imageList = $comic->deleteComicImages($Comicname);
	}

	if(file_exists($Comics.$Comicname.'.zip')) {
		// allow user time limit download Comic archive
		echo
		'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 infoBox">'.
		'<form name="downloadZip" id="downloadZip" action="downloadZip.php" method="post" enctype="text">'.
		'<h2 class="#b0bec5 blue-grey lighten-3">The&nbsp;<span id="Comicname">'.$Comicname.'</span>&nbsp;Web Comic Files were saved as a ZIP archive.</h2>'.
		'<img onload="countdown()" src="./images/1x1pixel.png">';
		// adjust the tabindex according to FB share option present or not
		if(isset($_SESSION['oauth_id']) && ($_SESSION['oauth_id'] != ''))  {$tdex = 4;} else {$tdex = 3;}
		if($host == true) {
			echo
			'<div id="timeoutMsg"><h3>You will be redirected to your newly created Comic page in <span id="timeLeft"></span> seconds and your ZIP archive will be deleted.<br>Please download your <span id="Comicname">'.$Comicname.' ZIP</span> archive now!</h3></div>'.
			'<label>Download the '.$Comicname.' Archive.<br><input type="text" name="Comicname" id="Comicname" size="64" value="'.$Comicname.'" hidden tabindex="-1">'.
			'<input style="width: 85vw;" type="submit" value="&emsp;Download the '.$Comicname.' Archive.&emsp;" id="Apply" tabindex="' . $tdex . '"></label>'.
			'</form></section>';

		} else {
			echo
			'<div id="timeoutMsg"><h3>You will return to the Comic Builder home page in <span id="timeLeft"></span> seconds and your ZIP archive will be deleted.<br>Please download your <span id="Comicname">'.$Comicname.' ZIP</span> archive now!</h3></div>'.
			'<label>Download the '.$Comicname.' Archive.<br><input type="text" name="Comicname" id="Comicname" size="64" value="'.$Comicname.'" hidden tabindex="-1">'.
			'<input style="width: 85vw;" type="submit" value="&emsp;Download the '.$Comicname.' Archive.&emsp;" id="Apply" tabindex="' . $tdex . '"></label>'.
			'</form></section>';
		}
	} else {
		if((isset($_SESSION['Comicsaved'])) && ($_SESSION['Comicsaved'] == 1)) {
			echo
			'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #8bb19b lite-stylish-color-lite-G lighten-4 px-sm-0 redBox">'.
			'<div id="noZipMadeMsg"><h3 style="color: #6600d0;background: #ffff00;margin: 2vw;padding: 1vw;">The&nbsp;<span id="Comicname">'.$Comicname.'</span>&nbsp;Web Comic Files were NOT saved as a ZIP archive.</h3></div></section>';
		}
	}
}
}

	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 orngBox" id="ComicFooter">'.
	'<nav><p><a id="prevpagebutton" href="./getOGImg.php" title="return to the get OG Image page">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">'.
	'<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">'.
	'<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73 c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63 0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30 -10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177 c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42 13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37 -7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0 -5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88 -51z"/>'.
	'</g></svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
	echo date ("F d Y H:i:s.", getlastmod()).'</p></nav>'.
	'</footer>';

?>
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<script src="./js/isoblockLogo.js"></script>
<!-- +++++++++++++++++++++++ -->
<!-- End of the web page -->
</body>
</html>
