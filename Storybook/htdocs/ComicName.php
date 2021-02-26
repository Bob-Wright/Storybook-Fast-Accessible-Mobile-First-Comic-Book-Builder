<?php
/*
 * filename: ComicName.php
 * this code saves the SQL database Comic name
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

// set fallback variable
//$Comicname = 'AnImageComic'; //fallback
if (($_SERVER["REQUEST_METHOD"] == "POST") && ($_POST['Comicname'] == '')) { // empty POST then fallback value
		$_SESSION["Comicname"] = '';
		header("Refresh: 1; URL=./index.php");
		echo "<h2>$Comicname is <strong>NOT</strong> a valid string.</h2>";
}

if (($_SERVER["REQUEST_METHOD"] == "POST") && (isset($_POST['Comicname'])) && ($_POST['Comicname'] != '')) {
	$Comicname = trim($_POST['Comicname']);
	//sanitize string
	if (preg_match('/^([A-Za-z0-9]+$)/', $Comicname)) {
		$_SESSION["Comicname"] = $Comicname;
		$returnMsg = "<h2>$Comicname is a valid string.</h2>";

		// list of galleries
		$ComicsBase = '/home/bitnami/Comics/htdocs/';
		if ($handle = opendir($ComicsBase)) {
			//echo "Directory handle: $handle\n";
			//echo "Entries:\n";

			/* loop over the directory. */
			while (false !== ($entry = readdir($handle))) {
				if(!(is_dir($ComicsBase.$entry))) {
					$filenameArray = explode('.', $entry);
					// check the filetype/extension for HTML files
					if (preg_match('/html/i', $filenameArray[1])) {
						//$navmenu .= '<li class="menuEntry"><a href="./Comics/'.$entry.'">'.$filenameArray[0].'</a></li>';
						if ($Comicname == $filenameArray[0]) {
							$returnMsg = "<h2>$Comicname is already being used!</h2>";
							$Comicname = '';
							$_SESSION["Comicname"] = $Comicname;
						}
					}
				}
			}
		closedir($handle);
		}

	} else {
		$_SESSION["Comicname"] = '';
		$returnMsg = "<h2>$Comicname is <strong>NOT</strong> a valid string.</h2>";
	}

	header("Refresh: 0; URL=./index.php");
	echo $returnMsg;
}
?>
