<?php
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
// -----------------------
	
$head1 = <<< EOT1
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Fonts Chooser</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
	<meta NAME="Last-Modified" content="
EOT1;
echo $head1;
echo date ("F d Y H:i:s.", getlastmod()).'">';
$head2 = <<< EOT2
	<meta name="description" content="Font Selector">
	<meta name="copyright" content="Copyright 2021 by IsoBlock.com">
	<meta name="author" content="Bob Wright">
	<meta name="keywords" content="web page">
	<meta name="rating" content="general">
	<meta name="robots" content="index, follow"> 
	<base href="https://syntheticreality.net/Storybook/">
	<link href="./css/bootstrap.css" rel="stylesheet" media="screen">
	<link rel="stylesheet" href="./css/mdb.min.css">
<link rel='stylesheet' href="./css/colorPalette.css">
<link rel='stylesheet' href="./css/textColorPalette.css">
<link rel='stylesheet' href="./css/LiteThemes.css">
	<link href="./css/ComicCreator.css" rel="stylesheet">
	<link href="./css/ComicBuilder.css" rel="stylesheet">
</head>
<body>
<style>
.fcheckbox {
  color: #808080;
  height: 1.5vw;
  width: 1.5vw;
  padding: 1vw 1vw;
  cursor: pointer;
    outline: .2vw solid black;
}
EOT2;
echo $head2;
// list of fonts
$fontdir = '/home/bitnami/Comics/htdocs/Fonts/';
$fontfiles = array();
$fontlabels = '';
if ($handle = opendir($fontdir)) {
    //echo "Directory handle: $handle\n";
    //echo "Entries:\n";
    /* loop over the directory. */
	while (false !== ($entry = readdir($handle))) {
		if(!(is_dir($fontdir.$entry))) {
			$filenameArray = explode('.', $entry);
			// check the filetype/extension for TTF files
			if (preg_match('/ttf/i', $filenameArray[1])) {
				$fontfiles[] = $filenameArray[0];}
		}
	}
	sort($fontfiles);
	closedir($handle);
}

for ($i = 0; $i <  count($fontfiles); $i++) {
	$fontIndex=key($fontfiles);
	$fontfile=$fontfiles[$fontIndex];
		echo
		'@font-face {'.
		'font-family: "'.$fontfile.'";'.
		'src: url("./Fonts/'.$fontfile.'.ttf") format("truetype");}'.
		'.'.$fontfile.' { font: 2vw '.$fontfile.';}';
		$fontlabels .= '<div style="margin-left: 2vw;"><label class="'.$fontfile.'"><input id="h'.$fontfile.'" class="fcheckbox" type="checkbox" name="Headings" /><span style="margin-left: 3vw;">'.$fontfile.'</span></label><label style="position: absolute;left: 37vw;" class="'.$fontfile.'"><input id="p'.$fontfile.'" class="fcheckbox" type="checkbox" name="Bodytext" /></label></div>';
	next($fontfiles);
}
	
$head2a = <<< EOT2a
</style>
<script src="./js/jquery.min.js"></script>
	<script src="./js/bootstrap.js"></script>
<main class="pageWrapper" id="container">
<h1 style="color:blue; text-align:center;">Choose Comic Caption Fonts</h1>
<!-- quick display of info -->
<h2 style="color:purple; text-align:center;">This page will let you select heading and body fonts for captions.<br>If no font is selected the default choices will be applied.</h2>
<div class="msgBox"><!-- headings font choice -->
<div style="opacity: 0;" class="card col-sm-12 #929fba mdb-color lighten-3 px-sm-0"><br></div>
<div class="card col-sm-11 d-flex flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">
<div class="card-body"><h2 style="color:red;">You may choose ONE optional Heading Font and ONE optional Paragraph Font:</h2></div></div>
<div style="opacity: 0;" class="card col-sm-12 #929fba mdb-color lighten-3 px-sm-0"><br></div>
<h3 style="color:red;">Heading<span style="position: absolute;left: 37vw;">Paragraph</span></h3>
EOT2a;
echo $head2a;
/* =============== */
	echo $fontlabels;

