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
	<!-- <link href="./css/bootstrap.css" rel="stylesheet" media="screen"> -->
	<link rel="stylesheet" href="./css/mdb.min.css">
<!-- <link rel='stylesheet' href="./css/colorPalette.css">
<link rel='stylesheet' href="./css/textColorPalette.css">
<link rel='stylesheet' href="./css/LiteThemes.css"> -->
	<link href="./css/SiteFonts.css" media="screen" rel="stylesheet" type="text/css"/>
	<link href="./css/ComicCreator.css" rel="stylesheet">
	<link href="./css/ComicBuilder.css" rel="stylesheet">
  <!-- <script type="text/javascript" src="./js/bootstrap.min.js"></script> -->
  <script type="text/javascript" src="./js/mdb.min.js"></script>
  <script type="text/javascript" src="./js/jquery.min.js"></script>
	<link rel="icon" href="../favicon.ico" type="image/ico">
	<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
</head>
<body>
<style>
.fcheckbox {
  height: 1.5vw;
  width: 1.5vw;
  padding: 1vw 1vw;
  cursor: pointer;
    outline: .2vw solid black;
}
.fcheckbox:focus {
  height: 1.75vw;
  width: 1.75vw;
	outline: .5vw solid #b22242;
}
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
.navtoc {width: 15vw; padding-right: .5vw; margin-right: 2vw; border: .4vw solid #b22222; background-color: #b0bec5;}
div.navtoc p {color: #005a9c; padding: 0.25vw; margin: 0; font-weight: bold}

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
				if($filenameArray[0] == 'MaterialIcons-Regular') {continue;}
				if($filenameArray[0] == 'materialdesignicons-webfont') {continue;}
				$fontfiles[] = $filenameArray[0];
			}
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
		$fontlabels .= '<div style="margin-left: 2vw;"><label class="'.$fontfile.'"><input id="h'.$fontfile.'" class="fcheckbox" type="checkbox" name="Headings" /><span style="margin-left: 3vw; color: DarkBlue;">'.$fontfile.'</span></label><label style="position: absolute;left: 45vw;" class="'.$fontfile.'"><input id="p'.$fontfile.'" class="fcheckbox" type="checkbox" name="Bodytext" /></label></div>';
	next($fontfiles);
}
$head2a = <<< EOT2a
</style>
<main class="pageWrapper" id="container">
<nav class="row justify-content-end fixed-top"><div class="navtoc px-sm-0"><p>On this page:</p><ul id="navbar"><li><a href="comicFonts.php#fontFamily">Choose Font</a></li><li><a href="comicFonts.php#backgroundColor">Background</a></li><li><a href="comicFonts.php#fontColor">Font Color</a></li><li><a href="comicFonts.php#saveChoices">Save Choices</a></li></ul></div></nav>
<h1 class="col col-sm-10 px-sm-0" style="color:blue; text-align:center;">Comic Caption Options</h1>
<!-- quick display of info -->
<h2 class="col col-sm-10" style="color:purple; text-align:center; padding: 1vw;">This page will let you select heading and body fonts and font color and background colors for captions.<br>If no font is selected the default choices will be applied.</h2>
<div class="msgBox"><!-- headings font choice -->
<div style="opacity: 0;" class="card col-sm-12 #929fba mdb-color lighten-3 px-sm-0"><br></div>
<div class="card col-sm-11 d-flex flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">
<div class="card-body"><h2 style="color:red;">Choose ONE optional Heading Font and ONE optional Paragraph Font:</h2></div></div>
<div style="opacity: 0;" class="card col-sm-12 #929fba mdb-color lighten-3 px-sm-0"><br></div>
<h3 id="fontFamily" style="color:red;">Heading<span style="position: absolute;left: 45vw;">Paragraph</span></h3>
EOT2a;
echo $head2a;
/* =============== */
	echo $fontlabels;

