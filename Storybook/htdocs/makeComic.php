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
$Comicname = $_SESSION['Comicname'];
$siteurl = $_SESSION['siteurl'];
$Comics = '/home/bitnami/Comics/htdocs/';
// set up to buffer output
ob_start();
// begin generated web page content
$head1 = <<< EOT1
<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
EOT1;
echo $head1;
echo '<title>'.$_SESSION['cardTitle'].'</title>';
echo '<meta NAME="Last-Modified" CONTENT="'. date ("F d Y H:i:s.", getlastmod()).'">';
echo '<meta name="copyright" content="Site design and code Copyright 2020 by IsoBlock.com, Artistic Content Copyright 2020 by '.$_SESSION['artistname'].'">';
$head3 = <<< EOT3
	<meta name="description" content="A Storybook Web Comic">
	<meta name="generator" content ="IsoBlock Synthetic Reality Storybook Comic Book Builder">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="comics,images,art,graphics,illustration">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"/> 
EOT3;
echo $head3;
if((is_file($Comics.$Comicname.'OGIMG.jpg')) || (is_file($Comics.$Comicname.'OGIMG.png'))) {
	echo '<meta property="og:url" content="'.$_SESSION['siteurl'].$Comicname.'.html" >';
	echo '<meta property="og:type" content="website" >';
	echo '<meta property="og:title" content= "'.$_SESSION['cardTitle'].'" >';
	echo '<meta property="og:description" content="A comic by '.$_SESSION['artistname'].'">';
	if(is_file($Comics.$Comicname.'OGIMG.jpg')) {
		echo '<meta property="og:image:type"       content="image/jpg" >';
	} else {
		echo '<meta property="og:image:type"       content="image/png" >';
	}	
	echo 
		 '<meta property="og:image:width"      content="1800" >'.
		 '<meta property="og:image:height"     content="960" >';
	if(is_file($Comics.$Comicname.'OGIMG.jpg')) {
		echo '<meta property="og:image" content="'.$siteurl.$Comicname.'OGIMG.jpg" >';
	} else {
		echo '<meta property="og:image" content="'.$siteurl.$Comicname.'OGIMG.png" >';
	}	
	echo
		'<meta property="fb:app_id" content="1297101973789783" >';
}
echo '<base href="'.$_SESSION['siteurl'].'">';
echo '<link href="'.$_SESSION['pageURL'].'" rel="canonical">';
$head4 = <<< EOT4
	<!-- Bootstrap core CSS -->
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<!-- Material Design Bootstrap -->
	<link rel="stylesheet" href="./css/mdb.min.css">
	<!-- Your custom styles (optional)
	<link rel="stylesheet" href="./css/style.css"> -->
	<link rel='stylesheet' href="./css/colorPalette.css">
	<link rel='stylesheet' href="./css/textColorPalette.css">
	<link rel='stylesheet' href="./css/LiteThemes.css">
    <!--    <link rel="manifest" href="site.webmanifest"> -->
	<link rel="icon" href="./favicon.ico" type="image/ico"/>
	<link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
<style>
* {
 box-sizing: border-box;
}
/* @font-face {
	font-family: "Merriweather";
	src: url("./Fonts/Merriweather-Regular.ttf") format("truetype");
  }
@font-face {
	font-family: "Merriweather Black";
	src: url("./Fonts/Merriweather-Black.ttf") format("truetype");
  } */
@font-face {
	font-family: "Roboto Slab";
	src: url("./Fonts/RobotoSlab-Regular.ttf") format("truetype");
  }
@font-face {
	font-family: "Comic Neue";
	src: url("./Fonts/ComicNeue-Regular.ttf") format("truetype");
  }
/* @font-face {
	font-family: "Roboto";
	src: url("./Fonts/Roboto-Regular.ttf") format("truetype");
  } */
body {
 font-family: "Comic Neue";
}
.clickMeOverlay {
 display: block;
 z-index: 30;
 opacity: 1;
}
.MP3Overlay {
 display: block;
 z-index: 30;
 opacity: 0.7;
}
/*.playGIF {
 text-align: center;
 }*/
