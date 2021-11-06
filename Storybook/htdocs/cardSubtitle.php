<?php
/*
 * filename: cardSubtitle.php
 * this code saves the card subtitle in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
$cardSubtitle = 'A gallery card subtitle'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['cardSubtitle'] == '')) { // empty POST then fallback value
	$_SESSION["cardSubtitle"] = $cardSubtitle;
	header("Refresh: 0; URL=./index.php#cardSubtitle");
	echo "$cardSubtitle is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['cardSubtitle'])) && ($_POST['cardSubtitle'] != '')) {
	$cardSubtitle = trim($_POST['cardSubtitle']);
	if(strlen($cardSubtitle) > 64) {$cardSubtitle = '';}
	//sanitize string
	$cardSubtitle = filter_var($cardSubtitle, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($cardSubtitle != '') {
		$_SESSION["cardSubtitle"] = $cardSubtitle;
		header("Refresh: 0; URL=./index.php#cardSubtitle");
		echo "$cardSubtitle is a valid string.<br/><br/>";
	} else {
		$_SESSION["cardSubtitle"] = '';
		header("Refresh: 0; URL=./index.php#cardSubtitle");
		echo "$cardSubtitle is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}
?>
