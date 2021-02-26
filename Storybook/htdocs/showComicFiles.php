<?php
/*
 * filename: listComic.php
 * this code lists the Comic Images database files
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
session_name("Storybook");
require_once("/home/bitnami/session2DB/Zebra.php");
//	session_start();
if(isset($_SESSION['Comicname'])) {

require_once("/home/bitnami/includes/ComicImages.class.php");
    $Comic = new ComicImages();

$Comicname = $_SESSION['Comicname'];
echo 'The Comic name is '.$Comicname.'<br>';

$imageList = $Comic->listComicImages($Comicname);
echo '<br>List of records for the Comic name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';

$imageList = $Comic->listComicImages($Comicname, true);
echo '<br>List of records for the extended Comic name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';

/*
$imageList = $Comic->deleteComic($Comicname);
echo '<br>List of DELETED records for the Comic name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';

$imageList = $Comic->listComic($Comicname);
echo '<br>List of records for the Comic name<br>';
echo '<pre>';print_r($imageList);echo '</pre>';
*/
} else {
	echo
	'<br><h1>No SESSION variables!</h1>';
}
?>

