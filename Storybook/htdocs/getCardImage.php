<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
// -----------------------
$_SESSION['pageimage'] = 'CARD';
$head1 = <<< EOT1
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Comics Gallery Card Image Upload</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Multiple Image File Uploader">
	<meta name="copyright" content="Copyright 2020 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="web page">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/Storybook/">
	<link href="../CSS/SiteFonts.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="./css/bootstrap.css" rel="stylesheet" type="text/css" media="screen">
    <link href="./css/DT_bootstrap.css" rel="stylesheet" type="text/css" >
	<link href="./css/ComicCreator.css" rel="stylesheet" type="text/css">
	<link href="./css/ComicBuilder.css" rel="stylesheet" type="text/css">
</head>
<body>
	<script src="./js/jquery.min.js"></script>
	<script src="./js/bootstrap.js"></script>
	<script src="./js/jquery.dataTables.js" charset="utf-8"></script>
	<script src="./js/DT_bootstrap.js" charset="utf-8"></script>
	<script src="./js/vpb_uploader.js"></script>
<script>
$(document).ready(function()
{
	// Call the main function
	new vpb_multiple_file_uploader
	({
		vpb_form_id: "form_id", // Form ID
		autoSubmit: true,
		vpb_server_url: "imgUploader.php" 
	});
});
</script>
<main class="pageWrapper" id="container">
<h1 style="color:blue; text-align:center;">Gallery Card Image Selection</h1>
<!-- quick display of info about the upload requirements -->
<div class="msgBox"><h2 style="color:purple;">This page will let you select and upload the <em>Gallery Card Image</em> for the Comic gallery page.</h2></div><br>

<div class="infoBox"><p style="color:purple;"><p>Storybook Comic Builder allows the use of <strong>JPG</strong> or <strong>JPEG</strong>, or <strong>PNG</strong>, or <strong>GIF</strong> (including animated GIFs) image filetypes (case insensitive) for the Gallery Card Image. The image must be in one of these three formats or filetypes and have a valid filename of up to 255 characters. At this time filenames must contain <strong>ONLY</strong> the English alphabetic characters <strong>A</strong> through <strong>Z</strong>, <strong>a</strong> through <strong>z</strong>, and the digits <strong>0</strong> through <strong>9</strong>. Nonalphanumeric or special characters are limited to <em>spaces, underscores, or dashes,</em>.</p>

<p>Storybook Comic Builder will not upload content from another site through a URL; you may only upload image files from your device.</strong> Image files are limited to 5 Megabytes (5 Megabytes = 5,242,880 Bytes) maximum filesize for <strong>JPG</strong> and <strong>PNG</strong> files while <strong>GIF</strong> files are limited to 10 Megabytes (10 Megabytes = 10,485,760 Bytes) maximum filesize. Best results will be obtained with the recommended image pixel dimensions. Note that all metadata content (<em>eg</em> EXIF data) will be removed from uploaded image files.</p></div>
<br>

<div class="msgBox"><p style="color:purple;">The specific image that is needed for the <em>Gallery Card Image</em> should be about 400 to 800 pixels on a side. The selected image will be scaled to fit the Gallery Card.</p></div><br>

<center>
<div class="msgBox">
<form name="form_id" id="form_id" action="javascript:void(0);" enctype="multipart/form-data">
	<label>Select and upload a gallery card image:<br><input type="file" accept=".jpg,.JPG,.gif,.GIF,.png,.PNG" name="vasplus_multiple_files" id="vasplus_multiple_files" multiple>
	<input type="submit" value="Upload Selected File" id="Upload"></label>
</form><br></div>
<br>
<hr class="new4">
<table class="table table-striped table-bordered" id="add_files">
	<thead>
		<tr>
			<th style="color:blue; text-align:center;">File Name</th>
			<th style="color:blue; text-align:center;">Status</th>
			<th style="color:blue; text-align:center;">File Size</th>
			<th style="color:blue; text-align:center;">File Date</th>
			<th style="color:blue; text-align:center;">Action</th>
		<tr>
	</thead>
	<tbody>
	
	</tbody>
</table>
</center>
EOT2;
echo $head2;
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center justify-content-end shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" style="margin-left:0;" id="ComicFooter">'.
	'<nav id="ComicFooter"><p>&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
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
	</svg></span>&nbsp;<a href="mailto:itzbobwright@gmail.com">Bob Wright.</a>&nbsp;Last modified ';
		echo date ("F d Y H:i.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./index.php#pageimage" title="return to configuration settings">Next ❯</a></p></nav>'.
		'</footer>';
$scr = <<< SCR1
      <script>
window.onload = function() {
           $("input[type = 'submit']").click(function(){
               var fileUpload = $("input[type='file']");
               if (parseInt(fileUpload.get(0).files.length) > 1){
                  alert("You are only allowed to upload one Comic gallery card image file!");
				  window.location.replace("https://syntheticreality.net/Storybook/getCardImage.php");
               }
            });
         };
      </script>
</main>
</body>
</html>
SCR1;
echo $scr;
