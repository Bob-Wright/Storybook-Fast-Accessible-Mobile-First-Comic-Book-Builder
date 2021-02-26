<?php
/*
 * filename: pencilsName.php
 * this code saves the pencilsname in the session
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
$pencilsname = 'script writer'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['pencilsname'] == '')) { // empty POST then fallback value
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '<br>';
	$pencilsname = preg_replace($pattern, $replacement, $pencilsname);
	$_SESSION["pencilsname"] = $pencilsname;
	header("Refresh: 0; URL=./index.php");
	echo "$pencilsname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['pencilsname'])) && ($_POST['pencilsname'] != '')) {
	$pencilsname = trim($_POST['pencilsname']);
	if(strlen($pencilsname) > 32) {$pencilsname = '';}
	//echo '<br>'.$pencilsname.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$pencilsname = preg_replace($pattern, $replacement, $pencilsname);
	//sanitize string
	$pencilsname = filter_var($pencilsname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($pencilsname != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$pencilsname = preg_replace($pattern, $replacement, $pencilsname);
		$_SESSION["pencilsname"] = $pencilsname;
		header("Refresh: 0; URL=./index.php");
		echo "$pencilsname is a valid string.<br/><br/>";
	} else {
		$_SESSION["pencilsname"] = '';
		header("Refresh: 0; URL=./index.php");
		echo "$pencilsname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