$colrs = <<< EOT3
<div class="card col-sm-11 d-flex flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">
<div id="backgroundColor" class="card-body"><h2>Choose a caption background color</h2></div></div>
<div style="opacity: 0;" class="card col-sm-12 #929fba mdb-color lighten-3 px-sm-0"><br></div>
<div class="row mx-1 d-flex col-sm-12">
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: AliceBlue; color: black;" id="#F0F8FF"><label style="margin-left: 1vw;"><p><br><input id="id#F0F8FF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;AliceBlue<br>#F0F8FF</p></label></div>
<div class="color-block z-depth-2" style="background-color: AntiqueWhite; color: black;" id="#FAEBD7"><label style="margin-left: 1vw;"><p><br><input id="id#FAEBD7" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;AntiqueWhite<br>#FAEBD7</p></label></div>
<div class="color-block z-depth-2" style="background-color: Aqua; color: black;" id="#00FFFF"><label style="margin-left: 1vw;"><p><br><input id="id#00FFFF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Aqua<br>#00FFFF</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Aquamarine; color: black;" id="#7FFFD4"><label style="margin-left: 1vw;"><p><br><input id="id#7FFFD4" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Aquamarine<br>#7FFFD4</p></label></div>
<div class="color-block z-depth-2" style="background-color: Azure; color: black;" id="#F0FFFF"><label style="margin-left: 1vw;"><p><br><input id="id#F0FFFF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Azure<br>#F0FFFF</p></label></div>
<div class="color-block z-depth-2" style="background-color: Beige; color: black;" id="#F5F5DC"><label style="margin-left: 1vw;"><p><br><input id="id#F5F5DC" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Beige<br>#F5F5DC</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Bisque; color: black;" id="#FFE4C4"><label style="margin-left: 1vw;"><p><br><input id="id#FFE4C4" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Bisque<br>#FFE4C4</p></label></div>
<div class="color-block z-depth-2" style="background-color: Black; color: white;" id="#000000">
<label style="margin-left: 1vw;"><p><br><input id="id#000000" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Black<br>#000000</p></label></div>
<div class="color-block z-depth-2" style="background-color: BlanchedAlmond; color: black;" id="#FFEBCD"><label style="margin-left: 1vw;"><p><br><input id="id#FFEBCD" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;BlanchedAlmond<br>#FFEBCD</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Blue; color: white;" id="#0000FF">
<label style="margin-left: 1vw;"><p><br><input id="id#0000FF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Blue<br>#0000FF</p></label></div>
<div class="color-block z-depth-2" style="background-color: BlueViolet; color: white;" id="#8A2BE2"><label style="margin-left: 1vw;"><p><br><input id="id#8A2BE2" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;BlueViolet<br>#8A2BE2</p></label></div>
<div class="color-block z-depth-2" style="background-color: Brown; color: white;" id="#A52A2A"><label style="margin-left: 1vw;"><p><br><input id="id#A52A2A" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Brown<br>#A52A2A</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: BurlyWood; color: black;" id="#DEB887"><label style="margin-left: 1vw;"><p><br><input id="id#DEB887" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;BurlyWood<br>#DEB887</p></label></div>
<div class="color-block z-depth-2" style="background-color: CadetBlue; color: black;" id="#5F9EA0"><label style="margin-left: 1vw;"><p><br><input id="id#5F9EA0" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;CadetBlue<br>#5F9EA0</p></label></div>
<div class="color-block z-depth-2" style="background-color: Chartreuse; color: black;" id="#7FFF00"><label style="margin-left: 1vw;"><p><br><input id="id#7FFF00" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Chartreuse<br>#7FFF00</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Chocolate; color: black;" id="#D2691E"><label style="margin-left: 1vw;"><p><br><input id="id#D2691E" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Chocolate<br>#D2691E</p></label></div>
<div class="color-block z-depth-2" style="background-color: Coral; color: black;" id="#FF7F50"><label style="margin-left: 1vw;"><p><br><input id="id#FF7F50" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Coral<br>#FF7F50</p></label></div>
<div class="color-block z-depth-2" style="background-color: CornflowerBlue; color: black;" id="#6495ED"><label style="margin-left: 1vw;"><p><br><input id="id#6495ED" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;CornflowerBlue<br>#6495ED</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Cornsilk; color: black;" id="#FFF8DC"><label style="margin-left: 1vw;"><p><br><input id="id#FFF8DC" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Cornsilk<br>#FFF8DC</p></label></div>
<div class="color-block z-depth-2" style="background-color: Crimson; color: white;" id="#DC143C"><label style="margin-left: 1vw;"><p><br><input id="id#DC143C" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Crimson<br>#DC143C</p></label></div>
<div class="color-block z-depth-2" style="background-color: Cyan; color: black;" id="#00FFFF"><label style="margin-left: 1vw;"><p><br><input id="id#00FFFF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Cyan<br>#00FFFF</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: DarkBlue; color: white;" id="#00008B"><label style="margin-left: 1vw;"><p><br><input id="id#00008B" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkBlue<br>#00008B</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkCyan; color: white;" id="#008B8B"><label style="margin-left: 1vw;"><p><br><input id="id#008B8B" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkCyan<br>#008B8B</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkGoldenRod; color: black;" id="#B8860B"><label style="margin-left: 1vw;"><p><br><input id="id#B8860B" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkGoldenRod<br>#B8860B</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: DarkGray; color: black;" id="#A9A9A9"><label style="margin-left: 1vw;"><p><br><input id="id#A9A9A9" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkGray<br>#A9A9A9</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkGreen; color: white;" id="#006400"><label style="margin-left: 1vw;"><p><br><input id="id#006400" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkGreen<br>#006400</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkKhaki; color: black;" id="#BDB76B"><label style="margin-left: 1vw;"><p><br><input id="id#BDB76B" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkKhaki<br>#BDB76B</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: DarkMagenta; color: white;" id="#8B008B"><label style="margin-left: 1vw;"><p><br><input id="id#8B008B" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkMagenta<br>#8B008B</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkOliveGreen; color: white;" id="#556B2F"><label style="margin-left: 1vw;"><p><br><input id="id#556B2F" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkOliveGreen<br>#556B2F</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkOrange; color: black;" id="#FF8C00"><label style="margin-left: 1vw;"><p><br><input id="id#FF8C00" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkOrange<br>#FF8C00</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: DarkOrchid; color: white;" id="#9932CC"><label style="margin-left: 1vw;"><p><br><input id="id#9932CC" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkOrchid<br>#9932CC</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkRed; color: white;" id="#8B0000"><label style="margin-left: 1vw;"><p><br><input id="id#8B0000" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkRed<br>#8B0000</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkSalmon; color: black;" id="#E9967A"><label style="margin-left: 1vw;"><p><br><input id="id#E9967A" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkSalmon<br>#E9967A</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: DarkSeaGreen; color: black;" id="#8FBC8F"><label style="margin-left: 1vw;"><p><br><input id="id#8FBC8F" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkSeaGreen<br>#8FBC8F</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkSlateBlue; color: white;" id="#483D8B"><label style="margin-left: 1vw;"><p><br><input id="id#483D8B" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkSlateBlue<br>#483D8B</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkSlateGray; color: white;" id="#2F4F4F"><label style="margin-left: 1vw;"><p><br><input id="id#2F4F4F" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkSlateGray<br>#2F4F4F</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: DarkTurquoise; color: black;" id="#00CED1"><label style="margin-left: 1vw;"><p><br><input id="id#00CED1" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkTurquoise<br>#00CED1</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkViolet; color: white;" id="#9400D3"><label style="margin-left: 1vw;"><p><br><input id="id#9400D3" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DarkViolet<br>#9400D3</p></label></div>
<div class="color-block z-depth-2" style="background-color: DeepPink; color: black;" id="#FF1493"><label style="margin-left: 1vw;"><p><br><input id="id#FF1493" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DeepPink<br>#FF1493</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: DeepSkyBlue; color: black;" id="#00BFFF"><label style="margin-left: 1vw;"><p><br><input id="id#00BFFF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DeepSkyBlue<br>#00BFFF</p></label></div>
<div class="color-block z-depth-2" style="background-color: DimGray; color: white;" id="#696969"><label style="margin-left: 1vw;"><p><br><input id="id#696969" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DimGray<br>#696969</p></label></div>
<div class="color-block z-depth-2" style="background-color: DodgerBlue; color: white;" id="#1E90FF"><label style="margin-left: 1vw;"><p><br><input id="id#1E90FF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;DodgerBlue<br>#1E90FF</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: FireBrick; color: white;" id="#B22222"><label style="margin-left: 1vw;"><p><br><input id="id#B22222" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;FireBrick<br>#B22222</p></label></div>
<div class="color-block z-depth-2" style="background-color: FloralWhite; color: black;" id="#FFFAF0"><label style="margin-left: 1vw;"><p><br><input id="id#FFFAF0" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;FloralWhite<br>#FFFAF0</p></label></div>
<div class="color-block z-depth-2" style="background-color: ForestGreen; color: white;" id="#228B22"><label style="margin-left: 1vw;"><p><br><input id="id#228B22" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;ForestGreen<br>#228B22</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Fuchsia; color: black;" id="#FF00FF"><label style="margin-left: 1vw;"><p><br><input id="id#FF00FF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Fuchsia<br>#FF00FF</p></label></div>
<div class="color-block z-depth-2" style="background-color: Gainsboro; color: black;" id="#DCDCDC"><label style="margin-left: 1vw;"><p><br><input id="id#DCDCDC" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Gainsboro<br>#DCDCDC</p></label></div>
<div class="color-block z-depth-2" style="background-color: GhostWhite; color: black;" id="#F8F8FF"><label style="margin-left: 1vw;"><p><br><input id="id#F8F8FF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;GhostWhite<br>#F8F8FF</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Gold; color: black;" id="#FFD700"><label style="margin-left: 1vw;"><p><br><input id="id#FFD700" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Gold<br>#FFD700</p></label></div>
<div class="color-block z-depth-2" style="background-color: GoldenRod; color: black;" id="#DAA520"><label style="margin-left: 1vw;"><p><br><input id="id#DAA520" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;GoldenRod<br>#DAA520</p></label></div>
<div class="color-block z-depth-2" style="background-color: Gray; color: white;" id="#808080"><label style="margin-left: 1vw;"><p><br><input id="id#808080" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Gray<br>#808080</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Green; color: white;" id="#008000><label style="margin-left: 1vw;"><p><br><input id="id#008000" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Green<br>#008000</p></label></div>
<div class="color-block z-depth-2" style="background-color: GreenYellow; color: black;" id="#ADFF2F"><label style="margin-left: 1vw;"><p><br><input id="id#ADFF2F" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;GreenYellow<br>#ADFF2F</p></label></div>
<div class="color-block z-depth-2" style="background-color: HoneyDew; color: black;" id="#F0FFF0"><label style="margin-left: 1vw;"><p><br><input id="id#F0FFF0" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;HoneyDew<br>#F0FFF0</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: HotPink; color: black;" id="#FF69B4"><label style="margin-left: 1vw;"><p><br><input id="id#FF69B4" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;HotPink<br>#FF69B4</p></label></div>
<div class="color-block z-depth-2" style="background-color: IndianRed; color: white;" id="#CD5C5C"><label style="margin-left: 1vw;"><p><br><input id="id#CD5C5C" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;IndianRed<br>#CD5C5C</p></label></div>
<div class="color-block z-depth-2" style="background-color: Indigo; color: white;" id="#4B0082"><label style="margin-left: 1vw;"><p><br><input id="id#4B0082" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Indigo<br>#4B0082</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Ivory; color: black;" id="#FFFFF0"><label style="margin-left: 1vw;"><p><br><input id="id#FFFFF0" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Ivory<br>#FFFFF0</p></label></div>
<div class="color-block z-depth-2" style="background-color: Khaki; color: black;" id="#F0E68C"><label style="margin-left: 1vw;"><p><br><input id="id#F0E68C" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Khaki<br>#F0E68C</p></label></div>
<div class="color-block z-depth-2" style="background-color: Lavender; color: black;" id="#E6E6FA"><label style="margin-left: 1vw;"><p><br><input id="id#E6E6FA" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Lavender<br>#E6E6FA</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: LavenderBlush; color: black;" id="#FFF0F5"><label style="margin-left: 1vw;"><p><br><input id="id#FFF0F5" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LavenderBlush<br>#FFF0F5</p></label></div>
<div class="color-block z-depth-2" style="background-color: LawnGreen; color: black;" id="#7CFC00"><label style="margin-left: 1vw;"><p><br><input id="id#7CFC00" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LawnGreen<br>#7CFC00</p></label></div>
<div class="color-block z-depth-2" style="background-color: LemonChiffon;" id="#7CFC00"><label style="margin-left: 1vw;"><p><br><input id="id#FFFACD" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LemonChiffon<br>#FFFACD</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: LightBlue; color: black;" id="#ADD8E6"><label style="margin-left: 1vw;"><p><br><input id="id#ADD8E6" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightBlue<br>#ADD8E6</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightCoral; color: black;" id="#F08080"><label style="margin-left: 1vw;"><p><br><input id="id#F08080" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightCoral<br>#F08080</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightCyan; color: black;" id="#E0FFFF"><label style="margin-left: 1vw;"><p><br><input id="id#E0FFFF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightCyan<br>#E0FFFF</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: LightGoldenRodYellow; color: black;" id="#FAFAD2"><label style="margin-left: 1vw;"><p><br><input id="id#FAFAD2" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightGoldenRodYellow<br>#FAFAD2</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightGray; color: black;" id="#D3D3D3"><label style="margin-left: 1vw;"><p><br><input id="id#D3D3D3" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightGray<br>#D3D3D3</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightGreen; color: black;" id="#90EE90"><label style="margin-left: 1vw;"><p><br><input id="id#90EE90" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightGreen<br>#90EE90</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: LightPink; color: black;" id="#FFB6C1"><label style="margin-left: 1vw;"><p><br><input id="id#FFB6C1" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightPink<br>#FFB6C1</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightSalmon; color: black;" id="#FFA07A"><label style="margin-left: 1vw;"><p><br><input id="id#FFA07A" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightSalmon<br>#FFA07A</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightSeaGreen; color: white;" id="#20B2AA"><label style="margin-left: 1vw;"><p><br><input id="id#20B2AA" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightSeaGreen<br>#20B2AA</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: LightSkyBlue; color: black;" id="#87CEFA"><label style="margin-left: 1vw;"><p><br><input id="id#87CEFA" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightSkyBlue<br>#87CEFA</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightSlateGrey; color: white;" id="#778899"><label style="margin-left: 1vw;"><p><br><input id="id#778899" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightSlateGrey<br>#778899</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightSteelBlue; color: black;" id="#B0C4DE"><label style="margin-left: 1vw;"><p><br><input id="id#B0C4DE" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightSteelBlue<br>#B0C4DE</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: LightYellow; color: black;" id="#FFFFE0"><label style="margin-left: 1vw;"><p><br><input id="id#FFFFE0" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LightYellow<br>#FFFFE0</p></label></div>
<div class="color-block z-depth-2" style="background-color: Lime; color: black;" id="#00FF00"><label style="margin-left: 1vw;"><p><br><input id="id#00FF00" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Lime<br>#00FF00</p></label></div>
<div class="color-block z-depth-2" style="background-color: LimeGreen; color: black;" id="#32CD32"><label style="margin-left: 1vw;"><p><br><input id="id#32CD32" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;LimeGreen<br>#32CD32</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Linen; color: black;" id="#FAF0E6"><label style="margin-left: 1vw;"><p><br><input id="id#FAF0E6" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Linen<br>#FAF0E6</p></label></div>
<div class="color-block z-depth-2" style="background-color: Magenta; color: black;" id="#FF00FF"><label style="margin-left: 1vw;"><p><br><input id="id#FF00FF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Magenta<br>#FF00FF</p></label></div>
<div class="color-block z-depth-2" style="background-color: Maroon; color: white;" id="#800000"><label style="margin-left: 1vw;"><p><br><input id="id#800000" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Maroon<br>#800000</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: MediumAquaMarine; color: black;" id="#66CDAA"><label style="margin-left: 1vw;"><p><br><input id="id#66CDAA" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumAquaMarine<br>#66CDAA</p></label></div>
<div class="color-block z-depth-2" style="background-color: MediumBlue; color: white;" id="#0000CD"><label style="margin-left: 1vw;"><p><br><input id="id#0000CD" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumBlue<br>#0000CD</p></label></div>
<div class="color-block z-depth-2" style="background-color: MediumOrchid; color: white;" id="#BA55D3"><label style="margin-left: 1vw;"><p><br><input id="id#BA55D3" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumOrchid<br>#BA55D3</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: MediumPurple; color: white;" id="#9370DB"><label style="margin-left: 1vw;"><p><br><input id="id#9370DB" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumPurple<br>#9370DB</p></label></div>
<div class="color-block z-depth-2" style="background-color: MediumSeaGreen; color: white;" id="#3CB371"><label style="margin-left: 1vw;"><p><br><input id="id#3CB371" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumSeaGreen<br>#3CB371</p></label></div>
<div class="color-block z-depth-2" style="background-color: MediumSlateBlue; color: white;" id="#7B68EE"><label style="margin-left: 1vw;"><p><br><input id="id#7B68EE" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumSlateBlue<br>#7B68EE</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: MediumSpringGreen; color: black;" id="#00FA9A"><label style="margin-left: 1vw;"><p><br><input id="id#00FA9A" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumSpringGreen<br>#00FA9A</p></label></div>
<div class="color-block z-depth-2" style="background-color: MediumTurquoise; color: white;" id="#48D1CC"><label style="margin-left: 1vw;"><p><br><input id="id#48D1CC" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumTurquoise<br>#48D1CC</p></label></div>
<div class="color-block z-depth-2" style="background-color: MediumVioletRed; color: white;" id="#C71585"><label style="margin-left: 1vw;"><p><br><input id="id#C71585" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MediumVioletRed<br>#C71585</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: MidnightBlue; color: white;" id="#191970"><label style="margin-left: 1vw;"><p><br><input id="id#191970" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MidnightBlue<br>#191970</p></label></div>
<div class="color-block z-depth-2" style="background-color: MintCream; color: black;" id="#F5FFFA"><label style="margin-left: 1vw;"><p><br><input id="id#F5FFFA" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MintCream<br>#F5FFFA</p></label></div>
<div class="color-block z-depth-2" style="background-color: MistyRose; color: black;" id="#FFE4E1"><label style="margin-left: 1vw;"><p><br><input id="id#FFE4E1" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;MistyRose<br>#FFE4E1</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Moccasin; color: black;" id="#FFE4B5"><label style="margin-left: 1vw;"><p><br><input id="id#FFE4B5" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Moccasin<br>#FFE4B5</p></label></div>
<div class="color-block z-depth-2" style="background-color: NavajoWhite; color: black;" id="#FFDEAD"><label style="margin-left: 1vw;"><p><br><input id="id#FFDEAD" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;NavajoWhite<br>#FFDEAD</p></label></div>
<div class="color-block z-depth-2" style="background-color: Navy; color: white;" id="#000080"><label style="margin-left: 1vw;"><p><br><input id="id#000080" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Navy<br>#000080</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: OldLace; color: black;" id="#FDF5E6"><label style="margin-left: 1vw;"><p><br><input id="id#FDF5E6" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;OldLace<br>#FDF5E6</p></label></div>
<div class="color-block z-depth-2" style="background-color: Olive; color: white;" id="#808000"><label style="margin-left: 1vw;"><p><br><input id="id#808000" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Olive<br>#808000</p></label></div>
<div class="color-block z-depth-2" style="background-color: OliveDrab; color: white;" id="#6B8E23"><label style="margin-left: 1vw;"><p><br><input id="id#6B8E23" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;OliveDrab<br>#6B8E23</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Orange; color: black;" id="#FFA500"><label style="margin-left: 1vw;"><p><br><input id="id#FFA500" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Orange<br>#FFA500</p></label></div>
<div class="color-block z-depth-2" style="background-color: OrangeRed; color: white;" id="#FF4500"><label style="margin-left: 1vw;"><p><br><input id="id#FF4500" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;OrangeRed<br>#FF4500</p></label></div>
<div class="color-block z-depth-2" style="background-color: Orchid; color: black;" id="#DA70D6"><label style="margin-left: 1vw;"><p><br><input id="id#DA70D6" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Orchid<br>#DA70D6</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: PaleGoldenRod; color: black;" id="#EEE8AA"><label style="margin-left: 1vw;"><p><br><input id="id#EEE8AA" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;PaleGoldenRod<br>#EEE8AA</p></label></div>
<div class="color-block z-depth-2" style="background-color: PaleGreen; color: black;" id="#98FB98"><label style="margin-left: 1vw;"><p><br><input id="id#98FB98" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;PaleGreen<br>#98FB98</p></label></div>
<div class="color-block z-depth-2" style="background-color: PaleTurquoise; color: black;" id="#AFEEEE"><label style="margin-left: 1vw;"><p><br><input id="id#AFEEEE" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;PaleTurquoise<br>#AFEEEE</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: PaleVioletRed; color: black;" id="#DB7093"><label style="margin-left: 1vw;"><p><br><input id="id#DB7093" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;PaleVioletRed<br>#DB7093</p></label></div>
<div class="color-block z-depth-2" style="background-color: PapayaWhip; color: black;" id="#FFEFD5"><label style="margin-left: 1vw;"><p><br><input id="id#FFEFD5" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;PapayaWhip<br>#FFEFD5</p></label></div>
<div class="color-block z-depth-2" style="background-color: PeachPuff; color: black;" id="#FFDAB9"><label style="margin-left: 1vw;"><p><br><input id="id#FFDAB9" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;PeachPuff<br>#FFDAB9</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Peru; color: black;" id="#CD853F"><label style="margin-left: 1vw;"><p><br><input id="id#CD853F" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Peru<br>#CD853F</p></label></div>
<div class="color-block z-depth-2" style="background-color: Pink; color: black;" id="#FFC0CB"><label style="margin-left: 1vw;"><p><br><input id="id#FFC0CB" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Pink<br>#FFC0CB</p></label></div>
<div class="color-block z-depth-2" style="background-color: Plum; color: black;" id="#DDA0DD"><label style="margin-left: 1vw;"><p><br><input id="id#DDA0DD" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Plum<br>#DDA0DD</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: PowderBlue; color: black;" id="#B0E0E6"><label style="margin-left: 1vw;"><p><br><input id="id#B0E0E6" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;PowderBlue<br>#B0E0E6</p></label></div>
<div class="color-block z-depth-2" style="background-color: Purple; color: white;" id="#800080"><label style="margin-left: 1vw;"><p><br><input id="id#800080" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Purple<br>#800080</p></label></div>
<div class="color-block z-depth-2" style="background-color: RebeccaPurple; color: white;" id="#663399"><label style="margin-left: 1vw;"><p><br><input id="id#663399" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;RebeccaPurple<br>#663399</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Red; color: white;" id="#FF0000"><label style="margin-left: 1vw;"><p><br><input id="id#FF0000" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Red<br>#FF0000</p></label></div>
<div class="color-block z-depth-2" style="background-color: RosyBrown; color: white;" id="#BC8F8F"><label style="margin-left: 1vw;"><p><br><input id="id#BC8F8F" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;RosyBrown<br>#BC8F8F</p></label></div>
<div class="color-block z-depth-2" style="background-color: RoyalBlue; color: white;" id="#4169E1"><label style="margin-left: 1vw;"><p><br><input id="id#4169E1" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;RoyalBlue<br>#4169E1v</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: SaddleBrown; color: white;" id="#8B4513"><label style="margin-left: 1vw;"><p><br><input id="id#8B4513" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SaddleBrown<br>#8B4513</p></label></div>
<div class="color-block z-depth-2" style="background-color: Salmon; color: black;" id="#FA8072"><label style="margin-left: 1vw;"><p><br><input id="id#FA8072" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Salmon<br>#FA8072</p></label></div>
<div class="color-block z-depth-2" style="background-color: SandyBrown; color: black;" id="#F4A460"><label style="margin-left: 1vw;"><p><br><input id="id#F4A460" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SandyBrown<br>#F4A460</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: SeaGreen; color: white;" id="#2E8B57"><label style="margin-left: 1vw;"><p><br><input id="id#2E8B57" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SeaGreen<br>#2E8B57</p></label></div>
<div class="color-block z-depth-2" style="background-color: SeaShell; color: black;" id="#FFF5EE"><label style="margin-left: 1vw;"><p><br><input id="id#FFF5EE" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SeaShell<br>#FFF5EE</p></label></div>
<div class="color-block z-depth-2" style="background-color: Sienna; color: white;" id="#A0522D"><label style="margin-left: 1vw;"><p><br><input id="id#A0522D" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Sienna<br>#A0522D</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Silver; color: black;" id="#C0C0C0"><label style="margin-left: 1vw;"><p><br><input id="id#C0C0C0" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Silver<br>#C0C0C0v</p></label></div>
<div class="color-block z-depth-2" style="background-color: SkyBlue; color: black;" id="#87CEEB"><label style="margin-left: 1vw;"><p><br><input id="id#87CEEB" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SkyBlue<br>#87CEEB</p></label></div>
<div class="color-block z-depth-2" style="background-color: SlateBlue; color: white;" id="#6A5ACD"><label style="margin-left: 1vw;"><p><br><input id="id#6A5ACD" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SlateBlue<br>#6A5ACD</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: SlateGray; color: white;" id="#708090"><label style="margin-left: 1vw;"><p><br><input id="id#708090" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SlateGray<br>#708090</p></label></div>
<div class="color-block z-depth-2" style="background-color: Snow; color: black;" id="#FFFAFA"><label style="margin-left: 1vw;"><p><br><input id="id#FFFAFA" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Snow<br>#FFFAFA</p></label></div>
<div class="color-block z-depth-2" style="background-color: SpringGreen; color: black;" id="#00FF7F"><label style="margin-left: 1vw;"><p><br><input id="id#00FF7F" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SpringGreen<br>#00FF7F</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: SteelBlue; color: white;" id="#4682B4"><label style="margin-left: 1vw;"><p><br><input id="id#4682B4" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;SteelBlue<br>#4682B4</p></label></div>
<div class="color-block z-depth-2" style="background-color: Tan; color: black;" id="#D2B48C"><label style="margin-left: 1vw;"><p><br><input id="id#D2B48C" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Tan<br>#D2B48C</p></label></div>
<div class="color-block z-depth-2" style="background-color: Teal; color: white;" id="#008080"><label style="margin-left: 1vw;"><p><br><input id="id#008080" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Teal<br>#008080</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Thistle; color: black;" id="#D8BFD8"><label style="margin-left: 1vw;"><p><br><input id="id#D8BFD8" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Thistle<br>#D8BFD8</p></label></div>
<div class="color-block z-depth-2" style="background-color: Tomato; color: black;" id="#FF6347"><label style="margin-left: 1vw;"><p><br><input id="id#FF6347" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Tomato<br>#FF6347</p></label></div>
<div class="color-block z-depth-2" style="background-color: Turquoise; color: black;" id="#40E0D0"><label style="margin-left: 1vw;"><p><br><input id="id#40E0D0" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Turquoise<br>#40E0D0</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: Violet; color: black;" id="#EE82EE"><label style="margin-left: 1vw;"><p><br><input id="id#EE82EE" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Violet<br>#EE82EE</p></label></div>
<div class="color-block z-depth-2" style="background-color: Wheat; color: black;" id="#F5DEB3"><label style="margin-left: 1vw;"><p><br><input id="id#F5DEB3" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Wheat<br>#F5DEB3</p></label></div>
<div class="color-block z-depth-2" style="background-color: White; color: black;" id="#FFFFFF"><label style="margin-left: 1vw;"><p><br><input id="id#FFFFFF" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;White<br>#FFFFFF</p></label></div>
</div>
<div class="col-md-4 mb-4">
<div class="color-block z-depth-2" style="background-color: WhiteSmoke; color: black;" id="#F5F5F5"><label style="margin-left: 1vw;"><p><br><input id="id#F5F5F5" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;WhiteSmoke<br>#F5F5F5</p></label></div>
<div class="color-block z-depth-2" style="background-color: Yellow; color: black;" id="#FFFF00"><label style="margin-left: 1vw;"><p><br><input id="id#FFFF00" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;Yellow<br>#FFFF00</p></label></div>
<div class="color-block z-depth-2" style="background-color: YellowGreen; color: black;" id="#9ACD32"><label style="margin-left: 1vw;"><p><br><input id="id#9ACD32" class="fcheckbox" type="checkbox" name="Capcolor" />&emsp;YellowGreen<br>#9ACD32</p></label></div>
    </div>
