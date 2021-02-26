<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
// -----------------------
	
$_SESSION['pageimage'] = 'altText';
$head1 = <<< EOT1
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Comic Images Alt Text Upload</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" CONTENT="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Multiple Text File Uploader">
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
		vpb_server_url: "txtUploader.php" 
	});
});
</script>
<main class="pageWrapper" id="container">
<h1 style="color:blue; text-align:center;">Comic Image Alt Text Files Upload</h1>
<!-- quick display of info about the upload requirements -->
<div class="msgBox"><h2 style="color:purple;">This page will let you select and upload alternate or "alt" text for each of the page images included in the Comic.</h2>
<h3 style="color: #ff0040;">In order for Storybook Comic Builder to include alt text with a Comic image, a text file must be uploaded for each image. The alt text filename must match the associated image filename.</h3></div><br>
<div class="infoBox"><p>Storybook Comic Builder suggests the inclusion of <em>alt text</em> for the images displayed in a Comic. Including this alternate text helps to provide information about the images to the audience, and greatly improves accessibility. Text content is also important for <em>SEO</em> or Search Engine Optimization. The best alt text for search engines and viewers alike provides meaningful content about the associated image.</p>
<p>Storybook Comic Builder allows the inclusion of the <b>TXT</b> filetype (case insensitive) for use as alt text in the Comic. Uploaded ALT text files must be in plain text format and have a valid filename of up to 255 characters. You must provide one ALT text file for each image and its filename must match the image filename. As an example, the ALT text file <em>examplefile.txt</em> would be associated with the image file <em>examplefile.jpg</em>. At this time filenames must contain <b>ONLY</b> the English alphabetic characters <b>A</b> through <b>Z</b>, <b>a</b> through <b>z</b>, and the digits <b>0</b> through <b>9</b>.  Nonalphanumeric or special characters are limited to <em>spaces, underscores, dashes,</em> or <em>periods</em> and a few others as normal filename use allows.</p>
<p>Storybook Comic Builder will not upload content located on another site by a URL; you may only upload text files from your device.</b> The Alternate text files are limited to 256 characters maximum length, however, most screen readers cut the Alt text off at 125 characters. Therefore Storybook suggests using a length of perhaps 100 characters or less and only using longer descriptions for complex images or animations. At this time the text files may contain <b>ONLY</b> the English alphabetic characters <b>A</b> through <b>Z</b>, <b>a</b> through <b>z</b>, and the digits <b>0</b> through <b>9</b>. Most of the common punctuation and symbol characters are allowed within the text, including <b>! @ # $ % ^ & * ( ) _ + { } | : " ? - = [ ] \ ; ' , . / ~ `</b>.</p></div>
<br>
<center>
<div class="infoBox">
<form name="form_id" id="form_id" action="javascript:void(0);" enctype="multipart/form-data">
	<label>Select and upload the Comic Image Alt text files:<br><input type="file" accept=".txt,.TXT" name="vasplus_multiple_files" id="vasplus_multiple_files" multiple="multiple">
	<input type="submit" value="Upload Selected Files" id="Upload"></label>
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
EOT2;
echo $head2;
	echo
	'<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" style="margin-left:0;" id="ComicFooter">'.
	'<nav id="ComicFooter"><p><a id="prevpagebutton" href="./getComic.php" title="return to uploading comic page images">❮ Previous</a>&emsp;&copy; 2020 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
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
		echo date ("F d Y H:i:s.", getlastmod()).'&emsp;<a id="nextpagebutton" href="./getAltImg.php" title="get optional alt image for each image">Next ❯</a></p></nav>'.
		'</footer>';
?>
      <script>
         $(function(){
            $("input[type = 'submit']").click(function(){
               var $fileUpload = $("input[type='file']");
               if (parseInt($fileUpload.get(0).files.length) > 24){
                  alert("You are only allowed to upload 24 Comic image alt text files!");
				  window.location.replace("https://syntheticreality.net/Storybook/getAltText.php");
               } 
            });
         });
      </script>
</main>
</body>
</html>
