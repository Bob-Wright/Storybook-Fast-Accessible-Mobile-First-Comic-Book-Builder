<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
//	@session_start();
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");

$_SESSION['Comicsaved'] = 0;
$usedSavedConfig = 0;
$_SESSION['usedSavedConfig'] = $usedSavedConfig;

/*
include("/home/bitnami/includes/Comic.class.php");
    $Comic = new Comic();
include './rrmdir.php';

// delete records and Comics older than this time in hours
$age = 12;

// get an array of all the aged records
$agedList = $Comic->listAgedComic($age);
//echo '<br>List of all records older than the time value in hours<br>';
//echo '<pre>';print_r($agedList);echo '</pre>';

// go through the list
$OldComicname = '';
for ($i = 0; $i <  count($agedList); $i++) {
	$imageIndex=key($agedList);
	$imageKey=$agedList[$imageIndex];
	if ($imageKey<> ' ') {
		// split an entry
		$agedListEntry = explode(',', $imageKey);
		//echo '<pre>';echo $imageIndex.' ';print_r($agedListEntry);echo '</pre>';
		$Comicname = $agedListEntry[0];
		// see if this record has a different Comicname
		if(!($Comicname === $OldComicname)) {
			// echo '<pre>';echo $imageIndex.' ';print_r($agedListEntry);echo '</pre>';
			// update the Comic name
			$OldComicname = $Comicname;
			// might not need the key
			// $Comickey = $agedListEntry[1];
			// if the Comicname is a folder delete it
			// and clean the ComicBuilder database
			if(is_dir('/home/bitnami/Comics/htdocs/'.$Comicname)) {
				$folder = '/home/bitnami/Comics/htdocs/'.$Comicname;
				rrmdir($folder);
				// echo 'Deleted '.$Comicname.' folder.<br>';
				//$imageList = $Comic->listComic($Comicname, true);
				$imageList = $Comic->deleteComic($Comicname);
				// echo 'Deleted '.$Comicname.' database.<br>';
			}
		}
	}
next($agedList);
}
*/
$head1 = <<< EOT1
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Storybook Comic Builder</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Storybook Comic Book Builder">
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="web page">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/Storybook/">
    <!-- Bootstrap core CSS -->
	<link href="./css/bootstrap.min.css" rel="stylesheet">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="./css/mdb.min.css">
	<link href="./css/ComicCreator.css" rel="stylesheet" type="text/css">
	<link href="./css/ComicBuilder.css" rel="stylesheet" type="text/css">
</head>
</head>
<!-- Build out the page -->
<!-- +++++++++++++++++++++++ -->
<body class="container-fluid main-container d-flex flex-column align-items-top #929fba mdb-color lighten-3">
<!--#include file="./includes/browserupgrade.ssi" -->
<main class="pageWrapper row flex-row row-no-gutters justify-content-center" id="container">
<div class="col-sm-12 px-sm-0" style="opacity: 0;"><br></div>
<header><img id="Logo" src = "./images/IsoBlockLOGO.gif" alt="rotating IsoBlock sphere" width="100%" height="100%">
<h2 class="sr-only">This is the entry page for the Storybook comic book builder.</h2>
</header>
<div class="col-sm-12 px-sm-0" style="opacity: 0;"><br></div>