</div>
EOT3;
echo $colrs;
$fcolrs = <<< EOT4
<div class="card col-sm-11 d-flex flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0">
<div id="fontColor" class="card-body"><h2>Choose a caption font color</h2></div></div>
<div style="opacity: 0;" class="card col-sm-12 #929fba mdb-color lighten-3 px-sm-0"><br></div>
<div class="row mx-1 d-flex col-sm-12">
<div class="col-md-3 mb-4">
<div class="color-block z-depth-2" style="background-color: White; color: black;" id="fc#FFFFFF"><label style="margin-left: 1vw;"><p><br><input id="fcid#FFFFFF" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;White<br>#FFFFFF</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightGray; color: white;" id="fc#D3D3D3"><label style="margin-left: 1vw;"><p><br><input id="fcid#D3D3D3" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;LightGray<br>#D3D3D3</p></label></div>
<div class="color-block z-depth-2" style="background-color: Black; color: white;" id="fc#000000"><label style="margin-left: 1vw;"><p><br><input id="fcid#000000" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;Black<br>#000000</p></label></div>
</div>
<div class="col-md-3 mb-4">
<div class="color-block z-depth-2" style="background-color: DarkBlue; color: white;" id="fc#00008B"><label style="margin-left: 1vw;"><p><br><input id="fcid#00008B" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;DarkBlue<br>#00008B</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkGreen; color: white;" id="fc#006400"><label style="margin-left: 1vw;"><p><br><input id="fcid#006400" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;DarkGreen<br>#006400</p></label></div>
<div class="color-block z-depth-2" style="background-color: DarkRed; color: white;" id="fc#8B0000"><label style="margin-left: 1vw;"><p><br><input id="fcid#8B0000" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;DarkRed<br>#8B0000</p></label></div>
</div>
<div class="col-md-3 mb-4">
<div class="color-block z-depth-2" style="background-color: LightBlue; color: black;" id="fc#ADD8E6"><label style="margin-left: 1vw;"><p><br><input id="fcid#ADD8E6" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;LightBlue<br>#ADD8E6</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightGreen; color: black;" id="fc#90EE90"><label style="margin-left: 1vw;"><p><br><input id="fcid#90EE90" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;LightGreen<br>#90EE90</p></label></div>
<div class="color-block z-depth-2" style="background-color: LightPink; color: black;" id="fc#FFB6C1"><label style="margin-left: 1vw;"><p><br><input id="fcid#FFB6C1" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;LightPink<br>#FFB6C1</p></label></div>
</div>
<div class="col-md-3 mb-4">
<div class="color-block z-depth-2" style="background-color: Lime; color: black;" id="fc#00FF00"><label style="margin-left: 1vw;"><p><br><input id="fcid#00FF00" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;Lime<br>#00FF00</p></label></div>
<div class="color-block z-depth-2" style="background-color: Yellow; color: black;" id="fc#FFFF00"><label style="margin-left: 1vw;"><p><br><input id="fcid#FFFF00" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;Yellow<br>#FFFF00</p></label></div>
<div class="color-block z-depth-2" style="background-color: OrangeRed ; color: black;" id="fc#FF4500"><label style="margin-left: 1vw;"><p><br><input id="fcid#FF4500" class="fcheckbox" type="checkbox" name="Fntcolor" />&emsp;OrangeRed<br>#FF4500</p></label></div>
</div>
</div>
EOT4;
echo $fcolrs;
?>
<form id="xmplbox" class="d-flex col-sm-11 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" name="fontinfo" action="saveFonts.php" method="post" enctype="text">
<label>Heading Font CSS:<br><textarea id="hfontval" name="hfontinfo" rows="4" cols="64"></textarea></label>
<label>Paragraph Font CSS:<br><textarea id="pfontval" name="pfontinfo" rows="4" cols="64"></textarea></label>
<label>Caption Background:<br><textarea  id="cbval" name="cbinfo" rows="1" cols="64"></textarea></label>
<br>

