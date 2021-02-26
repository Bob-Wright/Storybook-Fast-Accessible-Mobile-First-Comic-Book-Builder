<?php
/*
 * filename: dumpSession.php
 * this code displays the Comic Builder Session data for debug
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
// Start session
session_name("Storybook");
include("/home/bitnami/session2DB/Zebra.php");

echo
'<html><head></head><body>'.
'<h2>dumpSession</h2>';
	// display all variables unformatted
	//print_r(compact(array_keys(get_defined_vars())));

/*	echo '<pre>';print_r($_SERVER);echo '</pre>';
	echo '<br><br>';
	echo '<pre>';print_r($_REQUEST);echo '</pre>';
	echo '<br><br>';
	echo '<pre>';print_r($_GET);echo '</pre>';
	echo '<br><br>';
	echo '<pre>';print_r($_POST);echo '</pre>';
	echo '<br><br>';
	echo '<pre>';print_r($_COOKIE);echo '</pre>';
	echo '<br><br>';
	echo '<pre>';print_r($_FILES);echo '</pre>';
	echo '<br><br>';
	echo '<pre>';print_r($_ENV);echo '</pre>';
	echo '<br><br>';
	echo '<pre>';print_r($_SESSION);echo '</pre>';
	echo '<br><br>';
	//echo '<pre>';print_r($GLOBALS);echo '</pre>';
	//echo '<br><br>'; */
	echo '<h3>List Cookie Parameters</h3>';
	echo '<pre>';print_r(session_get_cookie_params());echo '</pre>';
	//echo '<br><br>';
	echo '<h3>List All Session Variables</h3>';
	echo '<pre>';print_r(compact(array_keys(get_defined_vars())));echo '</pre>';
	//echo '<br><br>';
?>
<h3>Get browser details using navigator</h3>
	<p id="browserdetails"></p>	
	<script>
//function myFunction() {
	var txt;
	txt = "Browser CodeName: " + navigator.appCodeName + "<br>";
	txt += "Browser Name: " + navigator.appName + "<br>";
	txt += "Browser Version: " + navigator.appVersion + "<br>";
	txt += "Cookies Enabled: " + navigator.cookieEnabled + "<br>";
	txt += "Platform: " + navigator.platform + "<br>";
	txt += "Engine name: " + navigator.product + "<br>";
	txt += "User-agent header: " + navigator.userAgent + "<br>";
    document.getElementById("browserdetails").innerHTML = txt;
//}
	</script>
</body></html>
