<?php
/*
 * filename: downloadZip.php
 * this code downloads the arcived Comic files
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);


if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['Comicname'])) && ($_POST['Comicname'] != '')) {
	$Comicname = trim($_POST['Comicname']);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

//		foreach ($_POST as $key=>$val)
//		echo '['.$key.'] => '.$val.'<br/>';
//		echo '<br><hr class="new3">';
$Comicname = $_SESSION['Comicname'];
$Comics = '/home/bitnami/Comics/htdocs/';

// Download Web Image Comic ZIP File
if(file_exists($Comics.$Comicname.'.zip')) {
// http headers for zip downloads
header("Pragma: public");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: public");
header("Content-Description: File Transfer");
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=".$Comicname.".zip");
header("Content-Transfer-Encoding: binary");
header("Content-Length: ".filesize($Comicname.".zip"));
flush();
readfile($Comics.$Comicname.'.zip');
}
exit;
}
?>