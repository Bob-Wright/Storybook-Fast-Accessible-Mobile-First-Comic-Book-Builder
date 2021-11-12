<?php
/*
* makeComic.php actually builds and then saves the web comic
* using _SESSION data values and database values
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// be sure we are here by a POST request
if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['Comicname'])) && ($_POST['Comicname'] != '')) {
// Start session
//if ((session_status() == PHP_SESSION_NONE) || (session_status() !== PHP_SESSION_ACTIVE)) {
	session_name("Storybook");
	//if(isset($_COOKIE['Storybook'])) {
	//	session_id($_COOKIE['Storybook']);}
	require_once("/home/bitnami/session2DB/Zebra.php");
//}
$rindex = 0;
$showFigCntr = false;
$Comicname = $_SESSION['Comicname'];
$siteurl = $_SESSION['siteurl'];
$Comics = '/home/bitnami/Comics/htdocs/';
if(is_file($Comics.$Comicname.'/'.$Comicname.'FONTS.php')) {
	include($Comics.$Comicname.'/'.$Comicname.'FONTS.php');
}
if(is_file($Comics.$Comicname.'/'.$Comicname.'AFONTS.php')) {
	include($Comics.$Comicname.'/'.$Comicname.'AFONTS.php');
}
// set up to buffer output
ob_start();
// begin generated web page content
$head1 = <<< EOT1
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
EOT1;
echo $head1;
echo '<title>'.$_SESSION['cardTitle'].'</title>';
echo '<meta NAME="Last-Modified" CONTENT="'. date ("F d Y H:i.", getlastmod()).'">';
echo '<meta name="copyright" content="Site design and code Copyright 2021 by IsoBlock.com, Artistic Content Copyright 2021 by '.$_SESSION['artistname'].'">';
$head3 = <<< EOT3
	<meta name="description" content="A Storybook Web Comic">
	<meta name="generator" content ="IsoBlock Synthetic Reality Storybook Comic Book Builder">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="comics,images,art,graphics,illustration">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"/> 
EOT3;
echo $head3;
if((is_file($Comics.$Comicname.'OGIMG.jpg')) || (is_file($Comics.$Comicname.'OGIMG.webp'))) {
	echo '<meta property="og:url" content="'.$_SESSION['siteurl'].$Comicname.'.html" >';
	echo '<meta property="og:type" content="website" >';
	echo '<meta property="og:title" content= "'.$_SESSION['cardTitle'].'" >';
	echo '<meta property="og:description" content="A comic by '.$_SESSION['artistname'].'">';
	if(is_file($Comics.$Comicname.'OGIMG.webp')) {
		echo '<meta property="og:image" content="'.$siteurl.$Comicname.'OGIMG.webp" >';
		echo '<meta property="og:image:type"       content="image/webp" >';
	} else {
		echo '<meta property="og:image" content="'.$siteurl.$Comicname.'OGIMG.jpg" >';
		echo '<meta property="og:image:type"       content="image/jpg" >';
	}	
	echo 
		 '<meta property="og:image:width"      content="1800" >'.
		 '<meta property="og:image:height"     content="960" >';
	echo
		'<meta property="fb:app_id" content="1297101973789783" >';
}
echo '<base href="'.$_SESSION['siteurl'].'">';
echo '<link href="'.$_SESSION['pageURL'].'" rel="canonical" Content-Type="text/html">';
$head4 = <<< EOT4
	<!-- Bootstrap -->
	<link rel="stylesheet" href="./css/bootstrap51.min.css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./favicon.ico" type="image/ico"/>
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
<script> //if we have javascript then remove no-js class from html
  document.documentElement.classList.remove("no-js");
</script>
<script type="text/javascript" src="./js/modernizr-webpdetect-min.js"></script>
<script>  // check for webp support
  Modernizr.on('webp', function(result) {
    if (result) {
      // supported
    } else {
      // not-supported
    }
  });
</script>
<style>
* {
 box-sizing: border-box;
}
EOT4;
echo $head4;
if(isset($_SESSION['pfontinfo'])) {
	$pfontinfo = $_SESSION['pfontinfo'];
	echo $pfontinfo;
} else {
$pfinfo = <<< PF
@media screen and (max-width: 576px) {
@font-face {font-family: "RobotoSlab-Regular"; src: url("./Fonts/RobotoSlab-Regular.ttf") format("truetype");} .card-body, p { font: 3.5vw RobotoSlab-Regular; color: #000000;}}
@media screen and (min-width: 577px) and (max-width: 1079px)  {
@font-face {font-family: "RobotoSlab-Regular"; src: url("./Fonts/RobotoSlab-Regular.ttf") format("truetype");} .card-body, p { font: 2.5vw RobotoSlab-Regular; color: #000000;}}
@media (min-width: 1080px) {
@font-face {font-family: "RobotoSlab-Regular"; src: url("./Fonts/RobotoSlab-Regular.ttf") format("truetype");} .card-body, p { font: 2vw RobotoSlab-Regular; color: #000000;}
PF;
echo $pfinfo;
}
if(isset($_SESSION['hfontinfo'])) {
	$hfontinfo = $_SESSION['hfontinfo'];
	echo $hfontinfo;
} else {
$hfinfo = <<< HF
@media screen and (max-width: 576px) {
@font-face {font-family: "Montserrat-Bold"; src: url("./Fonts/Montserrat-Bold.ttf") format("truetype");} h1 { font: 5vw Montserrat-Bold; color: #000000;} h2 { font: 4vw Montserrat-Bold; color: #000000;} h3 { font: 3.5vw Montserrat-Bold; color: #000000;}.xmplc {background: #FFE4E1;}
}
@media screen and (min-width: 577px) and (max-width: 1079px)  {
@font-face {font-family: "Montserrat-Bold"; src: url("./Fonts/Montserrat-Bold.ttf") format("truetype");} h1 { font: 4vw Montserrat-Bold; color: #000000;} h2 { font: 3.5vw Montserrat-Bold; color: #000000;} h3 { font: 3vw Montserrat-Bold; color: #000000;}.xmplc {background: #FFE4E1;}
}
@media (min-width: 1080px) {
@font-face {font-family: "Montserrat-Bold"; src: url("./Fonts/Montserrat-Bold.ttf") format("truetype");} h1 { font: 3vw Montserrat-Bold; color: #000000;} h2 { font: 2.5vw Montserrat-Bold; color: #000000;} h3 { font: 2.2vw Montserrat-Bold; color: #000000;}.xmplc {background: #FFE4E1;}
}
HF;
echo $hfinfo;
}
if(isset($_SESSION['cbinfo'])) {
	$cbinfo = $_SESSION['cbinfo'];
	echo '.xmplc ' . $cbinfo;
} else {
$cbinfo = <<< CB
.xmplc {background: #FFE4E1;}
CB;
echo $cbinfo;
}
if(isset($_SESSION['apfontinfo'])) {
	$apfontinfo = $_SESSION['apfontinfo'];
	echo '.xmpla { ' . $apfontinfo . ' }';
}
if(isset($_SESSION['ahfontinfo'])) {
	$ahfontinfo = $_SESSION['ahfontinfo'];
	echo '.xmpla { ' . $ahfontinfo . ' }';
}
if(isset($_SESSION['acbinfo'])) {
	$acbinfo = $_SESSION['acbinfo'];
	echo '.xmpla ' . $acbinfo;
}
$head4a = <<< EOT4a
.playButton {
 display: block;
 background-color: rgba(128, 128, 128, .8);
 z-index: 30;
 opacity: 1;
 border: .3vw solid cyan;
}
.MP3Overlay {
 display: block;
 background-color: rgba(128, 128, 128, .8);
 z-index: 30;
 opacity: 1;
 border: .3vw solid cyan;
}
.transcriptControl {
 display: block;
 background-color: rgba(128, 128, 128, .8);
 z-index: 30;
 opacity: 1;
 border: .3vw solid cyan;
}
.imgblock img {
  position: relative;
  left: 50%;
  transform: translateX(-50%);
}
a:focus, div:focus, img:focus {
  border: .05vw solid black;
  outline-style: solid;
  outline-color: GreenYellow;
  outline-width: .5vw;
}
EOT4a;
echo $head4a;
if(is_file($Comics.$Comicname.'/'.$Comicname.'BKGND-s.jpg')) {
	$_SESSION['bkgndImage'] = $Comicname.'BKGND-s.jpg';
	$bkgndImage = $Comicname.'BKGND';
/*
* These values are based upon the Bootstrap breakpoint choices
* breakpoint names	X- Small Small   Medium  Large   X- Large XX- Large
* breakpoints       <576px	≥576px	≥768px	≥992px	≥1200px	≥1400px
* .container		100%	540px	720px	960px	1140px	1320px
* image sizes				576px	768px	992px	1200px	1400px
*/
$headC1 = <<< EOTC1
@media screen and (max-width: 576px) {
#container:before {background-image: url("./$Comicname/$bkgndImage-s.jpg");}
.webp #container:before {background-image: url("./$Comicname/$bkgndImage-s.webp");}
}
@media screen and (min-width: 577px) and (max-width: 768px)  {
#container:before {background-image: url("./$Comicname/$bkgndImage-m.jpg");}
.webp #container:before {background-image: url("./$Comicname/$bkgndImage-m.webp");}
}
@media screen and (min-width: 769px) and (max-width: 992px)  {
#container:before {background-image: url("./$Comicname/$bkgndImage-l.jpg");}
.webp #container:before {background-image: url("./$Comicname/$bkgndImage-l.webp");}
}
@media screen and (min-width: 993px) and (max-width: 1200px)  {
#container:before {background-image: url("./$Comicname/$bkgndImage-x.jpg");}
.webp #container:before {background-image: url("./$Comicname/$bkgndImage-x.webp");}
}
@media screen and (min-width: 1201px) {
#container:before {background-image: url("./$Comicname/$bkgndImage-X.jpg");}
.webp #container:before {background-image: url("./$Comicname/$bkgndImage-X.webp");}
}
#container:before {
	content: ' ';
	display: block;
	position: fixed;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	z-index: -1;
	opacity: 0.6;
	background-position: top center;
	background-repeat: no-repeat;
	-ms-background-size: 100% 100%;
	-o-background-size: 100% 100%;
	-moz-background-size: 100% 100%;
	-webkit-background-size: 100% 100%;
	background-size: 100% 100%;
}
EOTC1;
echo $headC1;
} else {
$headC1 = <<< EOTC1
#container:before {
	background-color: #b0bec5;
}
EOTC1;
echo $headC1;
}
$head5 = <<< EOT5
</style>
</head>
<!-- End of the HTML head section-->
<!-- =========================== -->
<!-- +++++++++++++++++++++++ -->
<!-- Build out the page -->
<body class="container">
EOT5;
echo $head5;
echo
	'<h1 class="visually-hidden">'.$_SESSION['cardTitle'].'</h1>';
