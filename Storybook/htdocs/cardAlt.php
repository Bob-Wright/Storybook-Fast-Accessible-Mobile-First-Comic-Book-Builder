<?php
/*
 * filename: cardAlt.php
 * this code saves the card image alt text in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
// . \ + * ? ^ $ [ ] ( ) { } < > = ! | :
$cardAlt = 'This is a sample Alt text for the card image.'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['cardAlt'] == '')) { // empty POST then fallback value
	$_SESSION["cardAlt"] = $cardAlt;
	header("Refresh: 0; URL=./index.php#cardAlt");
	echo "$cardAlt is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['cardAlt'])) && ($_POST['cardAlt'] != '')) {
	$cardAlt = trim($_POST['cardAlt']);
	if(strlen($cardAlt) > 320) {$cardAlt = '';}
	//echo '<br>'.$cardAlt.'<br>';
	//echo strlen($cardAlt).'<br>';
	//sanitize string
	$cardAlt = filter_var($cardAlt, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($cardAlt != '') {
		$_SESSION["cardAlt"] = $cardAlt;
		header("Refresh: 0; URL=./index.php#cardAlt");
		echo "$cardAlt is a valid string.<br/><br/>";
	} else {
		$_SESSION["cardAlt"] = '';
		header("Refresh: 0; URL=./index.php#cardAlt");
		echo "$cardAlt is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
