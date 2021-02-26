<?php
/*
 * filename: clearConfig.php
 * this code clears the previously saved Comic config file name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

$getconfig = 'ComicConfigs.php';
$uploadDir = "/home/bitnami/uploads/");

if(file_exists("/home/bitnami/uploads/ComicConfigs.php")) {
	$result = unlink("/home/bitnami/uploads/ComicConfigs.php");
}
include './closeSession.php';

?>