$head6 = <<<EOT6
<!--#include file="./includes/browserupgrade.ssi" -->
<main  id="container" class="row d-flex align-items-start">
<article class="imgblock col-12 justify-content-center">
   <nav tabindex="-1" class="row fixed-top col-2 d-flex justify-content-center" style="background-color: rgba(255,80,0,.4);"><a tabindex="0" class="d-flex justify-content-center" title="jump to the Comics gallery" href="./Comics.php">
		<svg version="1.0" xmlns="http://www.w3.org/2000/svg"  id="comicsHome" class="bi-layout-wtf"
		 width="8vw" height="6vw" viewBox="0 0 60.000000 42.000000" stroke="blue" stroke-width="10">
		<g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)">
		<path d="M467 413 c-2 -2 -32 -4 -67 -4 -53 -1 -67 -5 -87 -26 l-25 -24 -43
		21 c-36 17 -58 20 -136 18 l-93 -3 3 -150 c1 -82 6 -153 10 -158 4 -4 24 -1
		44 8 41 17 85 19 107 5 11 -7 6 -10 -22 -10 -40 0 -121 -31 -133 -51 -9 -13
		-1 -12 75 16 51 19 97 14 149 -16 l34 -20 22 27 c20 25 25 26 92 22 48 -2 78
		-9 90 -20 22 -20 73 -34 73 -20 0 5 -24 21 -53 36 -43 21 -69 26 -127 26 -65
		0 -71 2 -59 16 13 16 35 16 197 -2 l52 -6 0 79 c0 43 5 109 10 147 6 38 7 73
		3 77 -9 7 -110 18 -116 12z m88 -70 c-4 -26 -9 -86 -11 -133 l-3 -85 -28 1
		c-15 1 -59 7 -97 14 -64 11 -70 11 -97 -9 -26 -20 -29 -20 -38 -3 -9 15 -10
		15 -11 -5 0 -27 2 -27 -61 -7 -48 16 -112 15 -152 -1 -16 -7 -17 3 -17 129 l0
		136 69 0 c70 0 149 -21 163 -43 4 -7 8 -40 8 -74 0 -35 4 -63 10 -63 6 0 10
		30 10 69 0 52 5 74 19 92 17 23 26 24 131 27 l112 3 -7 -48z"/></a>
		</g></svg>
    </nav>


