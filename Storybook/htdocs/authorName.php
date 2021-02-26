<?php
/*
 * filename: authorName.php
 * this code saves the authorname in the session
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
$authorname = 'author name'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['authorname'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$authorname = preg_replace($pattern, $replacement, $authorname);
	$_SESSION["authorname"] = $authorname;
	header("Refresh: 0; URL=./index.php");
	echo "$authorname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['authorname'])) && ($_POST['authorname'] != '')) {
	$authorname = trim($_POST['authorname']);
	if(strlen($authorname) > 32) {$authorname = '';}
	//echo '<br>'.$authorname.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$authorname = preg_replace($pattern, $replacement, $authorname);
	//sanitize string
	$authorname = filter_var($authorname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($authorname != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$authorname = preg_replace($pattern, $replacement, $authorname);
		$_SESSION["authorname"] = $authorname;
		header("Refresh: 0; URL=./index.php");
		echo "$authorname is a valid string.<br/><br/>";
	} else {
		$_SESSION["authorname"] = '';
		header("Refresh: 0; URL=./index.php");
		echo "$authorname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
