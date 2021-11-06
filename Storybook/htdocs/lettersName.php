<?php
/*
 * filename: lettersName.php
 * this code saves the lettersname in the session
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
$lettersname = 'script writer'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['lettersname'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$lettersname = preg_replace($pattern, $replacement, $lettersname);
	$_SESSION["lettersname"] = $lettersname;
	header("Refresh: 0; URL=./index.php#lettersName");
	echo "$lettersname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['lettersname'])) && ($_POST['lettersname'] != '')) {
	$lettersname = trim($_POST['lettersname']);
	if(strlen($lettersname) > 32) {$lettersname = '';}
	//echo '<br>'.$lettersname.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$lettersname = preg_replace($pattern, $replacement, $lettersname);
	//sanitize string
	$lettersname = filter_var($lettersname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($lettersname != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$lettersname = preg_replace($pattern, $replacement, $lettersname);
		$_SESSION["lettersname"] = $lettersname;
		header("Refresh: 0; URL=./index.php#lettersName");
		echo "$lettersname is a valid string.<br/><br/>";
	} else {
		$_SESSION["lettersname"] = '';
		header("Refresh: 0; URL=./index.php#lettersName");
		echo "$lettersname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
