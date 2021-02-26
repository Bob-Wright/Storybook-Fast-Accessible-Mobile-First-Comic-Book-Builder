<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
$_SESSION['pageimage'] = 'OGIMG';

$head1 = <<< EOT1
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>OG Meta Tag Image</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Multiple Image File Uploader">
	<meta name="copyright" content="Copyright 2019 by IsoBlock.com">
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
<h1 style="color:blue; text-align:center;">OG Meta Tag Data Upload</h1>
EOT2;
echo $head2;
// -----------------------
if(isset($_SESSION['siteurl']) && ($_SESSION['siteurl'] === "./")) {
	echo 	'<center><div class="msgBox"><h2 style="color:purple;">An <em>OG Image</em> is not used with a relative URL like <strong>./</strong></h2></div><br></center>'.
			'</main>'.
'<div id="ComicFooter"><a id="prevpagebutton" href="getBkgnd.php">❮ Previous</a>&emsp;&copy; 2019 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@syntheticreality.net">Bob Wright.</a>&nbsp;Last modified <!--#echo var="LAST_MODIFIED" -->&emsp;<a id="nextpagebutton" href="Yield.php">Create&nbsp;Page ❯</a></div>'.
			'</body>'.
			'</html>';
	exit;
}
$head3= <<< EOT3
<!-- quick display of info about the upload requirements -->
<div class="msgBox"><h2 style="color:purple;">This page will let you select and upload the <em>OG Image</em> for the Comic page.</h2>
<h3><strong>The <em>OG Meta Tags Image</em> will be displayed in the post or link if the Comic page is shared to Facebook.</strong></h3></div><br>

<div class="infoBox"><p>Storybook Comic Builder allows only the use of <b>PNG</b> or <b>JPG</b> image filetypes (case insensitive) for the OG Meta tag image. The OG image must be a valid filetype and have a valid filename of up to 255 characters. At this time filenames must contain <b>ONLY</b> the English alphabetic characters <b>A</b> through <b>Z</b>, <b>a</b> through <b>z</b>, and the digits <b>0</b> through <b>9</b>.  Nonalphanumeric or special characters are limited to <em>spaces, underscores, dashes,</em> or <em>periods</em> and a few others as normal filename use allows.</p>

<p>Storybook Comic Builder will not upload content from another site through a URL; you may only upload image files from your device.</b> Image files are limited to 5 Megabytes (5 Megabytes = 5,242,880 Bytes) maximum filesize for <b>PNG</b> or <b>JPG</b> files. Note that all metadata content (<em>eg</em> EXIF data) will be removed from uploaded image files.</p></div>
<br>

<div class="msgBox"><p>A specific image size is required for the <em>OG Meta Tags Image</em> that will be displayed in the Post or Link if the Comic page is shared to Facebook. The selected image <b>must be 1800 pixels wide by 960 pixels in height</b>. At this time Storybook Comic Builder will not transform or scale your provided image.</p></div>
<br>

<center>
<div class="msgBox">
<form name="form_id" id="form_id" action="javascript:void(0);" enctype="multipart/form-data">
	<label>Select and Upload an OG Image for the Comic:<br><input type="file" accept=".png,.PNG,.jpg,.JPG" name="vasplus_multiple_files" id="vasplus_multiple_files" multiple>
	<input type="submit" value="Upload Selected File" id="Upload"></label>
</form>
<br></div>
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
EOT3;
echo $head3;
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" style="margin-left:0;" id="ComicFooter">'.
	'<nav id="ComicFooter"><p><a id="prevpagebutton" href="./getComicCaptions.php" title="return to uploading Comic Captions">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
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
		echo date ("F d Y H:i:s.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./Yield.php" title="create the comic">Next ❯</a></p></nav>'.
		'</footer>';
?>
      <script>
         $(function(){
            $("input[type = 'submit']").click(function(){
               var $fileUpload = $("input[type='file']");
               if (parseInt($fileUpload.get(0).files.length) > 1){
                  alert("You are allowed to upload one OG image file");
				  window.location.replace("https://syntheticreality.net/ComicBuilder/getOGImg.php");
               } 
            });
         });
      </script>
</main>
</body>
</html>