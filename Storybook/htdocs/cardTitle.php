<?php
/*
 * filename: cardTitle.php
 * this code saves the Comic name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['cardTitle'] == '')) { // empty POST then fallback value
	$_SESSION["cardTitle"] = '';
	header("Refresh: 1; URL=./index.php#cardTitle");
	echo "A valid Title is required.<br/><br/>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['cardTitle'])) && ($_POST['cardTitle'] != '')) {
	$cardTitle = trim($_POST['cardTitle']);
	if(strlen($cardTitle) > 64) {$cardTitle = '';}
	//sanitize string
	$cardTitle = filter_var($cardTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if (!(preg_match('/^([A-Za-z0-9,_\-\s ]+$)/', $cardTitle))) {
	//if ($cardTitle == '') {
		$_SESSION["cardTitle"] = $cardTitle;
		header("Refresh: 1; URL=./index.php#cardTitle");
		echo "A valid Title is required.<br/><br/>";
	} else {
		$_SESSION["cardTitle"] = $cardTitle;
		echo "$cardTitle is a valid Title.<br/><br/>";
	}

	$Comicname = preg_replace("/\s+/", "", $cardTitle);
	//sanitize string
	if(preg_match('/^([A-Za-z0-9,_\-]+$)/', $Comicname)) {
		$_SESSION["Comicname"] = $Comicname;
		$returnMsg = "<h2>$Comicname is a valid URL string.</h2>";
	} else {
		$_SESSION["Comicname"] = '';
		$returnMsg = "<h2>A valid Title is required.</h2>";
		header("Refresh: 1; URL=./index.php#cardTitle");
		echo $returnMsg;
	}
	// list of comics
	$comicsbase = '/home/bitnami/Comics/htdocs/';
	if($handle = opendir($comicsbase)) {
		//echo "Directory handle: $handle\n";
		//echo "Entries:\n";
		// loop over the directory.
		while (false !== ($entry = readdir($handle))) {
			if((is_file($comicsbase.$entry)) && ($entry == $Comicname)) {
					$returnMsg = "<h2>$Comicname is already being used!</h2>";
					//$Comicname = '';
					$_SESSION["Comicname"] = $Comicname;
			}
		}
	closedir($handle);
	}
header("Refresh: 0; URL=./index.php#cardTitle");
echo $returnMsg;
}
?>