$colrs = <<< EOT3
<div class="card col-sm-11 d-flex flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">
<div class="card-body"><h2>Choose a caption background color</h2></div></div>
<div style="opacity: 0;" class="card col-sm-12 #929fba mdb-color lighten-3 px-sm-0"><br></div>
   <div class="row mx-1 d-flex col-sm-11">
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 danger-color-lite #ef9a9a">
                <label style="margin-left: 1vw;"><p><br><input id="danger-color-lite #ef9a9a" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#ef9a9a</label></p></label></div>
             <div class="color-block z-depth-2 warning-color-lite #ffcc80">
                <label style="margin-left: 1vw;"><p><br><input id="warning-color-lite #ffcc80" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#ffcc80</p></label></div>
             <div class="color-block z-depth-2 yellow-color-lite #fff59d">
                <label style="margin-left: 1vw;"><p><br><input id="yellow-color-lite #fff59d" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#fff59d</p></label></div>
         </div>
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 success-color-lite #a5d6a7">
                <label style="margin-left: 1vw;"><p><br><input id="success-color-lite #a5d6a7" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#a5d6a7</p></label></div>
             <div class="color-block z-depth-2 default-color-lite #80cbc4">
                <label style="margin-left: 1vw;"><p><br><input id="default-color-lite #80cbc4" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#80cbc4</p></label></div>
             <div class="color-block z-depth-2 info-color-lite #81d4fa">
                <label style="margin-left: 1vw;"><p><br><input id="info-color-lite #81d4fa" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#81d4fa</p></label></div>
         </div>
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 primary-color-lite #90caf9">
                <label style="margin-left: 1vw;"><p><br><input id="primary-color-lite #90caf9" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#90caf9</p></label></div>
             <div class="color-block z-depth-2 myindigo-color-lite #9fa8da">
                <label style="margin-left: 1vw;"><p><br><input id="myindigo-color-lite #9fa8da" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#9fa8da</p></label></div>
             <div class="color-block z-depth-2 purple-color-lite #b39ddbG">
                <label style="margin-left: 1vw;"><p><br><input id="purple-color-lite #b39ddbG" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#b39ddb</p></label></div>
         </div>
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 secondary-color-lite #ce93d8">
                <label style="margin-left: 1vw;"><p><br><input id="secondary-color-lite #ce93d8" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#ce93d8</p></label></div>
             <div class="color-block z-depth-2 GRAY25 #c0c0c0">
                <label style="margin-left: 1vw;"><p><br><input id="GRAY25 #c0c0c0" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#c0c0c0</p></label></div>
             <div class="color-block z-depth-2 blue-grey #b0bec5 lighten-3">
                <label style="margin-left: 1vw;"><p><br><input id="blue-grey #b0bec5 lighten-3" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#b0bec5</p></label></div>
         </div>
    </div>
   <div class="row mx-1 d-flex col-sm-11">
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 lite-stylish-color-lite #8B919D">
                <label style="margin-left: 1vw;"><p><br><input id="lite-stylish-color-lite #8B919D" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#8B919D</p></label></div>
             <div class="color-block z-depth-2 lite-unique-color-lite #7FB2DB">
                <label style="margin-left: 1vw;"><p><br><input id="lite-unique-color-lite #7FB2DB" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#7FB2DB</p></label></div>
             <div class="color-block z-depth-2 lite-special-color-lite #77878F">
                <label style="margin-left: 1vw;"><p><br><input id="lite-special-color-lite #77878F" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#77878F</p></label></div>
         </div>
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 lite-stylish-color-lite-R #AB919D">
                <label style="margin-left: 1vw;"><p><br><input id="lite-stylish-color-lite-R #AB919D" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#AB919D</p></label></div>
             <div class="color-block z-depth-2 lite-unique-color-lite-R #9FB2DB">
                <label style="margin-left: 1vw;"><p><br><input id="lite-unique-color-lite-R #9FB2DB" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#9FB2DB</p></label></div>
             <div class="color-block z-depth-2 lite-special-color-lite-R #97878F">
                <label style="margin-left: 1vw;"><p><br><input id="lite-special-color-lite-R #97878F" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#97878F</p></label></div>
         </div>
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 lite-stylish-color-lite-G #8BB19D">
                <label style="margin-left: 1vw;"><p><br><input id="lite-stylish-color-lite-G #8BB19D" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#8BB19D</p></label></div>
             <div class="color-block z-depth-2 lite-unique-color-lite-G #7FD2DB">
                <label style="margin-left: 1vw;"><p><br><input id="lite-unique-color-lite-G #7FD2DB" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#7FD2DB</p></label></div>
             <div class="color-block z-depth-2 lite-special-color-lite-G #77A78F">
                <label style="margin-left: 1vw;"><p><br><input id="lite-special-color-lite-G #77A78F" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#77A78F</p></label></div>
         </div>
        <div class="col-md-3 mb-4">
            <div class="color-block z-depth-2 lite-stylish-color-lite-B #8B91BD">
                <label style="margin-left: 1vw;"><p><br><input id="lite-stylish-color-lite-B #8B91BD" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#8B91BD</p></label></div>
             <div class="color-block z-depth-2 lite-unique-color-lite-B #7FB2FB">
                <label style="margin-left: 1vw;"><p><br><input id="lite-unique-color-lite-B #7FB2FB" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#7FB2FB</p></label></div>
             <div class="color-block z-depth-2 lite-special-color-lite-B #7787AF">
                <label style="margin-left: 1vw;"><p><br><input id="lite-special-color-lite-B #7787AF" class="fcheckbox" type="checkbox" name="Capcolor" /> &emsp;#7787AF</p></label></div>
         </div>
    </div>