<style id="xmplcbox"></style>
<style id="xmplhdgs"></style>
<style id="xmplbody"></style>
<div class="xmplc d-flex col-sm-11 flex-column align-items-center px-sm-0 msgBox">
<h1 class="xmplh">THIS IS AN Example TOP LEVEL Heading</h1>
<h2 class="xmplh">This is an EXAMPLE second level HEADING</h2>
<h3 class="xmplh">This is an example THIRD LEVEL HEADING</h3>
<br>
<p class="xmplp mx-3">This is an example of the paragraph text font being used in paragraph text. It's a short and saucy paragraph that has no existential meaning. Or does it?<br><br>This is an <b><i>example</i></b> of the paragraph text font being used with <b>Boldface</b> and <i>italics</i> in paragraph text. It's a short and saucy paragraph that has existential meaning because of the <i>text embellishments</i>. Or does it?</p></div>

<br><span class="d-flex col-sm-11 flex-column align-items-left px-sm-0 msgBox #b0bec5 blue-grey lighten-3">
<label style="margin-left: 2vw;"><input id="captionChoices" class="fcheckbox" type="checkbox" name="captChoices" value="captionChoices"/>&emsp;Use selected Fonts and Colors for the Captions<br></label>
<label style="margin-left: 2vw;"><input id="altCaptionChoices" class="fcheckbox" type="checkbox" name="captChoices" value="altCaptionChoices"/>&emsp;Use selected Fonts and Colors for the Alternate Image Captions<br></label>
<label style="margin-left: 2vw;"><input id="bothChoices" class="fcheckbox" type="checkbox" name="captChoices" value="bothChoices"/>&emsp;Use selected Fonts and Colors for both Captions and Alternate Image Captions<br></label>