<!-- ++++++++++++++++++++ -->
<!--  build comic pages -->
<!-- ++++++++++++++++++++ -->
<!-- ~~~~~~~~~~~~~~~~~~~~~~~ -->
<!-- announce who we are -->
<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox">
<h1 style="color:blue;">Storybook Comic Book Builder</h1>
</section>
EOT2;
echo $head2;
//check for comics count limit, notify if so
if((isset($_SESSION['userCountMsg'])) && ($_SESSION['userCountMsg'] != '')) {
	$userCountMsg = $_SESSION['userCountMsg'];
	echo
'<section class="d-flex flex-column align-items-center">'.
	'<hr class="new3">'.
	'<hr class="new4">'.
	$userCountMsg.
	'<p style="color:red;">We are sorry for any inconvenience.</p>'.
	'<hr class="new3">'.
	'<h2 style="color:purple;">Please check back later, and thanks for your patronage and your patience!</h2>'.
	'<hr class="new4">'.
	'<hr class="new3">'.
	'</section>'.
	'<footer id="ComicFooter"><nav><a id="prevpagebutton" href="./closeComicBuilder.php">❮ Previous</a></nav>&emsp;Design and Contents &copy; 2020 by&nbsp;<svg version="1.0" xmlns="http://www.w3.org/2000/svg"
 width="40.000000pt" height="40.000000pt" viewBox="0 0 40.000000 40.000000"
 preserveAspectRatio="xMidYMid meet">
<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)"
fill="#000000" stroke="none">
<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73
c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63
0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30
-10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177
c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42
13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37
-7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0
-5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88
-51z"/>
</g>
</svg>
&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified <!--#echo var="LAST_MODIFIED" --></footer></main>';
} else {
//check if maintenance is being done, notify if so
$offline = false;
	if((file_exists("/home/bitnami/includes/offline.txt")) && (file_exists("/home/bitnami/includes/options.txt")) && (getenv('QUERY_STRING') === '')) {
		$offline = true;
		echo
			'<section class="d-flex flex-column align-items-center">'.
			'<hr class="new3">'.
			'<hr class="new4">'.
			'<h2 style="color:red;">Storybook Comic Book Builder is being updated. We are sorry for any inconvenience.</h2>'.
			'<hr class="new3">'.
			'<h2 style="color:purple;">Please check back a bit later, and thanks for your patronage and your patience!</h2>'.
			'<hr class="new4">'.
			'<hr class="new3">'.
			'</section>'.
			'<footer id="ComicFooter"><nav><a id="prevpagebutton" href="./closeComicBuilder.php">❮ Previous</a></nav>&emsp;Design and Contents &copy; 2020 by&nbsp;<span style="padding-bottom: 1vw;"><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 45.000000" preserveAspectRatio="xMidYMid meet">
	<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)"
	fill="#000000" stroke="none">
	<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73
	c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63
	0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30
	-10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177
	c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42
	13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37
	-7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0
	-5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88
	-51z"/>
	</g>
	</svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified <!--#echo var="LAST_MODIFIED" --></footer></main>';
	} else {

$uploadDir = "/home/bitnami/uploads/";
//$usedSavedConfig = 0;
// check for options parameter setting files
//if buoy then we show a nav/menu bar
$buoy = false;
//if landingpage then we make a landing page for the comic
$landingpage = false;
$_SESSION['landingpage'] = false;
if((file_exists("/home/bitnami/includes/landingpage.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
	$landingpage = true;
	$_SESSION['landingpage'] = true;}
//if host then we are hosting the comic
$host = false;
	if((file_exists("/home/bitnami/includes/host.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$host = true;}
//if storybook then make a card for the storybook gallery - storybook overides landingpage
$storybook = false;
	if((file_exists("/home/bitnami/includes/storybook.txt")) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$storybook = true;
		$landingpage = false;
	}
//some options are invoked by the query string		
if(getenv('QUERY_STRING') != '') {
	// parse query
	$qstring = getenv('QUERY_STRING');
	// echo '<p>'.$qstring.'</p>';
	parse_str($qstring, $pstrings);
	// see if valid URL query string keys AND the magic key file exists
	//if buoy then we show a nav/menu bar
	if((array_key_exists('buoy', $pstrings)) && (file_exists("/home/bitnami/includes/buoy.txt"))) {
		$buoy = true;}
	//if Comic then we load a saved configuration
	if((array_key_exists('Comic', $pstrings)) && (file_exists("/home/bitnami/includes/options.txt"))) {
		$ComicFoldername = $pstrings['Comic'];
		$thisOauthID = '';
		if(isset($_SESSION['oauth_id'])) {
			$thisOauthID = $_SESSION['oauth_id'];
				//echo '<h1>'.$thisOauthID.'</h1><br>';
			$_SESSION['ComicFoldername'] = $ComicFoldername;
			if(file_exists('/home/bitnami/Comics/htdocs/'.$ComicFoldername.'/'.$ComicFoldername.'.php')) {
				//echo '<h1>file exists</h1><br>';
				$configFileContents = (file_get_contents('/home/bitnami/Comics/htdocs/'.$ComicFoldername.'/'.$ComicFoldername.'.php'));
				//echo '<h1>got contents</h1><br>';
				//print_r($configFileContents);
				if( preg_match_all('/('.preg_quote($thisOauthID,'/').')/i', $configFileContents, $matches)){
					//print_r($matches);
					require('/home/bitnami/Comics/htdocs/'.$ComicFoldername.'/'.$ComicFoldername.'.php');
					$_SESSION['usedSavedConfig'] = 1;
				}
			}
		}
	}
}

echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md  #b0bec5 blue-grey lighten-5 px-sm-0 msgBox"><h2 style="color:indigo;">Enter the Comic Book configuration values requested below.</h2><p style="color:purple;padding: 1vw;"><strong>You may click an "Apply" button without entering data to insert the default or example value. You may reenter a value, or you may make changes or corrections to a value. For each item save the changes by clicking the associated "Apply" button. To clear an entry and delete its value enter a single space and click "Apply". Do not include the quotes used to delimit the examples shown.</strong></p></section><br>'.
'<hr class="new4">';
//'<hr class="new3">';

//set comicname as empty if no landing page
$Comicname = '';

/*
+++++++++++++++++++++++++++++++++
*/

//storybook conditionals
if($storybook == true) {
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox"><h3 style="color:purple;">The following entries will be used to populate a gallery card for your comic in the Storybook Comic Book Gallery.</h3></section><div><br></div>';

/*
 * -----------------------
 * Each field has a form action to sanitize and validate content
 *
*/
//$_SESSION["siteurl"] = './';
// site URL calls siteURL.php $host is FALSE
if($host == true) {
// get our host URL
$link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 
                "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . "/Comics/"; 
$siteurl = $link;
$_SESSION["siteurl"] = $siteurl;
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<div class="d-flex col-sm-12 flex-column">This URL will be the hosted comic base address. Its value is set by the application, it is an absolute URL that will become part of the page URL and will be used as the canonical URL in the HTML "head section". It will be used along with the Comic name to create an OG URL for use when the comic is shared on Facebook. You may not change this value.<br>'.
'<form id="siteURL" action="siteURL.php" method="post" enctype="text">'.
'<label>The hosted comic base address (set by Storybook):<br><input type="text" name="siteurl" id="siteurl" size="72" value="'.$siteurl.'"></label>'.
'</form></div></section><br>';
}

// title for the Comic card calls cardTitle.php
if(isset($_SESSION["cardTitle"])){
	$cardTitle =  $_SESSION["cardTitle"];
	} else {$cardTitle = 'The Storybook Web Comic Demo Example';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<div class="d-flex col-sm-12 flex-column">Enter a Comic Title up to 64 characters in length to display on the gallery card. This title will appear below the card image. On the card, title text may wrap to multiple lines. The Title may contain alphabetic and numeric characters and spaces along with commas, underlines, and dashes. Space characters will be stripped from the Title to create a Comic name for the comic book page URL.<br>'.
'<form id="cardTitle" action="cardTitle.php" method="post" enctype="text">'.
'<label>A Comic Title (required):<br><input type="text" name="cardTitle" id="cardTitle" size="64" value="'.$cardTitle.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></div></section><br>';

// page URL for the Comic calls Comicname.php
if(isset($_SESSION["Comicname"])){
	$Comicname =  $_SESSION["Comicname"];
	} else {$Comicname = 'TheStorybookWebComicDemoExample';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<div class="d-flex col-sm-12 flex-column">'.
'This value is an absolute URL that will become the hosted Comic page URL and it will be used as the canonical URL in the HTML "head section". It will also be used to create an OG URL for use when the comic is shared on Facebook. You may not change this value, it is based on the Comic Title entered above.<br>'.
'<form id="Comicname" action="Comicname.php" method="post" enctype="text">'.
'<label>The hosted comic URL (set by Storybook):<br><input disabled type="text" name="siteurl" id="siteurl" size="72" value="'.$siteurl.$Comicname.'.html"></label>'.
'</form></div></section><br>';

// image for the Comic background calls getBkgnd.php
	$pageimage = 'BKGND';
	$_SESSION["pageimage"] = $pageimage;
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="bkgndimage" action="getBkgnd.php" method="post" enctype="text">'.
'This dialog will allow you to select an image to display as the Comic background. This image will appear behind your image content. <br>'.
'<label>The comic Background image (optional):<br><input type="text" name="bkgndimage" id="bkgndimage" size="64" value="'.$pageimage.'" hidden></label>'.
'<br><input type="submit" value="Select an Image">'.
'</form></section><br>';

// image for the Comic card calls getCardImage.php
	$pageimage = 'CARD';
	$_SESSION["pageimage"] = $pageimage;
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="pageimage" action="getCardImage.php" method="post" enctype="text">'.
'This dialog will allow you to select an image to display on the gallery card. This image will appear above the card Title. <br>'.
'<label>The Gallery card image (required):<br><input type="text" name="pageimage" id="pageimage" size="64" value="'.$pageimage.'" hidden></label>'.
'<br><input type="submit" value="Select an Image">'.
'</form></section><br>';

// cardAlt calls cardAlt.php
if(isset($_SESSION["cardAlt"])){
	$cardAlt =  $_SESSION["cardAlt"];
	} else {$cardAlt = 'One of the dragonfly choppers over a hilly background at night, with the comic title superimposed.';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="cardAlt" action="cardAlt.php" method="post" enctype="text">'.
'Enter a concise "alt" (alternate) text description of the gallery card image. In practice most screen readers will cut this short at about 125 characters in length, so if possible this description should be less than 80-100 characters in length. Note that Storybook allows alt text descriptions up to 320 characters in length to describe complex images or animations. Avoid using superfluous terms like "an image" or "a photo of" in the description.<br>'.
'<label>The Gallery Card Image Alt Text (required):<br><textarea name="cardAlt" id="cardAlt" rows="5" cols="64">'.$cardAlt.'</textarea></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';


// subtitle for the Comic calls cardSubtitle.php
if(isset($_SESSION["cardSubtitle"])){
	$cardSubtitle =  $_SESSION["cardSubtitle"];
	} else {$cardSubtitle = 'An optional subtitle may be added here...';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="cardSubtitle" action="cardSubtitle.php" method="post" enctype="text">'.
'Enter an optional Comic <em>card Subtitle</em> up to 64 characters in length to display on the gallery card. This subtitle will appear just below the Comic Title entered above. On the card, subtitle text may wrap to multiple lines.<br>'.
'<label>The Comic Subtitle (optional):<br><input type="text" name="cardSubtitle" id="cardSubtitle" size="64" value="'.$cardSubtitle.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';

// card text calls cardText.php
if(isset($_SESSION["cardText"])){
	$cardText =  $_SESSION["cardText"];
	} else {$cardText = 'A description of the Comic up to 1024 characters in length to display on the gallery card may be inserted here. This description will appear just below the Comic Title and Subtitle entered above and will be formatted to suit the card width. Besides alphabetic and numeric characters the description can include blank lines and the symbols ~!@#$%^&amp;*()_+{}|:"?-=[]\;,./\'.<br><br>Here is some filler text.<br><br>The first consideration for an online experience is the user device.';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="cardText" action="cardText.php" method="post" enctype="text">'.
'Enter a <em>description</em> of the Comic up to 1024 characters in length to display on the gallery card. This description will appear just below the Comic Title and Subtitle entered above. This description can include blank lines and the symbols &emsp;~!@#$%^&amp;*()_+{}|:"?-=[]\;,./\'&emsp;but it may NOT include greater than or less than symbols. To insert a line break or end a line use the "Enter" key. Line breaks will be displayed as <br> when the text is saved.<br>'.
'<label>The Gallery Card Text (required):<br><textarea name="cardText" id="cardText" rows="16" cols="64">'.$cardText.'</textarea></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';

// category for the comic calls Category.php
if(isset($_SESSION["category"])){
	$category =  $_SESSION["category"];
	} else {$category = 'Comic Category';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="Category" action="Category.php" method="post" enctype="text">'.
'Enter a <em>Category</em> for the comic content up to 32 characters in length to display on the gallery card. This Category will appear in the button list below the text description above.<br>'.
'<label>The Comic Category (required):<br><input type="text" name="category" id="category" size="32" value="'.$category.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';

echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<p>Now we will enter a list of content creator names, each up to 32 characters in length, to display on the gallery card. The list of content creator names in the order of their display in the button list is Author, Script, Pencils, Inks, Colors, and Lettering.<br> All of the content creator values are optional, but Storybook suggests entering either a single Author name or some combination of the Script, Pencils, Inks, Colors, and Lettering entries. You can leave a value blank for no entry. These values will appear in the button list below the text description above.</p>';

// author's name calls authorName.php
if(isset($_SESSION["authorname"])){
	$authorname =  $_SESSION["authorname"];
	} else {$authorname = 'I. Aman Author';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox">'.
'<form id="authorName" action="authorName.php" method="post" enctype="text">'.
'Enter a <em>Author</em> for the comic up to 32 characters in length to display on the gallery card. The Author will appear in the button list below the text description above.<br>'.
'<label>The Comic Author (optional):<br><input type="text" name="authorname" id="authorname" size="32" value="'.$authorname.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';

// scripter's name calls scriptName.php
if(isset($_SESSION["scriptname"])){
	$scriptname =  $_SESSION["scriptname"];
	} else {$scriptname = 'I. Ama Script Writer';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox">'.
'<form id="scriptName" action="scriptName.php" method="post" enctype="text">'.
'Enter a <em>Script Writer name</em> for the comic up to 32 characters in length to display on the gallery card. The Script Writer will appear in the button list below the text description above.<br>'.
'<label>The Comic Script Writer (optional):<br><input type="text" name="scriptname" id="scriptname" size="32" value="'.$scriptname.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section>';

// penciler's name calls pencilsName.php
if(isset($_SESSION["pencilsname"])){
	$pencilsname =  $_SESSION["pencilsname"];
	} else {$pencilsname = 'I. Yamagood Pencils Artist';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox">'.
'<form id="pencilsName" action="pencilsName.php" method="post" enctype="text">'.
'Enter a <em>Penciler name</em> for the comic up to 32 characters in length to display on the gallery card. The Pencils Artist will appear in the button list below the text description above.<br>'.
'<label>The Penciler (optional):<br><input type="text" name="pencilsname" id="pencilsname" size="32" value="'.$pencilsname.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section>';

// inker's name calls inksName.php
if(isset($_SESSION["inksname"])){
	$inksname =  $_SESSION["inksname"];
	} else {$inksname = 'I. M. Quitean Inker';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox">'.
'<form id="inksName" action="inksName.php" method="post" enctype="text">'.
'Enter an <em>Inker name</em> for the comic up to 32 characters in length to display on the gallery card. The Inks Artist will appear in the button list below the text description above.<br>'.
'<label>The Inker (optional):<br><input type="text" name="inksname" id="inksname" size="32" value="'.$inksname.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section>';

// colorer's name calls colorsName.php
if(isset($_SESSION["colorsname"])){
	$colorsname =  $_SESSION["colorsname"];
	} else {$colorsname = 'I. Ama Colorist';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox">'.
'<form id="colorsName" action="colorsName.php" method="post" enctype="text">'.
'Enter a <em>Colors Artist name</em> for the comic up to 32 characters in length to display on the gallery card. The Colors Artist will appear in the button list below the text description above.<br>'.
'<label>The Colors Artist (optional):<br><input type="text" name="colorsname" id="colorsname" size="32" value="'.$colorsname.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section>';

// letterer's name calls lettersName.php
if(isset($_SESSION["lettersname"])){
	$lettersname =  $_SESSION["lettersname"];
	} else {$lettersname = 'I. Ama Letterer';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox">'.
'<form id="lettersName" action="lettersName.php" method="post" enctype="text">'.
'Enter a <em>Letterer name</em> for the comic up to 32 characters in length to display on the gallery card. The Lettering Artist will appear in the button list below the text description above.<br>'.
'<label>The Letterer (optional):<br><input type="text" name="lettersname" id="lettersname" size="32" value="'.$lettersname.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section>';

echo
'</section>';
// publisher for the comic calls Publisher.php
if(isset($_SESSION["publisher"])){
	$publisher =  $_SESSION["publisher"];
	} else {$publisher = 'Publisher';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="Publisher" action="Publisher.php" method="post" enctype="text">'.
'Enter a <em>Publisher</em> for the comic up to 32 characters in length to display on the gallery card. The Publisher will appear in the button list below the text description above.<br>'.
'<label>The Comic Publisher (optional):<br><input type="text" name="publisher" id="publisher" size="32" value="'.$publisher.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';

// audience category for the comic calls Audience.php
if(isset($_SESSION["audience"])){
	$audience =  $_SESSION["audience"];
	} else {$audience = 'Intended Audience';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="Audience" action="Audience.php" method="post" enctype="text">'.
'Enter an <em>Audience category</em> for the comic up to 32 characters in length to display on the gallery card. The Audience category will appear in the button list below the text description above.<br>'.
'<label>The Comic intended Audience (required):<br><input type="text" name="audience" id="audience" size="32" value="'.$audience.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';

// artist's or creator's name for author copyright calls artistName.php
if(isset($_SESSION["artistname"])){
	$artistname =  $_SESSION["artistname"];
	} else {$artistname = 'Ima Creator';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="artistName" action="artistName.php" method="post" enctype="text">'.
'Enter an <em>Artist</em> or content creator name up to 32 characters in length to use as the web page HTML copyright notice and author credits and to display as the Comic author for Facebook shares.<br>'.
'<label>The Comic Author for copyright (required):<br><input type="text" name="artistname" id="artistname" size="32" value="'.$artistname.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';

// page Email calls cardEmail.php
if(isset($_SESSION["cardemail"])){
	$cardemail =  $_SESSION["cardemail"];
	} else {$cardemail = 'myemail@froggybottom.com';}
echo
'<section class="d-flex col-sm-11 flex-column align-items-left shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<form id="cardEmail" action="cardEmail.php" method="post" enctype="text">'.
'Enter an <em>Email address</em> to associate with the comic.<br>'.
'<label>A contact email for the Comic (required):<br><input type="text" name="cardemail" id="cardemail" size="64" value="'.$cardemail.'"></label>'.
'<br><input type="submit" value="Apply">'.
'</form></section><br>';
//'<hr class="new3">';

} //end storybook conditionals

/*
 * -----------------------
 * end of configuration selections
 *
*/
echo
'<hr class="new4">'.
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">'.
'<h3 style="color:purple;">Current Configuration Settings</h3>'.
'<div id="configDisplay">'.
'<div id="configValuesBox">'.
/*'<div id="configValuesBkgnd">';
include './getConfigValues.php';
echo
'</div>'.*/
'<div id="configValues">';
include './getConfigValues.php';
echo
'</div>'.
'</div>'.
'</div>'.
'</section>';
$cardcode = <<< EOT8
<hr class="new4">
<section id="Anchor1" class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 infoBox">
<h3 style="color:indigo;">Your comics gallery card will look like this:</h3></section>
</div>
<div class="container album py-5">
<!-- <div class="row flex-row row-no-gutters justify-content-center"> -->
<article id="anchor1" class="col-md-4 d-flex flex-direction:column justify-content-between align-items-center">
<div class="card mb-4 shadow-md #cfd8dc blue-grey lighten-4">
<div class="view overlay">
EOT8;
echo $cardcode;
			if (!(isset($_SESSION['cardImage']))) {
			echo
            '<img class="bd-placeholder-img card-img-top" width="100%" height="auto" src="../Comics/Img/WebComicConcept.jpg" alt="One of the dragonfly choppers over a hilly background at night, with the comic title superimposed.">';
			} else {
			echo
            '<img class="bd-placeholder-img card-img-top" alt="'.$cardAlt.'" width="100%" height="auto" src="../Comics/coversImg/'.$cardImage.'">';
			}
			echo
			'<a class="mask rgba-white-light" title="Open the '.$cardTitle.' Comic" href="./index.php#anchor1" hreflang="en"></a>'.
			'</div>'.
			'<!--Card content-->'.
            '<div class="card-body">'.
			 '<!--Title-->'.
	 '<h1 class="card-title">'.$cardTitle.'</h1><h2 class="card-title">'.$cardSubtitle.'</h2>'.
	 '<!--Text-->'.
     '<p class="card-text text-dark">'.$cardText.'</p>';
	// we use buttons because we may implement some search capability
	// these values for each comic are stored in a database
	 if($category != '') {
	 echo '<button title="Category" type="button" class="btn btn-indigo galleryButton">'.$category.'</button>';}
	 if($authorname != '') {
	 echo '<button title="Author" type="button" class="btn btn-deep-purple galleryButton">'.$authorname.'</button>';}
	 if($scriptname != '') {
	 echo '<button title="Script Writer" type="button" class="btn btn-unique galleryButton">'.$scriptname.'</button>';}
	 if($pencilsname != '') {
	 echo '<button title="Pencils" type="button" class="btn btn-unique galleryButton">'.$pencilsname.'</button>';}
	 if($inksname != '') {
	 echo '<button title="Inks" type="button" class="btn btn-unique galleryButton">'.$inksname.'</button>';}
	 if($colorsname != '') {
	 echo '<button title="Coloring" type="button" class="btn btn-unique galleryButton">'.$colorsname.'</button>';}
	 if($lettersname != '') {
	 echo '<button title="Lettering" type="button" class="btn btn-unique galleryButton">'.$lettersname.'</button>';}
	 if($publisher != '') {
	 echo '<button title="Brand/Publisher" type="button" class="btn btn-purple galleryButton">'.$publisher.'</button>';}
	 if($audience != '') {
	 echo '<button title="Audience Category" type="button" class="text-dark btn btn-deep-orange galleryButton">'.$audience.'</button>';}
	 echo '<br><br><button title="Comic Generator" type="button" class="text-dark btn btn-light-blue galleryButton">A Storybook Comic</button>';
$cardcode3 = <<< EOTA
	</div>
	</div>
</article>
</div>
<!-- </div>-->
EOTA;
echo $cardcode3;
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-5 px-sm-0 msgBox">'.
'<h3>Configuration and Gallery Card file Actions</h3>'.
'<div class="d-flex col-sm-12 flex-column infoBox">';
//'<input class="checkbox" type="checkbox" id="saveCheckbox" name="saveCheckbox" checked hidden>Save this configuration data to continue.<br>'.
if($_SESSION['usedSavedConfig'] == 1) { //because of 'Comic' query string, already checked ownership
	echo
	'<form id="saveconfigDisplay" action="./saveConfig.php" method="post">'.
	'You may replace your current Configuration and Gallery card files with the displayed values.<br>You can also choose whether or not to delete any other Comic contents.<br>Leave the box unchecked to delete the current '.$Comicname.' contents or check the box to leave the current Comic contents as they are.<br>'.
	'<label>Check to preserve any present content:&emsp;<input class="checkbox" type="checkbox" id="saveCheckbox" name="saveCheckbox" value="0" unchecked></label><br>'.
	'<label>Save the Configuration and Card data:&emsp;<input type="submit" value="Apply"></label></form><br>';
} else {
	if(!(isset($_SESSION['Comicname']))) {
		echo
		'<p>No Comic Name is specified. No actions may be taken.</p>';
	} else {
		$thisOauthID = '';
		if(isset($_SESSION['oauth_id'])) {
			$thisOauthID = $_SESSION['oauth_id'];}
		if(!(file_exists('/home/bitnami/Comics/htdocs/'.$Comicname.'/'.$Comicname.'.php'))) {
			echo
			'<p>No Configuration Data file exists with Comic Name matching '.$Comicname.'</p>'.
			'<form id="saveconfigDisplay" action="./saveConfig.php" method="post">'.
			'You may save new Configuration and Gallery card files with the displayed values.<br>This will start building your '.$Comicname.' Comic.<br>'.
			'<label style="opacity: 0;">Check to preserve any present content:&emsp;<input class="checkbox" type="hidden" id="saveCheckbox" name="saveCheckbox" value="1" checked></label><br>'.
			'<label>Save the Configuration and Card data:&emsp;<input type="submit" value="Apply"></label></form><br>';
		} else {
			$configFileContents = file_get_contents('/home/bitnami/Comics/htdocs/'.$Comicname.'/'.$Comicname.'.php');
			if( preg_match_all('/('.preg_quote($thisOauthID,'/').')/i', $configFileContents, $matches)){
				//print_r($matches);
			echo
			'<p>Configuration Data file exists with matching oauth_id '.$thisOauthID.'</p>'.
			'<form id="saveconfigDisplay" action="./saveConfig.php" method="post">'.
			'You may replace your current saved Configuration and Gallery card files with the displayed values.<br>You can also choose whether or not to delete any other Comic contents.<br>Leave the box unchecked to delete the current '.$Comicname.' contents or check the box to leave the current Comic contents as they are.<br>'.
			'<label>Check to preserve any present content:&emsp;<input class="checkbox" type="checkbox" id="saveCheckbox" name="saveCheckbox" value="0" unchecked></label><br>'.
			'<label>Save the Configuration and Card data:&emsp;<input type="submit" value="Apply"></label></form><br>';
			} else {
				'<p>Configuration Data file exists but oauth_id '.$thisOauthID.' does not match. You may not modify this Comic.</p>';
			}
		}
	}
}
echo
	'</div></section>';
echo
'<section class="d-flex col-sm-11 flex-column align-items-center shadow-md light-blue lighten-5 px-sm-0 msgBox">'.
'<h3 class="d-flex col-sm-12 flex-column dark-text">In the following dialog pages you will provide the Comic Content that will be merged with this configuration data to create the actual Comic.<br></h3></section>';

	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 orngBox" id="ComicFooter">'.
	'<nav><p><a id="prevpagebutton" href="./OauthPortal.php" title="return to the logon portal">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
	<g transform="translate(0.000000,40.000000) scale(0.100000,-0.100000)"
	fill="#000000" stroke="none">
	<path d="M97 323 l-97 -78 0 -122 0 -123 200 0 201 0 -3 127 -3 127 -93 73
	c-52 40 -97 73 -101 73 -4 0 -51 -35 -104 -77z m184 -9 c43 -30 79 -59 79 -63
	0 -6 -63 -41 -75 -41 -3 0 -5 14 -5 30 l0 30 -85 0 -85 0 0 -30 c0 -16 -4 -30
	-10 -30 -16 0 -60 23 -60 31 0 9 142 128 153 129 5 0 45 -25 88 -56z m97 -177
	c1 -48 -1 -87 -5 -87 -10 0 -163 94 -163 100 0 9 144 79 155 76 6 -1 11 -42
	13 -89z m-273 51 c36 -18 65 -35 65 -38 0 -6 -125 -101 -143 -108 -4 -2 -7 37
	-7 87 0 53 4 91 10 91 5 0 39 -14 75 -32z m174 -99 c45 -29 81 -56 81 -60 0
	-5 -73 -9 -161 -9 -149 0 -160 1 -148 17 17 19 130 103 140 103 4 0 44 -23 88
	-51z"/>
	</g>
	</svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i:s.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./getComic.php" title="get the Comics images">Next ❯</a></p></nav>'.
		'</footer>';
echo
'</main>';
}}
?>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/bootstrap.js"></script>
<!--	<script src="./js/jquery.dataTables.js" charset="utf-8"></script>
	<script src="./js/DT_bootstrap.js" charset="utf-8"></script>
	<script src="./js/vpb_uploader.js"></script> -->
</body>
</html>