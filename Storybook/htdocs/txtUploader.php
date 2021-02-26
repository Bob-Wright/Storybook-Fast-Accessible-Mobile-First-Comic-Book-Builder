<?php
/*
 * filename: txtUploader.php
 * this code processes the text files uploaded by the Upload form
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
// data for verbose report
$rindex = 0;
$report = array();
$Erindex = 0;
$Ereport = array();
$Errindex = 0;
$ErrReport = array();
// ***
// process the upload
// ***
//echo '<script> alert("here we are"); </script>';
$vpb_size_total = 0;
//if(isset($_POST) && $_SERVER['REQUEST_METHOD'] == "POST") {
if (($_SERVER["REQUEST_METHOD"] == "POST") && (!(empty($_POST) && empty($_FILES) && ($_SERVER['CONTENT_LENGTH'] > 0)))) {
	if ((file_exists($_FILES["upload_file"]["tmp_name"])) && (is_uploaded_file($_FILES["upload_file"]["tmp_name"]))) {
	$vpb_file_name = strip_tags($_FILES['upload_file']['name']); //File Name
	$vpb_file_id = strip_tags($_POST['upload_file_ids']); // File id is gotten from the file list
	$vpb_final_location = $uploadDir . $vpb_file_name; //Directory to save file plus the file to be saved
	// move the uploaded file to our folder
	if(move_uploaded_file(strip_tags($_FILES['upload_file']['tmp_name']), $vpb_final_location)) {
			$report[$rindex] = "Uploaded Filename: " . $vpb_file_name . "<br>";
			$rindex = $rindex+1;
	$xmlFile = pathinfo($vpb_file_name);

	// check the filetype/extension, filename length, invalid filenames, and allowed characters
	if (!(preg_match('/txt/i', ($xmlFile['extension'])))) {
			$ErrReport[$Errindex] = "Invalid filetype/extension. ".$vpb_file_name."<br>";$Errindex = $Errindex+1;
			} else {
			$vpb_file_type = $xmlFile['extension'];
			$report[$rindex] = "Uploaded File type: " . $vpb_file_type . "<br>";
			$rindex = $rindex+1;
			}
	$vpb_file_nameLen = (strlen($xmlFile['filename']));
			$report[$rindex] = "Uploaded Filename length: " . $vpb_file_nameLen . "<br>";
			$rindex = $rindex+1;
	if (($vpb_file_nameLen > 255) || ($vpb_file_nameLen == 0)) {
			$ErrReport[$Errindex] = "Invalid filename length.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^(?!^(?:PRN|AUX|CLOCK\$|NUL|CON|COM\d|LPT\d)(?:\..+)?$)(?:\.*?(?!\.))[^\x00-\x1f\\?*:\";|\/<>]+(?<![\s.])$/', $xmlFile['filename']))) {
			$ErrReport[$Errindex] = "Invalid filename.<br>";$Errindex = $Errindex+1;}
	if (!(preg_match('/^([A-Za-z0-9]*[_\-\+\'\.\(\)\s^]?)*$/', ($xmlFile['filename'])))) {
			$ErrReport[$Errindex] = "Invalid filename characters.<br>";$Errindex = $Errindex+1;}

	// minimum-maximum file size
	$minSize = 6;
	if($_SESSION['pageimage'] == 'captions') {
	$maxSize = 3072;
	} else {
	$maxSize = 320;
	}
	$vpb_file_size = $_FILES["upload_file"]["size"];
			$report[$rindex] = "Uploaded Text file size: " . $vpb_file_size . "<br>";
			$rindex = $rindex+1;
	if (($vpb_file_size < $minSize) || ($vpb_file_size > $maxSize)) {
			// echo "File Size out of range."
			$ErrReport[$Errindex] = "File Size out of range.<br>";$Errindex = $Errindex+1;}

	$uploadedText = trim(file_get_contents($uploadDir.$vpb_file_name));
	//echo '<br>'.$uploadedText.'<br>';
	$pattern = '/(\n|\r\n|\r)/';
	$replacement = '[newline]';
	$uploadedText = preg_replace($pattern, $replacement, $uploadedText);
	//sanitize string
	$uploadedText = filter_var($uploadedText, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_BACKTICK);
	if ($uploadedText != '') {
		$pattern = '/\[newline\]/';
		$replacement = '<br>';
		$uploadedText = preg_replace($pattern, $replacement, $uploadedText);
		$_SESSION["uploadedText"] = $uploadedText;
			$commentlength = strlen($uploadedText);
			$report[$rindex] = "Sanitized Text file size: " . $commentlength . "<br>";
			$rindex = $rindex+1;
	} else {
		$_SESSION["uploadedText"] = '';
			// echo invalid string
			$ErrReport[$Errindex] = "Not a valid text string.<br>";$Errindex = $Errindex+1;}
	}

	$Comicname = $_SESSION['Comicname'];
	$pageimage = $_SESSION['pageimage'];
	$comicsDir = '/home/bitnami/Comics/htdocs/';
if(file_exists($uploadDir.$vpb_file_name)) {
	unlink($uploadDir.$vpb_file_name);}
	$pattern = '/\s/';
	$replacement = '';
	$vpb_file_name = preg_replace($pattern, $replacement, $vpb_file_name);
	
	// destination setup
	if(!(is_dir($comicsDir.$Comicname.'/'.$pageimage))) {
		mkdir($comicsDir.$Comicname.'/'.$pageimage, 0775, true);
	}
	$targetDir = $comicsDir.$Comicname.'/'.$pageimage.'/';

	$targetFile = $targetDir.$vpb_file_name;
			$report[$rindex] = "Target file: " . $targetFile . "<br>";
			$rindex = $rindex+1;
	$response = file_put_contents($targetFile, $uploadedText);
	if ($response == FALSE) {
		$ErrReport[$Errindex] = "Failed to write text file.<br>";$Errindex = $Errindex+1;}
	//rename($uploadDir.$vpb_file_name, $targetFile);
	
	$_SESSION['report'] = $report;
	$_SESSION['ErrReport'] = $ErrReport;
	if(empty($ErrReport)) { 
	// notify the user of our success
		//Display the file id
		echo $vpb_file_id;
	} else {
		//Display general system error
		echo 'general_system_error';
	}
}}// end upload handler
exit;

?>