.bi-layout-wtf {
width: 1.6rem; height: 1.6rem;
}
.card .card-body .card-text {
 text-align: left;
 font-size: 1.3rem;
 }
@media (min-width: 1200px) {
.card .card-body .card-text {
 text-align: left;
 font-size: 1.4rem;
}
.bi-layout-wtf {
width: 3rem; height: 3rem;
}
}
EOT4;
echo $head4;
if(isset($_SESSION['bkgndImage'])) {
	$bkgndImage = $_SESSION['bkgndImage'];
$headC1 = <<< EOTC1
	#container:before {
	content: ' ';
	display: block;
	position: fixed;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	z-index: -1;
	opacity: 0.4;
EOTC1;
	echo $headC1;
	echo
	'background-image: url("./'.$Comicname.'/'.$bkgndImage.'");';
$headC2 = <<< EOTC2
background-position: top center;
	background-repeat: no-repeat;
	-ms-background-size: 100% 100%;
	-o-background-size: 100% 100%;
	-moz-background-size: 100% 100%;
	-webkit-background-size: 100% 100%;
	background-size: 100% 100%;
	}
EOTC2;
	echo $headC2;
}
$head5 = <<< EOT5
</style>
</head>
<!-- End of the HTML head section-->
<!-- =========================== -->
<!-- +++++++++++++++++++++++ -->
<!-- Build out the page -->
<body class="container-fluid main-container d-flex flex-column align-items-top #929fba mdb-color lighten-3">
      <h1 class="sr-only text-dark font-weight-bolder">A Storybook Comic</h1>
<!--#include file="./includes/browserupgrade.ssi" -->
<main class="imgblock row flex-row row-no-gutters justify-content-center" id="container">

EOT5;
echo $head5;
	//echo 'ID = '.session_id();
	//if(isset($_COOKIE['Storybook'])) {
	//echo '<h2>Storybook Cookie is = '. ($_COOKIE['Storybook']) .'</h2><br>';}
