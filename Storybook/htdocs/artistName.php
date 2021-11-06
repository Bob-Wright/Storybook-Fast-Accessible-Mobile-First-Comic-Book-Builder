<?php
/*
 * filename: ComicName.php
 * this code saves the Comic display name in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$artistname = 'Comic Creator'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['artistname'] == '')) { // empty POST then fallback value
	$_SESSION["artistname"] = $artistname;
	header("Refresh: 0; URL=./index.php#artistName");
	echo "$artistname is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['artistname'])) && ($_POST['artistname'] != '')) {
	$artistname = trim($_POST['artistname']);
	if(strlen($artistname) > 32) {$artistname = '';}
	//sanitize string
	$artistname = filter_var($artistname, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($artistname != '') {
		$_SESSION["artistname"] = $artistname;
		header("Refresh: 0; URL=./index.php#artistName");
		echo "$artistname is a valid string.<br/><br/>";
	} else {
		$_SESSION["artistname"] = '';
		header("Refresh: 0; URL=./index.php#artistName");
		echo "$artistname is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}

?>