EOT3;
echo $colrs;
?>
<form class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" name="hfontinfo" action="saveFonts.php" method="post" enctype="text">
<label>Heading Font CSS:<br><textarea id="hfontval" name="hfontinfo" rows="4" cols="64"></textarea></label>
<label>Paragraph Font CSS:<br><textarea id="pfontval" name="pfontinfo" rows="4" cols="64"></textarea></label>
<label>Caption Background MDB Class:<br><textarea id="cbval" name="cbinfo" rows="2" cols="64"></textarea></label>
<br>
<style id="cbval"></style>
<div  id="xmplcbox" class="d-flex col-sm-11 flex-column align-items-center shadow-md px-sm-0 msgBox">
<style id="xmplhdgs"></style>
<style id="xmplbody"></style>
<h1 class="xmplh">THIS IS AN Example TOP LEVEL Heading</h1>
<h2 class="xmplh">This is an EXAMPLE second level HEADING</h2>
<h3 class="xmplh">This is an example THIRD LEVEL HEADING</h3>
<br>
<p class="xmplp mx-3">This is an example of the paragraph text font being used in paragraph text. It's a short and saucy paragraph that has no existential meaning. Or does it?<br><br>This is an <b><i>example</i></b> of the paragraph text font being used with <b>Boldface</b> and <i>italics</i> in paragraph text. It's a short and saucy paragraph that has existential meaning because of the <i>text embellishments</i>. Or does it?</p></div>
<br><input type="submit" value="Apply">
</form><br>
</div>
	<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" style="margin-left:0;" id="ComicFooter">
	<nav id="ComicFooter"><p><a id="prevpagebutton" href="./getComicCaptions.php" title="return to the get captions page">❮ Previous</a>&nbsp;&copy; 2021 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
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
	-51z"/>&emsp;font</label>
	</g>
	</svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified&ensp;<?php echo date ("F d Y H:i:s.", getlastmod()) ?>&ensp;<a id="nextpagebutton" href="./getOGImg.php" title="go to the OG Img chooser">Next ❯</a></p></nav>
	</footer>
  <script type="text/javascript" src="./js/jquery.min.js"></script>
  <script type="text/javascript" src="./js/bootstrap.min.js"></script>
  <script type="text/javascript" src="./js/mdb.min.js"></script>