$head6 = <<< EOT6
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
echo '<script>console.log('.$constring.')</script>';
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
	$filenameNoExt = (substr($filename, 0, -4));
		//$captionStr = substr($filename, 0, 14);
	$filetype = $_SESSION['imageData']['filetype'];
	$width = $_SESSION['imageData']['width'];
	$height = $_SESSION['imageData']['height'];
	$created = $_SESSION['imageData']['created'];
	$FigDesc = 'This file is named&emsp;'.$filename.'.';
	//$FigCntr = '[ '.$imageIndex.' of '.count($imageList).' ]';
	$FigCntr = '[ '.$imageIndex.' ]';

	// now have an array of values for this image
	// see if we have alt text for this image
	// !!! every image should have an alt text description !!!
	$altText = $FigDesc; // fallback to file name as alt text
	if(is_dir($Comics.$Comicname.'/altText/')) {
		$altTextDir = $Comics.$Comicname.'/altText/';
		$pattern = '/\s/';
		$replacement = '';
		$altTextFile = $filenameNoExt.'.txt';
		$altTextFile = preg_replace($pattern, $replacement, $altTextFile);
		// check for txt file
		if(is_file($altTextDir.$altTextFile)) {
			$altText = (file_get_contents($altTextDir.$altTextFile));
			$altDesc = 'There is an alt text file named '.$altTextDir.$altTextFile.'.';
		}
	}
	// see if we have an optional caption for this image
	// we can have captions with no images for text only content
	$caption = '';
	if(is_dir($Comics.$Comicname.'/captions/')) {
		$captionDir = $Comics.$Comicname.'/captions/';
		$pattern = '/\s/';
		$replacement = '';
		$captionFile = $filenameNoExt.'.txt';
		$captionFile = preg_replace($pattern, $replacement, $captionFile);
		// check for txt file
		if(is_file($captionDir.$captionFile)) {
			$caption = (file_get_contents($captionDir.$captionFile));
			$capDesc = 'There is a caption text file named '.$captionDir.$captionFile.'.';
		}
	}
	// see if we have an altImg or a soundtrack for this image
	// this alternate image is displayed on a click
	// if present the audio also plays, it can be muted
	$altimg = '';
	$altimgmp3 = '';
	$altimgFile = '';
	if(is_dir($Comics.$Comicname.'/altImgs/')) {
		$altimgDir = $Comics.$Comicname.'/altImgs/';
		$altimgFile = $filenameNoExt;
		//$altimgFile = (strstr($filename, '.', true));
		// check for filename match and image filetype
		if(is_file($altimgDir.$altimgFile.'.gif')) {
			$altimg = $altimgFile.'.gif';}
		if(is_file($altimgDir.$altimgFile.'.jpg')) {
			$altimg = $altimgFile.'.jpg';}
		// if(is_file($altimgDir.$altimgFile.'.jpeg')) {$altimg = $altimgFile.'.jpeg';}
		if(is_file($altimgDir.$altimgFile.'.png')) {
			$altimg = $altimgFile.'.png';}
		if($altimg != '') {
			$altImgDesc = 'There is an alternate image file named '.$altimgDir.$altimg.'.';
		} else { $altImgDesc = 'There is no alternate image.';}
		// check for a filename match and MP3 audio filetype
		if(is_file($altimgDir.$altimgFile.'.mp3')) {
			$altimgmp3 = $altimgFile.'.mp3';}
		if($altimgmp3 != '') {
			$altImgMP3Desc = 'There is an audio alternate image file named '.$altimgDir.$altimgmp3.'.';
		} else { $altImgMP3Desc = 'There is no audio alternate image.';}
	}
	// see if we have alt text for this alt image
	// !!! every image should have an alt text description !!!
	$altImgText = '';
	$altImgTextFile = '';
	$altImgTextDesc = '';
	if(is_dir($Comics.$Comicname.'/altImgText/')) {
		$altImgTextDir = $Comics.$Comicname.'/altImgText/';
		//$altimgFile = (substr($filename, 0, -4))
		$altimgtextFile = $filenameNoExt.'.txt';
		$pattern = '/\s/';
		$replacement = '';
		$altImgTextFile = $altimgtextFile;
		$altImgTextFile = preg_replace($pattern, $replacement, $altImgTextFile);
		//echo '<br>'.$altImgTextFile.'<br>';
		// check for txt file
		if(is_file($altImgTextDir.$altImgTextFile)) {
			$altImgText = (file_get_contents($altImgTextDir.$altImgTextFile));
			$altImgTextDesc = 'There is an alternate image text file named '.$altImgTextDir.$altImgTextFile.'.';
		} else {
			$altImgTextDesc = 'There is no alternate image text.';
			$altImgText = $altImgTextDesc;
		}
	}
