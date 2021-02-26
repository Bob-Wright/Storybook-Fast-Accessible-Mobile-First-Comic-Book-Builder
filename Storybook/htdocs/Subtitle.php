<?php
/*
 * filename: Subtitle.php
 * this code saves the card subtitle in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("ComicBuilder");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$Subtitle = 'A gallery card subtitle'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['Subtitle'] == '')) { // empty POST then fallback value
	$_SESSION["Subtitle"] = $Subtitle;
	header("Refresh: 1; URL=./index.php");
	echo "$Subtitle is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['Subtitle'])) && ($_POST['Subtitle'] != '')) {
	$Subtitle = trim($_POST['Subtitle']);
	if(strlen($Subtitle) > 46) {$Subtitle = '';}
	//sanitize string
	$Subtitle = filter_var($Subtitle, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($Subtitle != '') {
		$_SESSION["Subtitle"] = $Subtitle;
		header("Refresh: 1; URL=./index.php");
		echo "$Subtitle is a valid string.<br/><br/>";
	} else {
		$_SESSION["Subtitle"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$Subtitle is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
