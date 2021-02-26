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
EOT4;
echo $head4;
if(is_file($Comics.$Comicname.'/'.$Comicname.'BKGND.css')) {
	echo '<link href="./'.$Comicname.'/'.$Comicname.'BKGND.css" media="screen" rel="stylesheet" type="text/css"/>';
} //else {
	//echo '<link href="./css/ComicCreator.css" media="screen" rel="stylesheet" type="text/css"/>';
//}	
$head5 = <<< EOT5
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
</style>
</head>
<!-- End of the HTML head section-->
<!-- =========================== -->
<!-- +++++++++++++++++++++++ -->
<!-- Build out the page -->
<body class="container-fluid main-container d-flex flex-column align-items-top #929fba mdb-color lighten-3">
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
			$capDesc = 'There is an caption text file named '.$captionDir.$captionFile.'.';
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
		$altImgDesc = 'There is an alternate image file named '.$altimgDir.$altimg.'.';
		// check for a filename match and MP3 audio filetype
		if(is_file($altimgDir.$altimgFile.'.mp3')) {
			$altimgmp3 = $altimgFile.'.mp3';}
		$altImgMP3Desc = 'There is an audio alternate image file named '.$altimgDir.$altimgmp3.'.';
	}

	// see if we have alt text for this alt image
	// !!! every image should have an alt text description !!!
	$altImgText = '';
	$altImgTextFile = '';
	if(is_dir($Comics.$Comicname.'/altImgText/')) {
		$altImgTextDir = $Comics.$Comicname.'/altImgText/';
		//$altimgFile = (substr($filename, 0, -4))
		$altimgtextFile = $filenameNoExt.'.txt';
		$pattern = '/\s/';
		$replacement = '';
		$altImgTextFile = $altimgtextFile;
		$altImgTextFile = preg_replace($pattern, $replacement, $altImgTextFile);
		// check for txt file
		if(is_file($altImgTextDir.$altImgTextFile)) {
			$altImgText = (file_get_contents($altImgTextDir.$altImgTextFile));
		$altImgTextDesc = 'There is an alternate image text file named '.$altImgTextDir.$altImgTextFile.'.';}
	}
	}
// we now have a collection of variables for this comic image page
// comment this following info display block out for production
echo
	'<section style="font-size: 2vw;">'.
	'<br>++++++++++++<br>'.
	$FigDesc.'<br>'.
	$altDesc.'<br>'.
	$capDesc.'<br>'.
	$altImgDesc.'<br>'.
	$altImgTextDesc.'<br>'.
	$altImgMP3Desc.'<br>'.
	'</section>';

// next we assemble them into a page to display
// how the page will appear and act will in turn depend on their values
	//}
	next($imageList);
}

$head9 = <<< EOT9
	<!-- +++++++++++++++++++++++ -->
<div class="row justify-content-end fixed-top">
    <button class="col-xs-1 btn btn-md btn-yellow accent1">
      <a id="galleryButton" href="./Comics.html"><svg viewBox="0 0 16 16" class="bi bi-layout-wtf" fill="none" stroke="purple" stroke-linecap="round" stroke-linejoin="round" stroke-width="1" xmlns="http://www.w3.org/2000/svg">
  <path fill-rule="evenodd" d="M5 1H1v8h4V1zM1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1H1zm13 2H9v5h5V2zM9 1a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9zM5 13H3v2h2v-2zm-2-1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1H3zm12-1H9v2h6v-2zm-6-1a1 1 0 0 0-1 1v2a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1H9z"/>
</svg></a>
    </button>
</div>
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