<script>
var $defhfont = 'Roboto-Bold';
var $defpfont = 'Merriweather-Regular';
var $defccolr = 'blue-grey #b0bec5 lighten-3';
$("#hfontval").html('@font-face {font-family: "'+$defhfont+'"; src: url("./Fonts/'+$defhfont+'.ttf") format("truetype");} .card-body h1 { font: 2vw '+$defhfont+';} .card-body h2 { font: 1.75vw '+$defhfont+';} .card-body h3 { font: 1.5vw '+$defhfont+';}');
$("#pfontval").html('@font-face {font-family: "'+$defpfont+'"; src: url("./Fonts/'+$defpfont+'.ttf") format("truetype");} .card-body, .card-body p { font: 1.5vw '+$defpfont+';} ');
$("#cbval").html('d-flex col-sm-11 flex-column align-items-center shadow-md px-sm-0 msgBox ' + $defccolr);
$("#xmplhdgs").html('@font-face {font-family: "'+$defhfont+'"; src: url("./Fonts/'+$defhfont+'.ttf") format("truetype");} h1.xmplh { font: 2vw '+$defhfont+';} h2.xmplh { font: 1.75vw '+$defhfont+';} h3.xmplh { font: 1.5vw '+$defhfont+';}');
$("#xmplbody").html('@font-face {font-family: "'+$defpfont+'"; src: url("./Fonts/'+$defpfont+'.ttf") format("truetype");} p.xmplp { font: 1.5vw '+$defpfont+';}');
document.getElementById("xmplcbox").className = "d-flex col-sm-11 flex-column align-items-center shadow-md px-sm-0 msgBox "+$defccolr+"" ;
$('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
	console.info(this.checked +" "+ this.id +" "+ this.name);
var $id = this.id;
	if(this.name == "Headings") {
	var $id = $id.substring(1);
	if(this.checked == true) {
		$("#hfontval").html('@font-face {font-family: "'+$id+'"; src: url("./Fonts/'+$id+'.ttf") format("truetype");} .card-body h1 { font: 2vw '+$id+';} .card-body h2 { font: 1.75vw '+$id+';} .card-body h3 { font: 1.5vw '+$id+';}');
		$("#xmplhdgs").html('@font-face {font-family: "'+$id+'"; src: url("./Fonts/'+$id+'.ttf") format("truetype");} h1.xmplh { font: 2vw '+$id+';} h2.xmplh { font: 1.75vw '+$id+';} h3.xmplh { font: 1.5vw '+$id+';}');
	} else {
		//$("#hfontval").html('');
		$("#hfontval").html('@font-face {font-family: "'+$defhfont+'"; src: url("./Fonts/'+$defhfont+'.ttf") format("truetype");} .card-body h1 { font: 2vw '+$defhfont+';} .card-body h2 { font: 1.75vw '+$defhfont+';} .card-body h3 { font: 1.5vw '+$defhfont+';}');
		$("#xmplhdgs").html('@font-face {font-family: "'+$defhfont+'"; src: url("./Fonts/'+$defhfont+'.ttf") format("truetype");} h1.xmplh { font: 2vw '+$defhfont+';} h2.xmplh { font: 1.75vw '+$defhfont+';} h3.xmplh { font: 1.5vw '+$defhfont+';}');
	}}
	if(this.name == "Bodytext") {
	var $id = $id.substring(1);
	if(this.checked == true) {
		$("#pfontval").html('@font-face {font-family: "'+$id+'"; src: url("./Fonts/'+$id+'.ttf") format("truetype");} .card-body p { font: 2vw '+$id+';} ');
		$("#xmplbody").html('@font-face {font-family: "'+$id+'"; src: url("./Fonts/'+$id+'.ttf") format("truetype");} p.xmplp { font: 1.5vw '+$id+';}');
		} else {
		$("#pfontval").html('@font-face {font-family: "'+$defpfont+'"; src: url("./Fonts/'+$defpfont+'.ttf") format("truetype");} .card-body p { font: 1.5vw '+$defpfont+';} ');
		$("#xmplbody").html('@font-face {font-family: "'+$defpfont+'"; src: url("./Fonts/'+$defpfont+'.ttf") format("truetype");} p.xmplp { font: 1.5vw '+$defpfont+';}');
	}}
	if(this.name == "Capcolor") {
	if(this.checked == true) {
		document.getElementById("xmplcbox").className = "d-flex col-sm-11 flex-column align-items-center shadow-md px-sm-0 msgBox "+$id+"" ;
		$("#cbval").html('d-flex col-sm-11 flex-column align-items-center shadow-md px-sm-0 msgBox ' + $id);
	} else {
		document.getElementById("xmplcbox").className = "d-flex col-sm-11 flex-column align-items-center shadow-md px-sm-0 msgBox "+$defccolr+"" ;
		$("#cbval").html('d-flex col-sm-11 flex-column align-items-center shadow-md px-sm-0 msgBox ' + $defccolr);
	}}
});
</script>
</main>
</body>
</html>
