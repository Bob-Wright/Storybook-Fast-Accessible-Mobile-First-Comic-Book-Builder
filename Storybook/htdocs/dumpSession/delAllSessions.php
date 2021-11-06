<?php     
echo
'<html><head>'.
'<style>'.
'*, *:before, *:after, html {box-sizing: border-box;}'.
'body {font-weight: 400; background-color: #EEEFFF; font-size: 1.6vw; width: 100%; height: 100%; overflow-x: hidden;}'.
'span {color: FireBrick;}'.
'</style>'.
'</head><body>'.
'<h1 style="color: MediumBlue;">delSessions</h1>'.
'Deletes all Session Cookies and Sessions for a Domain.<br>';
$cookieName = '';
$cookieKeys = array();
$cookieValues = array();
// always show COOKIE array info
if(empty($_COOKIE)) {
	echo '<span><h3>No $_COOKIE data is present.</h3></span>';
} else {
	// echo '<pre><b>COOKIE</b> ';print_r($_COOKIE);echo '</pre>';
	//echo '<br>';
	// display the cookie data
	//echo '<pre><b>COOKIE Array Values</b>';echo var_dump($_COOKIE);echo '</pre>';
	// echo '<b>All $_COOKIE keys </b>';print_r(array_keys($_COOKIE, !NULL));echo '</pre>';
	$cookieKeys = array_keys($_COOKIE);
	$cookieValues = array_values($_COOKIE);
	echo '<pre><b>$_COOKIE keys </b>';var_dump($cookieKeys);echo '</pre>';
	echo '<pre><b>$_COOKIE values </b>';var_dump($cookieValues);echo '</pre>';
	// handle COOKIE array info
	echo '<pre><b>HTTP_COOKIE Array Values</b>';echo var_dump($_SERVER['HTTP_COOKIE']);echo '</pre>';
	$cookieCount = count(array_keys($_COOKIE));;
	echo '<span><b>There are ' . $cookieCount . ' Session Cookies to delete</span></b></span><br>';
	// unset cookies
	if (isset($_SERVER['HTTP_COOKIE'])) {
		$cookies = explode(';', $_SERVER['HTTP_COOKIE']);
		foreach($cookies as $cookie) {
			$parts = explode('=', $cookie);
			$name = trim($parts[0]);
			setcookie($name, null, time()-360);
			setcookie($name, null, time()-360, '/');
			echo 'Deleted ' . $name . ' Cookie.<br>';
			session_name($name);
			//include("/home/bitnami/session2DB/Zebra.php");
			//if(!isset($_SESSION)) { session_start(); }
				session_unset();
				session_destroy();
			echo 'Destroyed ' . $name . ' Session.<br>';
		}
	}
	echo
	'<span><h3>All domain Cookies deleted and Sessions destroyed.</h3></span>';
}
echo
	'</body></html>';
?>