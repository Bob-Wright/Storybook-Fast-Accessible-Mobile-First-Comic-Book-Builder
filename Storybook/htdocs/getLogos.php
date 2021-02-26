<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
// -----------------------
$_SESSION['pageimage'] = 'LOGO';
$_SESSION['logoCount'] = 0;
if(isset($_SESSION['Comicname'])) {
	$Comicname = $_SESSION['Comicname'];
	if(file_exists('../Images/'.$Comicname.'.LL')) {
		unlink('../Images/'.$Comicname.'.LL'); }
}
$head1 = <<< EOT1
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Site Logo Images Upload</title>
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
	<link href="../CSS/materialdesignicons.css" media="screen" rel="stylesheet" type="text/css"/>
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
<h1 style="color:blue; text-align:center;">Site Logo Images Upload</h1>
<!-- quick display of info about the upload requirements -->
<div class="msgBox"><h2 style="color:purple;">This page will let you select and upload up to eight <em>Site Logo</em> images which will be shown in the page header.</h2></div><br>

<div class="infoBox"><p>Storybook Comic Builder allows the use of <strong>JPG</strong> or <strong>JPEG,</strong> and <strong>PNG</strong> image filetypes (case insensitive) for the three categories of page images outside of the Comic images themselves, such as the page background and the OG Meta tag images as well as the site logo images. You may prefer to use <strong>GIF</strong> images, including animated GIFs, for the site logo images instead of PNG or JPG images. However, all images must be in one of these three formats or filetypes and have a valid filename of up to 255 characters. At this time filenames must contain <strong>ONLY</strong> the English alphabetic characters <strong>A</strong> through <strong>Z</strong>, <strong>a</strong> through <strong>z</strong>, and the digits <strong>0</strong> through <strong>9</strong>.  Nonalphanumeric or special characters are limited to <em>spaces, underscores, dashes,</em> or <em>periods</em> and a few others as normal filename use allows.</p>

<p>Storybook Comic Builder will not upload content from another site through a URL; you may only upload image files from your device.</strong> Image files are limited to 5 Megabytes (5 Megabytes = 5,242,880 Bytes) maximum filesize for <strong>JPG</strong> and <strong>PNG</strong> files while <strong>GIF</strong> files are limited to 2 Megabytes (2 Megabytes = 2,097,152 Bytes) maximum filesize. Best results will be obtained with the recommended image pixel dimensions. Note that all metadata content (<em>eg</em> EXIF data) will be removed from uploaded image files.</p></div>
<br>

<div class="infoBox"><p>The specific images that are needed for the <em>Site Logo</em> are small images that will be displayed as the Site Logo images in the upper left page corner inside the page header. Each of these images should be about 200 pixels on a side. You may choose up to 8 logo images to display.
<br>
<br>For the images that are chosen, the logo images are cycled through on mouse clicks. The first image appears until it is clicked, then the second image appears. If the second image is clicked then the third image appears and so forth. Once the final image is clicked, the cycle repeats. If the logo image is an animation loop it will change at the end of the current loop, so there may be a delay before the next animation displays.
<br>
<br>If only one logo image is chosen, then it will be the only logo image displayed and will not change on a click.</p></div>
<br>

<div class="infoBox">
<form name="form_id" id="form_id" action="javascript:void(0);" enctype="multipart/form-data">
	<input type="file" accept=".jpg,.JPG,.gif,.GIF,.png,.PNG" name="vasplus_multiple_files" id="vasplus_multiple_files" multiple>
	<input type="submit" value="Upload Selected Files" id="Upload">
</form></div>
<br>
<hr class="new4">
EOT2;
echo $head2;
?>
      <script>
         $(function(){
            $("input[type = 'submit']").click(function(){
               var $fileUpload = $("input[type='file']");
               if (parseInt($fileUpload.get(0).files.length) > 8){
                  alert("You are allowed to upload a maximum of 8 logo image files");
				  window.location.replace("https://syntheticreality.net/ComicBuilder/getLogos.php");
               } 
            });
         });
      </script>
<center>

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

<div id="ComicFooter"><a id="prevpagebutton" href="getComicCaptions.php">❮ Previous</a>&emsp;Design and Contents &copy; 2019 by&nbsp;<span class="mdi mdi-email"></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified <?php echo date ("F d Y H:i:s.", getlastmod()) ?>&emsp;<a id="nextpagebutton" href="getBkgnd.php">Next ❯</a></div>	
</main>
</body>
</html>