<!-- ++++++++++++++++++++ -->
<!--  build comic pages -->
<!-- ++++++++++++++++++++ -->
EOT6;
echo $head6;
// Include ComicImages class
	/*	TABLE `comicimagedata`
	 `comic_id`
	 `comic_name`
	 `oauth_id`
	 `image_hash`
	 `image_key`
	 `filename`
	 `filetype`
	 `width`
	 `height`
	 `created`
	*/
require("/home/bitnami/includes/ComicImages.class.php");
    $comic = new ComicImages();
$imageList = $comic->listComicImages($Comicname);
$_SESSION['imageList'] = $imageList;
//echo '<p>'; echo var_dump($imageList); echo '</p>';
/*
$constring = print_r($imageList);
echo '<script>console.info('.$constring.')</script>';
*/
for ($i = 0; $i <  count($imageList); $i++) {
	$imageIndex=key($imageList);
	$imageKey=$imageList[$imageIndex];
	if ($imageKey<> ' ') {
	   //echo $imageIndex ." = ".  $imageKey ." <br> ";
	   $imageIndex = $imageIndex + 1;
		//echo $val .".jpg<br> ";
		//$imageKey = $val;
 	// get image data from the database
    $imageData = $comic->returnComicRecord($imageKey);
    // Store image data in the session
    $_SESSION['imageData'] = $imageData;
	//echo '<p>'; echo var_dump($imageData); echo '</p>';
	$imageKey = $_SESSION['imageData']['image_key'];
	$filename = $_SESSION['imageData']['filename'];
	$xmlFile = pathinfo($filename);
	$filenameNoExt = $xmlFile['filename'];
	$filetype = $xmlFile['extension'];
	$width = $_SESSION['imageData']['width'];
	$height = $_SESSION['imageData']['height'];
	$created = $_SESSION['imageData']['created'];
	$FigDesc = 'This image is '.$filename.'.';
	//$FigCntr = '[ '.$imageIndex.' of '.count($imageList).' ]';
	$FigCntr = '[&nbsp;p&emsp;'.$imageIndex.'&nbsp;]';
	// now have an array of values for this image as large jpg
	// we generate the filenames for our other sizes and formats

	if(!(($width == 1) && ($height == 1))) { // display image if not the 1px by 1px "no image image"
	// see if we have alt text for this image
	// !!! every image should have an alt text description !!!
	$altText = $FigDesc; // fallback to file name as alt text
	if(is_dir($Comics.$Comicname.'/altText/')) {
		$altTextDir = $Comics.$Comicname.'/altText/';
		$altTextFile = $filenameNoExt.'.txt';
		// check for txt file
		if(is_file($altTextDir.$altTextFile)) {
			$altText = (file_get_contents($altTextDir.$altTextFile));
			$altDesc = 'There is an alt text file named '.$altTextDir.$altTextFile.'.';
			$_SESSION['altDesc'] = $altDesc;
		}
	}
if($filetype == 'gif') {
// reinsert <img class="src" id=""
$wcode = $width.'w';
$imgcode1 = <<< IMC1
		srcset = "./$Comicname/$filenameNoExt.webp $wcode, ./$Comicname/$filename $wcode"
		sizes = "95vmin"
		alt = "'.$altText.'"
	>
IMC1;
	//echo $imgcode;
} else { // not a GIF
/*
* These values are based upon the Bootstrap breakpoint choices
* breakpoint names	X- Small Small   Medium  Large   X- Large XX- Large
* breakpoints       <576px	≥576px	≥768px	≥992px	≥1200px	≥1400px
* .container		100%	540px	720px	960px	1140px	1320px
* image sizes				576px	768px	992px	1200px	1400px
*/
$srcset = array();
$ComicsDirFiles = dir($Comics.$Comicname) or die;
while (false !== ($f = $ComicsDirFiles->read())) { // loop thru directory
  if (strpos($f, $filenameNoExt) !== false) {
	if (strpos($f, '.webp') !== false) {
	 if (strpos($f, '-s-') !== false) {
	 $srcset[0] = $f;}
	 if (strpos($f, '-m-') !== false) {
	 $srcset[1] = $f;}
	 if (strpos($f, '-l-') !== false) {
	 $srcset[2] = $f;}
	 if (strpos($f, '-x-') !== false) {
	 $srcset[3] = $f;}
	 if (strpos($f, '-X-') !== false) {
	 $srcset[4] = $f;}
	}
	if (strpos($f, '.jpg') !== false) {
	 if (strpos($f, '-s-') !== false) {
	 $srcset[5] = $f;}
	 if (strpos($f, '-m-') !== false) {
	 $srcset[6] = $f;}
	 if (strpos($f, '-l-') !== false) {
	 $srcset[7] = $f;}
	 if (strpos($f, '-x-') !== false) {
	 $srcset[8] = $f;}
	 if (strpos($f, '-X-') !== false) {
	 $srcset[9] = $f;}
	}
  }
}
$ComicsDirFiles->close();
//$srcImgHdr = '<img class="src" id="" style="display: block;"';
$imgcode1 = <<< IMC1
	srcset = "./$Comicname/$srcset[0] 576w,
				./$Comicname/$srcset[1] 768w,
				./$Comicname/$srcset[2] 992w,
				./$Comicname/$srcset[3] 1200w,
				./$Comicname/$srcset[4] 1400w,
				./$Comicname/$srcset[5] 576w,
				./$Comicname/$srcset[6] 768w,
				./$Comicname/$srcset[7] 992w,
				./$Comicname/$srcset[8] 1200w,
				./$Comicname/$srcset[9] 1400w"
	sizes = "(max-width: 576px) 576px,
			((min-width: 577px) and (max-width: 768px)) 768px,
			((min-width: 769px) and (max-width: 992px)) 992px,
			((min-width: 993px) and (max-width: 1200px)) 1200px,
			(min-width: 1201px) 1400px"
	alt = "$altText"
	>
IMC1;
//$_SESSION['imgcode1'] = $imgcode1;
	//echo $imgcode;
}
/* // test breakpoint trap
	} // from width/height = 1 test
	} // from for each image loop
	next($imageList);
} // from image loop
*/
	// see if we have an altImg or a soundtrack for this image
	// this alternate image is displayed on a click
	// if present the audio will also play, it is muted by default
$imgcode2 = '';
$altImgsDir = $Comics.$Comicname.'/altImgs/';
if(is_dir($altImgsDir)) {

	$altimgmp3 = '';
	$playMP3 = '';
	if(is_file($altImgsDir.$filenameNoExt.'.mp3')) {
		$altimgmp3 = $filenameNoExt.'.mp3';
		$playMP3 = 'playMP3';}
// transcript text file
	if(is_file($altImgsDir.$filenameNoExt.'.mpt')) {
		$altMP3Text = (file_get_contents($altImgsDir.$filenameNoExt.'.mpt'));
		$altMP3TextDesc = 'There is an audio transcript file named '.$altImgsDir.$filenameNoExt.'.mpt';}

	if($altimgmp3 != '') {
		$altImgMP3Desc = 'There is an audio alternate image file named '.$altImgsDir.$altimgmp3.'.';
	} else { $altImgMP3Desc = 'There is no audio alternate image.';}
	$report[$rindex] = $altImgMP3Desc . "<br>";
		$rindex = $rindex+1;

	// see if we have alt text for an alt image
	// !!! every image should have an alt text description !!!
	$altImgText = '';
	$altImgTextFile = '';
	$altImgTextDesc = '';
	if(is_file($altImgsDir.$filenameNoExt.'.txt')) {
		$altImgText = (file_get_contents($altImgsDir.$filenameNoExt.'.txt'));
		$altImgTextDesc = 'There is an alternate image text file named '.$altImgsDir.$filenameNoExt.'.txt';
	} else {
		$altImgTextDesc = 'This image is '. $filenameNoExt;
		$altImgText = $altImgTextDesc;
	}
	$report[$rindex] = $altImgTextDesc . "<br>";
		$rindex = $rindex+1;
	
// reinsert	<img class="playGIF src" id="" style="display: block;"
//$imgcode2 = '';
if(is_file($altImgsDir.$filenameNoExt.'.gif')) { // see if we have a GIF alternate image
		$widthw = $width .'w';
	if($playMP3 == 'playMP3') {
		$imgcode2class = "playGIF playMP3 alt";
	} else {
		$imgcode2class = "playGIF alt";
	}
$imgcode2 = <<< IMC2
	<img tabindex="0" class="$imgcode2class" id="$imageIndex" style="display: none;"
	srcset = "./$Comicname/altImgs/$filenameNoExt.webp $widthw,
				./$Comicname/altImgs/$filenameNoExt.gif $widthw"
	sizes = "95vmin"
	alt = "$altImgText"
	>
IMC2;
		//echo $imgcode2;
}
 // check for images that are not a gif
$asrcset = array();
$altImgsDirFiles = dir($altImgsDir) or die;
while (false !== ($f = $altImgsDirFiles->read())) { // loop thru directory
  if (strpos($f, $filenameNoExt) !== false) {
	if (strpos($f, '.webp') !== false) {
	 if (strpos($f, '-s-') !== false) {
	 $asrcset[0] = $f;}
	 if (strpos($f, '-m-') !== false) {
	 $asrcset[1] = $f;}
	 if (strpos($f, '-l-') !== false) {
	 $asrcset[2] = $f;}
	 if (strpos($f, '-x-') !== false) {
	 $asrcset[3] = $f;}
	 if (strpos($f, '-X-') !== false) {
	 $asrcset[4] = $f;}
	}
	if (strpos($f, '.jpg') !== false) {
	 if (strpos($f, '-s-') !== false) {
	 $asrcset[5] = $f;}
	 if (strpos($f, '-m-') !== false) {
	 $asrcset[6] = $f;}
	 if (strpos($f, '-l-') !== false) {
	 $asrcset[7] = $f;}
	 if (strpos($f, '-x-') !== false) {
	 $asrcset[8] = $f;}
	 if (strpos($f, '-X-') !== false) {
	 $asrcset[9] = $f;}
	}
  }
}
$altImgsDirFiles->close();
//	<img class="playGIF src" id="" style="display: block;"
if (!(empty($asrcset))) {
	if($playMP3 == 'playMP3') {
		$imgcode2class = "playGIF playMP3 alt";
	} else {
		$imgcode2class = "playGIF alt";
	}
$imgcode2 = <<< IMC2
	<img tabindex="0" class="$imgcode2class" id="$imageIndex" style="display: none;"
	srcset = "./$Comicname/altImgs/$asrcset[0] 576w,
				./$Comicname/altImgs/$asrcset[1] 768w,
				./$Comicname/altImgs/$asrcset[2] 992w,
				./$Comicname/altImgs/$asrcset[3] 1200w,
				./$Comicname/altImgs/$asrcset[4] 1400w,
				./$Comicname/altImgs/$asrcset[5] 576w,
				./$Comicname/altImgs/$asrcset[6] 768w,
				./$Comicname/altImgs/$asrcset[7] 992w,
				./$Comicname/altImgs/$asrcset[8] 1200w,
				./$Comicname/altImgs/$asrcset[9] 1400w"
	sizes = "(max-width: 576px) 576px,
			((min-width: 577px) and (max-width: 768px)) 768px,
			((min-width: 769px) and (max-width: 992px)) 992px,
			((min-width: 993px) and (max-width: 1200px)) 1200px,
			(min-width: 1201px) 1400px"
	alt = "$altImgText"
	>
IMC2;
}
	// if there is an alt image we have details
if ($imgcode2 == '') { //folder but no images
	echo '<img tabindex="0" class="src" id="'.$imageIndex.'" style="display: block;"';
	echo $imgcode1;
} else { // folder and alternate images
if (!(empty($asrcset))) {
	if($playMP3 == 'playMP3') {
		$imgcode1class = "playGIF playMP3 src";
	} else {
		$imgcode1class = "playGIF src";
	}

	echo '<span class="clickMeOverlay">';
	echo '<img tabindex="0" class="'.$imgcode1class.'" id="'.$imageIndex.'" style="display: block;"';
	echo $imgcode1;
	echo $imgcode2;
	echo '</span>'; // end of clickmeoverlay

if ($altimgmp3 != '') { // we have audio
// if we have audio leave space for mute/unmute button
// need an audio instance to preset mute/unmute
$imgcode3 = <<< IMC3
	<div class="col-12 d-flex px-sm-0 transcript"><div class="card-body" id="transcript$imageIndex" style="display: none; background-color: #b0eec0">$altMP3Text</div></div>
IMC3;
	echo $imgcode3;

	// see if we have an optional caption for this image
	// we can have captions with no images for text only content
/*	$caption = '';
	$captionsDir = $Comics.$Comicname.'/captions/';
	if(is_dir($captionsDir)) {
		$captionTextFile = $filenameNoExt.'.txt';
		// check for txt file
		if(is_file($captionsDir.$captionTextFile)) {
			$caption = (file_get_contents($captionsDir.$captionTextFile));
		}
	}
	$altCaption = '';
	$altCaptionsDir = $Comics.$Comicname.'/altCaptions/';
	if(is_dir($altCaptionsDir)) {
		$altCaptionTextFile = $filenameNoExt.'.txt';
		// check for txt file
		if(is_file($altCaptionsDir.$altCaptionTextFile)) {
			$altCaption = (file_get_contents($altCaptionsDir.$altCaptionTextFile));
		}
	}
	// display caption
	if($caption != '') {
		if(preg_match('/To\sbe\scontinued\./', $caption)) {
			echo
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="card col-12 d-flex flex-column shadow-md #ef9a9a 	danger-color-lite lighten-3 px-sm-0">'.
				'<div class="card-body"><h2 style="text-align: center;"><b>To be continued...</b></h2></div>'.
				'</div>'.
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		} else {
			echo
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="xmplc card col-12 d-flex shadow-md px-sm-0">';
			echo
				'<div tabindex="0" class="card-body" id="caption'.$imageIndex.'" style="display: block;">'.$caption.'</div>';
			if($altCaption != '') {
			echo
				'<div tabindex="0" class="card-body xmpla" id="altcap'.$imageIndex.'" style="display: none;">'.$altCaption.'</div>';
			}
			echo
				'</div>'.
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		}
	}
	if($caption == '') {
		echo
			'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}
	if($showFigCntr == true) {
			echo
			'<div class="card col-12 px-sm-0" style="opacity: 0;"><br></div>'.
			'<div class="xmplc card col-3 d-flex shadow-md px-sm-0">'.
			'<div class="card-body"><h2>'.$FigCntr.'</h2></div>'.
			'</div>'.
			'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}
*/
	$altMP3 = $altImgsDir.$altimgmp3;
$audiobuttons = <<< AB1
	<audio id="audio$imageIndex" src="./$Comicname/altImgs/$altimgmp3" type="audio/mpeg" alt="$altimgmp3">No Audio Support</audio>
	<div class="row">
	<div tabindex="0" title="toggle audio mute" id="mute-audio" class="card col-2 d-flex flex-column px-sm-0 MP3Overlay align-items-center">
	<svg title="mute-audio" width="8vw" height="8vw" viewBox="0 0 16 16" class="bi bi-volume-mute" fill="white" stroke="red" stroke-width=".5" xmlns="http://www.w3.org/2000/svg">
	  <path fill-rule="evenodd" d="M6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06zM6 5.04L4.312 6.39A.5.5 0 0 1 4 6.5H2v3h2a.5.5 0 0 1 .312.11L6 10.96V5.04zm7.854.606a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708l4-4a.5.5 0 0 1 .708 0z"/>
	  <path fill-rule="evenodd" d="M9.146 5.646a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0z"/>
	</svg>
	<svg title="enable-audio" width="8vw" height="8vw" viewBox="0 0 16 16" class="bi bi-volume-up" fill="white" stroke="green" stroke-width=".5" xmlns="http://www.w3.org/2000/svg">
	  <path fill-rule="evenodd" d="M6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06zM6 5.04L4.312 6.39A.5.5 0 0 1 4 6.5H2v3h2a.5.5 0 0 1 .312.11L6 10.96V5.04z"/>
	  <path d="M11.536 14.01A8.473 8.473 0 0 0 14.026 8a8.473 8.473 0 0 0-2.49-6.01l-.708.707A7.476 7.476 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303l.708.707z"/>
	  <path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.483 5.483 0 0 1 11.025 8a5.483 5.483 0 0 1-1.61 3.89l.706.706z"/>
	  <path d="M8.707 11.182A4.486 4.486 0 0 0 10.025 8a4.486 4.486 0 0 0-1.318-3.182L8 5.525A3.489 3.489 0 0 1 9.025 8 3.49 3.49 0 0 1 8 10.475l.707.707z"/>
	</svg></div>

	<div tabindex="0" title="toggle transcript display" id="transcriptButton" class="card col-2 d-flex flex-column px-sm-0 transcriptControl align-items-center">
	<svg style="padding-top: 1vw;" title="no-cc" xmlns="http://www.w3.org/2000/svg" width="7vw" height="7vw" stroke="red" stroke-width=".5" fill="white" class="bi bi-x-box" viewBox="0 0 16 16">
	<path d="M5.18 4.616a.5.5 0 0 1 .704.064L8 7.219l2.116-2.54a.5.5 0 1 1 .768.641L8.651 8l2.233 2.68a.5.5 0 0 1-.768.64L8 8.781l-2.116 2.54a.5.5 0 0 1-.768-.641L7.349 8 5.116 5.32a.5.5 0 0 1 .064-.704z"/>
	<path d="M4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4zm0 1h8a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
	</svg>
	<svg title="show-cc" xmlns="http://www.w3.org/2000/svg" width="8vw" height="8vw"  stroke="blue" stroke-width=".5" fill="white" class="bi bi-badge-cc" viewBox="0 0 16 16">
	  <path d="M3.708 7.755c0-1.111.488-1.753 1.319-1.753.681 0 1.138.47 1.186 1.107H7.36V7c-.052-1.186-1.024-2-2.342-2C3.414 5 2.5 6.05 2.5 7.751v.747c0 1.7.905 2.73 2.518 2.73 1.314 0 2.285-.792 2.342-1.939v-.114H6.213c-.048.615-.496 1.05-1.186 1.05-.84 0-1.319-.62-1.319-1.727v-.743zm6.14 0c0-1.111.488-1.753 1.318-1.753.682 0 1.139.47 1.187 1.107H13.5V7c-.053-1.186-1.024-2-2.342-2C9.554 5 8.64 6.05 8.64 7.751v.747c0 1.7.905 2.73 2.518 2.73 1.314 0 2.285-.792 2.342-1.939v-.114h-1.147c-.048.615-.497 1.05-1.187 1.05-.839 0-1.318-.62-1.318-1.727v-.743z"/>
	  <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"/>
	</svg></div>
	
AB1;
	echo $audiobuttons;

$playerbutton = <<< PB1
	<div tabindex="0" title="show alternate content" class="playButton clickMeOverlay card col-8 d-flex flex-column px-sm-0 align-items-center">
	<svg title="Play Button" width="8vw" height="8vw" viewBox="0 0 16 16" class="bi bi-play" stroke="white" stroke-width=".5" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" d="M10.804 8L5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z"/>
	</svg></div>
PB1;
	echo $playerbutton . '</div>';

} else { // no audio

$imgcode3 = <<< IMC3
	<div tabindex="0" title="show alternate content" class="playButton clickMeOverlay card col-12 d-flex flex-column px-sm-0 align-items-center">
IMC3;
	echo $imgcode3;
$playerbutton = <<< PB1
	<svg title="Play Button" width="8vw" height="8vw" viewBox="0 0 16 16" class="bi bi-play" fill="white" stroke="blue" stroke-width=".5" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" d="M10.804 8L5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z"/>
	</svg></div>
	</div>
PB1;
	echo $playerbutton . '<br>';
}
}
}
} else { // no alt imags folder
	echo '<img tabindex="0" class="src" id="'.$imageIndex.'" style="display: block;"';
	echo $imgcode1;
}
	} //from 1x1 image test

	// see if we have an optional caption for this image
	// we can have captions with no images for text only content
	$caption = '';
	$captionsDir = $Comics.$Comicname.'/captions/';
	if(is_dir($captionsDir)) {
		$captionTextFile = $filenameNoExt.'.txt';
		// check for txt file
		if(is_file($captionsDir.$captionTextFile)) {
			$caption = (file_get_contents($captionsDir.$captionTextFile));
		}
	}
	$altCaption = '';
	$altCaptionsDir = $Comics.$Comicname.'/altCaptions/';
	if(is_dir($altCaptionsDir)) {
		$altCaptionTextFile = $filenameNoExt.'.txt';
		// check for txt file
		if(is_file($altCaptionsDir.$altCaptionTextFile)) {
			$altCaption = (file_get_contents($altCaptionsDir.$altCaptionTextFile));
		}
	}
	// display caption
	if($caption != '') {
		if(preg_match('/To\sbe\scontinued\./', $caption)) {
			echo
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="card col-12 d-flex flex-column shadow-md #ef9a9a 	danger-color-lite lighten-3 px-sm-0">'.
				'<div class="card-body"><h2 style="text-align: center;"><b>To be continued...</b></h2></div>'.
				'</div>'.
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		} else {
			echo
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="xmplc card col-12 d-flex shadow-md px-sm-0">';
			echo
				'<div tabindex="0" class="card-body" id="caption'.$imageIndex.'" style="display: block;">'.$caption.'</div>';
			if($altCaption != '') {
			echo
				'<div tabindex="0" class="card-body xmpla" id="altcap'.$imageIndex.'" style="display: none;">'.$altCaption.'</div>';
			}
			echo
				'</div>'.
				'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		}
	}
	if($caption == '') {
		echo
			'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}
	if($showFigCntr == true) {
			echo
			'<div class="card col-12 px-sm-0" style="opacity: 0;"><br></div>'.
			'<div class="xmplc card col-3 d-flex shadow-md px-sm-0">'.
			'<div class="card-body"><h2>'.$FigCntr.'</h2></div>'.
			'</div>'.
			'<div class="card col-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}

	}
	next($imageList);
}

$head9 = <<< EOT9
<!-- +++++++++++++++++++++++ -->
<!-- =========================== -->
<!--#include file="./includes/footer.shtml" -->
</article>
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<!-- ++++++++++++++++++++ -->
<!-- Java script section -->
  <!-- jQuery -->
  <script type="text/javascript" id="" src="./js/jquery.min.js"></script>
  <!-- core JavaScript -->
  <script type="text/javascript" id="" src="./js/bootstrap51.min.js"></script>
<script type="text/javascript" src="./js/Reader.js"></script>
<script >
  //conditionally enable/disable right mouse click //
$(document).ready( function() {
		//Disable cut copy paste
		$('body').bind('cut copy paste', function (e) {
        e.preventDefault();
		});
		//Disable mouse right click
		$("body").on("contextmenu",function(e){
			return false;
		});
		console.info("no context");
})
</script>
<!-- End of the Java script section-->
<!-- ======================= -->
<!-- +++++++++++++++++++++++ -->
<!-- End of the web page -->
</body>
</html>
EOT9;
echo $head9;
//nominal end of the generated web page
$page = ob_get_contents();
ob_end_clean();

// strip off the ISP inserted script footer at end of the page
//$page = substr($page, 0, strpos($page, '<!-- End of the web page -->'));
//$page = $page.'<!-- End of the web page --></body></html>';

if(is_file('/home/bitnami/Comics/htdocs/'.$Comicname.'.html')) {
	unlink('/home/bitnami/Comics/htdocs/'.$Comicname.'.html');}
$file = fopen('/home/bitnami/Comics/htdocs/'.$Comicname.'.html', "w");
fwrite($file, $page);
fclose($file);

$_SESSION['Comicsaved'] = 1;
echo
	'<script>window.location.replace("https://syntheticreality.net/Storybook/Yield.php?saveDB=1");</script>';
}
?>