// we now have a collection of variables for this comic image page
// comment this following info display block out for production
/*
echo
'<section class="d-flex col-sm-11 flex-column shadow-md #b0bec5 blue-grey lighten-5 px-sm-0">'.
'<p style="color:indigo; font-size:1.7vw;">++++++++++++<br>'.
	$FigDesc.'<br>'.
	$altDesc.'<br>'.
	$capDesc.'<br>'.
	$altImgDesc.'<br>'.
	$altImgTextDesc.'<br>'.
	$altImgMP3Desc.'</p></section>';
*/
// next we assemble them into a page to display
// how the page will appear and act will in turn depend on their values
if($altimg == '') { //no alt image to display
	if(!(($width == 1) && ($height == 1))) { // display image if not the 1px by 1px "no image image"
		echo
		'<img id="" src="./'.$Comicname.'/'.$filename.'" width="'.$width.'" height="'.$height.'" alt="'.$altText.'">';
	}
	if($caption != '') {
		if(preg_match('/To\sbe\scontinued\./', $caption)) {
			echo
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="card col-sm-11 d-flex flex-column shadow-md #ef9a9a danger-color-lite lighten-3 px-sm-0">'.
				'<div class="card-body"><h2 style="text-align: center;" class="font-weight-bolder text-dark"><b>To be continued...</b></h2></div>'.
				'</div>'.
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		} else {
			echo
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="card col-sm-11 d-flex shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">'.
				'<div class="card-body"><p class="card-text font-weight-bolder text-dark">'.$caption.'<br>'.$FigCntr.'</p></div>'.
				'</div></div>'.
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		}
	} else {
		echo
			'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
			'<div class="card col-sm-11 d-flex shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">'.
			'<div class="card-body"><p class="card-text font-weight-bolder text-dark">'.$FigCntr.'</p></div>'.
			'</div></div>'.
			'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}

}
if($altimg != '') { // there is an alt image
	echo
	'<div class="playGIF d-flex flex-column align-items-center">';
	if($altimgmp3 == '') {
		echo // we have no audio
		'<img id="" src="./'.$Comicname.'/'.$filename.'" width="'.$width.'" height="'.$height.'" alt="'.$altText.'" altText="'.$altText.'" altImg="./'.$Comicname.'/altImgs/'.$altimg.'" altImgText="'.$altImgText.'">';
	} else {
		echo // we have audio
		'<img id="" src="./'.$Comicname.'/'.$filename.'" width="'.$width.'" height="'.$height.'" alt="'.$altText.'" altText="'.$altText.'" altImg="./'.$Comicname.'/altImgs/'.$altimg.'" altImgText="'.$altImgText.'" altMP3="./'.$Comicname.'/altImgs/'.$altimgmp3.'">'.
		'<audio class="comicAudio" src="./'.$Comicname.'/altImgs/'.$altimgmp3.'"></audio>';
	}
$playerbutton = <<< PB1
	<div class="card col-sm-11 d-flex shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 clickMeOverlay align-items-center">
	<svg class="playButton" width="4rem" height="4rem" viewBox="0 0 16 16" class="bi bi-play" fill="white" xmlns="http://www.w3.org/2000/svg">
	<path fill-rule="evenodd" d="M10.804 8L5 4.633v6.734L10.804 8zm.792-.696a.802.802 0 0 1 0 1.392l-6.363 3.692C4.713 12.69 4 12.345 4 11.692V4.308c0-.653.713-.998 1.233-.696l6.363 3.692z"/>
	</svg></div></div>
PB1;
	echo $playerbutton;
	if($altimgmp3 != '') { // if we have audio add mute/unmute button
$audiobuttons = <<< AB1
	<div id="mute-audio" class="MP3Overlay">
	<svg width="5rem" height="5rem" viewBox="0 0 16 16" class="bi bi-volume-mute" fill="red" xmlns="http://www.w3.org/2000/svg">
	  <path fill-rule="evenodd" d="M6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06zM6 5.04L4.312 6.39A.5.5 0 0 1 4 6.5H2v3h2a.5.5 0 0 1 .312.11L6 10.96V5.04zm7.854.606a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708l4-4a.5.5 0 0 1 .708 0z"/>
	  <path fill-rule="evenodd" d="M9.146 5.646a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0z"/>
	</svg>
	<svg width="5rem" height="5rem" viewBox="0 0 16 16" class="bi bi-volume-up" fill="green" xmlns="http://www.w3.org/2000/svg">
	  <path fill-rule="evenodd" d="M6.717 3.55A.5.5 0 0 1 7 4v8a.5.5 0 0 1-.812.39L3.825 10.5H1.5A.5.5 0 0 1 1 10V6a.5.5 0 0 1 .5-.5h2.325l2.363-1.89a.5.5 0 0 1 .529-.06zM6 5.04L4.312 6.39A.5.5 0 0 1 4 6.5H2v3h2a.5.5 0 0 1 .312.11L6 10.96V5.04z"/>
	  <path d="M11.536 14.01A8.473 8.473 0 0 0 14.026 8a8.473 8.473 0 0 0-2.49-6.01l-.708.707A7.476 7.476 0 0 1 13.025 8c0 2.071-.84 3.946-2.197 5.303l.708.707z"/>
	  <path d="M10.121 12.596A6.48 6.48 0 0 0 12.025 8a6.48 6.48 0 0 0-1.904-4.596l-.707.707A5.483 5.483 0 0 1 11.025 8a5.483 5.483 0 0 1-1.61 3.89l.706.706z"/>
	  <path d="M8.707 11.182A4.486 4.486 0 0 0 10.025 8a4.486 4.486 0 0 0-1.318-3.182L8 5.525A3.489 3.489 0 0 1 9.025 8 3.49 3.49 0 0 1 8 10.475l.707.707z"/>
	</svg>
	</div>
AB1;
	echo $audiobuttons;
	}
	if($caption != '') {
		if(preg_match('/To\sbe\scontinued\./', $caption)) {
			echo
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="card col-sm-11 d-flex flex-column shadow-md #ef9a9a danger-color-lite lighten-3 px-sm-0">'.
				'<div class="card-body"><h2 style="text-align: center;" class="font-weight-bolder text-dark"><b>To be continued...</b></h2></div>'.
				'</div></div></div>'.
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		} else {
			echo
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
				'<div class="card col-sm-11 d-flex shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">'.
				'<div class="card-body"><p class="card-text font-weight-bolder text-dark">'.$caption.'<br>'.$FigCntr.'</p></div>'.
				'</div></div>'.
				'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
		}
	} else {
		echo
			'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br></div>'.
			'<div class="card col-sm-11 d-flex shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">'.
			'<div class="card-body"><p class="card-text font-weight-bolder text-dark">'.$FigCntr.'</p></div>'.
			'</div></div>'.
			'<div class="card col-sm-12 px-sm-0" style="opacity: 0;"><br><br></div>';
	}
}
	}
	next($imageList);
}