<label style="margin-left: 2vw;">Save selected Fonts and Colors<br><input id="saveChoices" type="submit" value="Save Font Selection"></label></span>
</form><br>
</div>

	<footer class="d-flex col-sm-12 flex-column align-items-center shadow-md #b0bec5 blue-grey lighten-3 px-sm-0 infoBox" style="margin-left:0;" id="GalleryFooter">
	<nav id="navFooter"><p><a id="prevpagebutton" href="./getAltImgMP3.php" title="return to the get audio page">❮ Previous</a>&nbsp;&copy; 2021 by&nbsp;<span><svg version="1.0" xmlns="http://www.w3.org/2000/svg" width="40px" height="40px" viewBox="0 0 40.000000 40.000000" preserveAspectRatio="xMidYMid meet">
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
	</svg></span>&nbsp;<a href="mailto:bob_wright@isoblock.com">Bob Wright.</a>&nbsp;Last modified&emsp;<?php echo date ("F d Y H:i.", getlastmod()) ?>&emsp;<a id="nextpagebutton" href="./getOGImg.php" title="go to the OG Image chooser">Next ❯</a></p></nav>
	</footer>
<script>
$( document ).ready(function() {
var $defhfont = 'Roboto-Bold';
var $defpfont = 'Merriweather-Regular';
var $defccolr = 'blue-grey<br>#b0bec5';
var $bkgdef = $defccolr.substr(-7, 7);
var $deftcolr = 'black';
var $fcolr = $deftcolr;
var $hid = $defhfont;
var $pid = $defpfont;
var $panelid = $bkgdef;

// default CSS styles
$("#hfontval").html('@font-face {font-family: "'+$hid+'"; src: url("./Fonts/'+$hid+'.ttf") format("truetype");} h1 { font: 3vw '+$hid+'; color: '+ $deftcolr +';} h2 { font: 2.5vw '+$hid+'; color: '+ $deftcolr +';} h3 { font: 2.2vw '+$hid+'; color: '+ $deftcolr +';}');
$("#pfontval").html('@font-face {font-family: "'+$pid+'"; src: url("./Fonts/'+$pid+'.ttf") format("truetype");} .card-body, p { font: 2vw '+$pid+'; color: '+ $deftcolr +';} ');
$("#cbval").html('{background: '+ $bkgdef +';}');
// styles for the example box
$("#xmplhdgs").html('@font-face {font-family: "'+$hid+'"; src: url("./Fonts/'+$hid+'.ttf") format("truetype");} h1.xmplh { font: 3vw '+$hid+'; color: '+ $deftcolr +';} h2.xmplh { font: 2.5vw '+$hid+'; color: '+ $deftcolr +';} h3.xmplh { font: 2.2vw '+$hid+'; color: '+ $deftcolr +';}');
$("#xmplbody").html('@font-face {font-family: "'+$pid+'"; src: url("./Fonts/'+$pid+'.ttf") format("truetype");} p.xmplp { font: 2vw '+$pid+'; color: '+ $deftcolr +';}');
$("#xmplcbox").html('.xmplc {background: '+ $bkgdef +';}');

// checkbox changed?
$('input[type="checkbox"]').on('change', function() {
    $('input[name="' + this.name + '"]').not(this).prop('checked', false);
	console.info(this.checked +" "+ this.id +" "+ this.name);
var $id = this.id;

// caption font color
if(this.name == "Fntcolor") {
	if(this.checked == true) {
		var $fpanelid = $id.substr(-7, 7);
			console.info($fpanelid);
		$fcolr = $fpanelid;
			console.info($fcolr);
	} else {
		$fcolr = $deftcolr;
	}}
// caption headings font
if(this.name == "Headings") {
	if(this.checked == true) {
		$hid = $id.substr(1);
	} else {
		$hid = $defhfont;
	}}
// caption paragraph font
if(this.name == "Bodytext") {
	if(this.checked == true) {
		$pid = $id.substr(1);
	} else {
		$pid = $defpfont;
	}}
// caption background color
if(this.name == "Capcolor") {
	if(this.checked == true) {
		$panelid = $id.substr(-7, 7);
	} else {
		$panelid = $bkgdef;
	}}

// save selections for captions, alt image captions, or both
if(this.name == "captChoices") {
	if(this.checked == true) {
		$captChoices = $id.substr(1);
	} else {
		$captChoices = "bothChoices";
	}}

	$("#hfontval").html('@font-face {font-family: "'+$hid+'"; src: url("./Fonts/'+$hid+'.ttf") format("truetype");} @media screen and (max-width: 576px) {   h1 { font: 5vw '+$hid+'; color: '+ $fcolr +';} h2 { font: 4vw '+$hid+'; color: '+ $fcolr +';} h3 { font: 3.5vw '+$hid+'; color: '+ $fcolr +';}} @media screen and (min-width: 577px) and (max-width: 1079px) {h1 { font: 4vw '+$hid+'; color: '+ $fcolr +';} h2 { font: 3.5vw '+$hid+'; color: '+ $fcolr +';} h3 { font: 3vw '+$hid+'; color: '+ $fcolr +';}}  @media screen and (min-width: 1080px) {h1 { font: 3vw '+$hid+'; color: '+ $fcolr +';} h2 { font: 2.5vw '+$hid+'; color: '+ $fcolr +';} h3 { font: 2.2vw '+$hid+'; color: '+ $fcolr +';}}');
	$("#xmplhdgs").html('@font-face {font-family: "'+$hid+'"; src: url("./Fonts/'+$hid+'.ttf") format("truetype");} h1.xmplh { font: 3vw '+$hid+'; color: '+ $fcolr +';} h2.xmplh { font: 2.5vw '+$hid+'; color: '+ $fcolr +';} h3.xmplh { font: 2.2vw '+$hid+'; color: '+ $fcolr +';}');
	$("#pfontval").html('@font-face {font-family: "'+$pid+'"; src: url("./Fonts/'+$pid+'.ttf") format("truetype");} @media screen and (max-width: 576px) {   .card-body, p { font: 3.5vw '+$pid+'; color: '+ $fcolr +';}} @media screen and (min-width: 577px) and (max-width: 1079px) { .card-body, p { font: 2.5vw '+$pid+'; color: '+ $fcolr +';}}  @media screen and (min-width: 1080px) { .card-body, p { font: 2vw '+$pid+'; color: '+ $fcolr +';}}');
	$("#xmplbody").html('@font-face {font-family: "'+$pid+'"; src: url("./Fonts/'+$pid+'.ttf") format("truetype");} p.xmplp { font: 2vw '+$pid+'; color: '+ $fcolr +';}');
	$("#xmplcbox").html('.xmplc {background: '+ $panelid +';}');
	$("#cbval").html('{background: '+ $panelid +';}');
});
});
</script>
</main>
</body>
</html>
