<?php
error_reporting(E_ALL); //disable for production
ini_set('display_errors', TRUE);

// Start session
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");
include '/home/bitnami/ComicsUser/htdocs/ComicsUser.class.php';
	$user = new ComicsUser();

	// try to create new image data table
//    $imageData = $image->createTable();
	// and user data table
	$userData = $user->createTable();
?>