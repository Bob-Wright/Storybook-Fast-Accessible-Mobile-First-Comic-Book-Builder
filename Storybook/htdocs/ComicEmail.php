<?php
/*
 * filename: ComicEmail.php
 * this code saves the site Email address in the session
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set fallback variable
$Comicemail = 'ComicCreator@syntheticreality.net'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['Comicemail'] == '')) { // empty POST then fallback value
	$_SESSION["Comicemail"] = $Comicemail;
	header("Refresh: 1; URL=./index.php");
	echo "$Comicemail is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['Comicemail'])) && ($_POST['Comicemail'] != '')) {
	$Comicemail = trim($_POST['Comicemail']);
	//sanitize string
    $Comicemail = filter_var($_POST['Comicemail'], FILTER_SANITIZE_EMAIL);
    if (filter_var($Comicemail, FILTER_VALIDATE_EMAIL)) {
		$_SESSION["Comicemail"] = $Comicemail;
		header("Refresh: 1; URL=./index.php");
		echo "$Comicemail is a valid string.<br/><br/>";
	} else {
		$_SESSION["Comicemail"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "$Comicemail is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}


?>
