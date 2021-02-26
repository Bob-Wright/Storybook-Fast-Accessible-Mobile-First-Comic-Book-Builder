<?php
/*
 * filename: noZoomSitename.php
 * this code processes sitename and sitename subtitle display choices
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
//	echo '<pre>';var_dump($_POST);echo '</pre>';

// check that form was actually submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['zoomCheckbox'])) {
		// user wants to disable animation
		$_SESSION["noZoomSitename"] = '1';
		header("Refresh: 1; URL=./index.php");
		echo "The SiteName and SiteName Subtitle will NOT be animated.<br/><br/>";
	} else {
		// user wants animation
		$_SESSION["noZoomSitename"] = '0';
		header("Refresh: 1; URL=./index.php");
		echo "The SiteName and SiteName Subtitle will be animated.<br/><br/>";
	} 
}
?>