$head9 = <<< EOT9
	<!-- +++++++++++++++++++++++ -->
<div class="row justify-content-end fixed-top">
    <nav title="jump to the Comics gallery" class="btn btn-sm btn-yellow accent1">
		<svg version="1.0" xmlns="http://www.w3.org/2000/svg"  id="comicsHome" class="bi-layout-wtf"
		 width="60.000000px" height="42.000000px" viewBox="0 0 60.000000 42.000000">
		<g transform="translate(0.000000,42.000000) scale(0.100000,-0.100000)"
		fill="black" stroke="black" stroke-width="5">
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
		30 10 69 0 52 5 74 19 92 17 23 26 24 131 27 l112 3 -7 -48z"/>
		</g><a xmlns="http://www.w3.org/2000/svg" id="anchor" xlink:href="./Comics.php" xmlns:xlink="http://www.w3.org/1999/xlink" target="_top"><rect x="0" y="0" width="100%" height="100%" fill-opacity="0"/></a>
		</svg>
    </nav>
</div>';

  <!-- =========================== -->
<!--#include file="./includes/footer.shtml" -->
</main>
<!-- End of the web page display -->
<!-- ====================== -->
<!-- ++++++++++++++++++++ -->
<!-- Java script section -->
  <!-- jQuery -->
  <script type="text/javascript" id="" src="./js/jquery.min.js"></script>
  <!-- Bootstrap tooltips -->
  <!-- <script type="text/javascript" id="" src="js/popper.min.js"></script> -->
  <!-- Bootstrap core JavaScript -->
  <script type="text/javascript" id="" src="./js/bootstrap.min.js"></script>
  <!-- MDB core JavaScript -->
  <script type="text/javascript" id="" src="./js/mdb.min.js"></script>
  <!-- Your custom scripts (optional) -->
<script src="./js/comicReader.js"></script>
<!-- <script src="./js/vanilla-tilt.js"></script>
<script src="./js/playMP3.js"></script> -->
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
	'<script>window.location.replace("https://syntheticreality.net/Storybook/Yield.php");</script>';
}
?>