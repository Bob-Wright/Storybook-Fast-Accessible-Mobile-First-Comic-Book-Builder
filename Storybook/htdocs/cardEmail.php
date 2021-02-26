<?php
/*
 * filename: cardEmail.php
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
$cardemail = 'ComicCreator@syntheticreality.net'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['cardemail'] == '')) { // empty POST then fallback value
	$_SESSION["cardemail"] = $cardemail;
	header("Refresh: 0; URL=./index.php");
	echo "$cardemail is a valid string.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['cardemail'])) && ($_POST['cardemail'] != '')) {
	$cardemail = trim($_POST['cardemail']);
	if(strlen($cardemail) > 64) {$cardemail = '';}
	//sanitize string
    $cardemail = filter_var($_POST['cardemail'], FILTER_SANITIZE_EMAIL);
    if (filter_var($cardemail, FILTER_VALIDATE_EMAIL)) {
		$_SESSION["cardemail"] = $cardemail;
		header("Refresh: 0; URL=./index.php");
		echo "$cardemail is a valid string.<br/><br/>";
	} else {
		$_SESSION["cardemail"] = '';
		header("Refresh: 0; URL=./index.php");
		echo "$cardemail is <strong>NOT</strong> a valid string.<br/><br/>";
	}
}


?>
