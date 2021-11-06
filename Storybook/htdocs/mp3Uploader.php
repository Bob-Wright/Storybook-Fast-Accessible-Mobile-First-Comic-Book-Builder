<?php
/*
 * filename: mp3Uploader.php
 * this code processes the mp3 files uploaded by the Upload form
 * we got here by an AJAX call from the javascript form handler
*/
// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");
//	session_start();

// set some variables 
//$Comicname = 'Comic1';
// localpath for the image files
$uploadDir = "/home/bitnami/uploads/";
$_SESSION['uploadDir'] = $uploadDir;
$comicsDir = "/home/bitnami/Comics/htdocs/";

// data for verbose report
$rindex = 0;
$report = array();
$Errindex = 0;
$ErrReport = array();
// ***
// process the upload
// ***
////echo '<script> alert("here we are"); </script>';
$vpb_size_total = 0;
// see if POST and uploaded file
if (($_SERVER["REQUEST_METHOD"] == "POST") && !(empty($_POST)) && !(empty($_FILES)) && ($_SERVER['CONTENT_LENGTH'] > 0) && (file_exists($_FILES["upload_file"]["tmp_name"])) && (is_uploaded_file($_FILES["upload_file"]["tmp_name"]))) {
	$vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
	$vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file list
	$vpb_final_location = $uploadDir . $vpb_file_name; //Directory to save file plus the file to be saved
	// move the uploaded file to our folder
	if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)) {
			$report[$rindex] = "Uploaded Filename: " . $vpb_file_name . "<br>";
			$rindex = $rindex+1;
	$xmlFile = pathinfo($vpb_file_name);
	$fname = $xmlFile['filename'];
	$vpb_file_type = $xmlFile['extension'];

	// check the filetype/extension, filename length, invalid filenames, allowed characters, and minimum-maximum file size
	// check for an audio file
	if (!((preg_match('/mp3/i', $xmlFile['extension'])) && ($_SESSION['pageimage'] == 'altImgs'))) {
		$ErrReport[$Errindex] = "Invalid filetype/extension. ".$vpb_file_name."<br>";$Errindex = $Errindex+1;}
	$vpb_file_nameLen = (strlen($xmlFile['filename']));
		$report[$rindex] = "Uploaded Filename length: " . $vpb_file_nameLen . "<br>";
		$rindex = $rindex+1;
	if (($vpb_file_nameLen > 255) || ($vpb_file_nameLen = 0)) {
			$ErrReport[$Errindex] = "Invalid filename length.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^(?!^(?:PRN|AUX|CLOCK\$|NUL|CON|COM\d|LPT\d)(?:\..+)?$)(?:\.*?(?!\.))[^\x00-\x1f\\?*:\";|\/<>]+(?<![\s.])$/', $xmlFile['filename']))) {
			$ErrReport[$Errindex] = "Invalid filename.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^([A-Za-z0-9]*[!_\+\.\(\)\s^]?)*$/', ($xmlFile['filename'])))) {
			// removed dashes we use as delimiters from permitted list
			$ErrReport[$Errindex] = "Invalid filename characters.<br>";$Errindex = $Errindex+1;}
	if (preg_match('/\s/', $xmlFile['filename'])) {
		$fname = preg_replace("/\s+/", "_", $fname); // convert spaces
		rename($uploadDir.$vpb_file_name, $uploadDir.$fname.'.'.$vpb_file_type);
			$vpb_file_name = $fname.'.'.$vpb_file_type;
			$report[$rindex] = "Replaced spaces: " . $uploadDir.$fname.'.'.$vpb_file_type . "<br>";
			$rindex = $rindex+1;}

		// need the getID3 CLASS in getid3.php
		include("/home/bitnami/includes/getID3/getid3.php");
		// Initialize getID3 engine
        $getID3 = new getID3;
        $ThisFileInfo = $getID3->analyze($uploadDir.$vpb_file_name);
			$report[$rindex] = "Analyzed MP3 file ".$vpb_file_name."<br>";
			$rindex = $rindex+1;
		if(array_key_exists('error', $ThisFileInfo)) {
			$ErrReport[$Errindex] = "An MP3 file error was found<br>";$Errindex = $Errindex+1;
		} else {
			$report[$rindex] = "MP3 file checks OK<br>";
			$rindex = $rindex+1; }
		//$report[$rindex] = "<pre><b>File info </b>';var_dump($ThisFileInfo);echo '</pre><br>";
		//$rindex = $rindex+1;

		$minSize = 1024; $maxSize = 10485760;
		$vpb_file_type = "mp3";
		$vpb_file_size = $_FILES["upload_file"]["size"];
			$report[$rindex] = "Uploaded MP3 file size: " . $vpb_file_size . "<br>";
			$rindex = $rindex+1;
		if (($vpb_file_size < $minSize) || ($vpb_file_size > $maxSize)) {
			// echo "File Size out of range."
			$ErrReport[$Errindex] = "MP3 File Size out of range.<br>";$Errindex = $Errindex+1;}
		// MP3 goes in ALT images folder
		
			$Comicname = $_SESSION['Comicname'];
			$pageimage = $_SESSION['pageimage'];
			// destination setup
			if(!(is_dir($comicsDir.$Comicname.'/'.$pageimage))) {
				mkdir($comicsDir.$Comicname.'/'.$pageimage, 0775, true);}
			$targetDir = $comicsDir.$Comicname.'/'.$pageimage.'/';
			rename($uploadDir.$vpb_file_name, $targetDir.$vpb_file_name);
			$report[$rindex] = "Target file: " . $targetDir.$vpb_file_name . "<br>";
			$rindex = $rindex+1;
		
	//if(file_exists($uploadDir.$vpb_file_name)) {
	//unlink($uploadDir.$vpb_file_name);}
	//rmdircontent($uploadDir);

	$_SESSION['report'] = $report;
	$_SESSION['ErrReport'] = $ErrReport;
	//$_SESSION['Comicname'] = $Comicname;

	if(empty($ErrReport)) { 
		//Display the file id
		echo $vpb_file_id;
	} else {
		//Display general system error
		echo 'general_system_error';
	}
}; // got an upload
}; // end POST
return;

function rmdircontent($dir) {
	if (is_dir($dir)) {
	  $objects = scandir($dir);
	  foreach ($objects as $object) {
		if ($object != "." && $object != "..") {
		  if (filetype($dir."/".$object) == "dir") 
			 rrmdir($dir."/".$object); 
		  else unlink($dir."/".$object);
		}
	  }
	  reset($objects);
	  //rmdir($dir);
	}
}
?>