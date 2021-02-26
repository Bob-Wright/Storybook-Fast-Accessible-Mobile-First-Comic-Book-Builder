<?php
/*
 * filename: navMenu.php
 * this code processes naviagation menu display choices
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();
//	echo '<pre>';var_dump($_POST);echo '</pre>';
// set fallback variable
$navmenu = 'none'; //fallback
// check that form was actually submitted
if(!((isset($_POST['displayCheckbox'])) || (isset($_POST['hideCheckbox'])))){
	$_SESSION["navmenu"] = $navmenu;
	header("Refresh: 1; URL=./index.php");
	echo "Navigation Menu is disabled.<br/><br/>";
}
if(isset($_POST['displayCheckbox'])){
// user wants to display the menu bar
		$_SESSION["navmenu"] = 'show';
		header("Refresh: 1; URL=./index.php");
		echo "Navigation Menu will be displayed.<br/><br/>";
}
if(isset($_POST['hideCheckbox'])){
// user wants to hide the menu bar
		$_SESSION["navmenu"] = 'hide';
		header("Refresh: 1; URL=./index.php");
		echo "Navigation Menu will be hidden.<br/><br/>";
}
?>