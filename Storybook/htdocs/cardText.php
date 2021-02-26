<?php
/*
 * filename: cardText.php
 * this code saves the card text in the session
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
$cardText = 'This is a sample Comic comment or description about the Comic.<br>Line breaks, the Enter key, will echo here as the HTML break tag, like this<br>So line breaks may be included in the text input.<br>input can also include symbols like ~!@#$%^&*()_+|}{:\"?-=[]\;\'/ but less than or greater than symbols are not allowed.'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['cardText'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$cardText = preg_replace($pattern, $replacement, $cardText);
	$_SESSION["cardText"] = $cardText;
	header("Refresh: 0; URL=./index.php");
	echo "$cardText is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['cardText'])) && ($_POST['cardText'] != '')) {
	$cardText = trim($_POST['cardText']);
	if(strlen($cardText) > 1024) {$cardText = '';}
	//echo '<br>'.$cardText.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$cardText = preg_replace($pattern, $replacement, $cardText);
	//sanitize string
	$cardText = filter_var($cardText, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($cardText != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$cardText = preg_replace($pattern, $replacement, $cardText);
		$_SESSION["cardText"] = $cardText;
		header("Refresh: 0; URL=./index.php");
		echo "$cardText is a valid string.<br/><br/>";
	} else {
		$_SESSION["cardText"] = '';
		header("Refresh: 0; URL=./index.php");
		echo "$cardText is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
