<?php     
echo
'<html><head>'.
'<style>'.
'*, *:before, *:after, html {box-sizing: border-box;}'.
'body {font-weight: 400; background-color: #EEEFFF; font-size: 1.6vw; width: 100%; height: 100%; overflow-x: hidden;}'.
'span {color: FireBrick;}'.
'</style>'.
'</head><body>'.
'<h1 style="color: MediumBlue;">delOneSession</h1>'.
'Deletes one specified Session Cookie and Session for a Domain.<br>';

$Sname = '';
if(getenv('QUERY_STRING') == '') {
	echo
	'<p><b>If more than one Cookie/Session is present, the name of the<br>'.
	'specific Cookie/Session to delete must be provided.</b><br>'.
	'Use <span><b>delOneSession.php?Sname=session-to-delete</b></span> to specify the Cookie/Session name.<br>'.
	'If only one Cookie/Session is present you may omit the query,<br>'.
	'and use <span><b>delOneSession.php</b></span> to delete that Cookie and Session.</p>';
}
if(getenv('QUERY_STRING') != '') {
	// parse query
	$qstring = getenv('QUERY_STRING');
	// echo '<p>'.$qstring.'</p>';
	parse_str($qstring, $pstrings);
	// see if valid URL query string
	if(array_key_exists('Sname', $pstrings)) {
		$Sname = $pstrings['Sname'];} // desired session name
}
$cookieName = '';
$cookieKeys = array();
$cookieValues = array();
$SessionName = '';
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
	$cookieCount = count(array_keys($_COOKIE));
	$cookieName = $cookieKeys[0];
	echo '<pre><b>$_COOKIE keys </b>';var_dump($cookieKeys);echo '</pre>';
	echo '<pre><b>$_COOKIE values </b>';var_dump($cookieValues);echo '</pre>';
	// handle COOKIE array info
	echo '<pre><b>HTTP_COOKIE Array Values</b><br>';echo var_dump($_SERVER['HTTP_COOKIE']);echo '</pre>';
	echo '<span><b>There are ' . $cookieCount . ' Session Cookies</span></b></span><br>';

	if($cookieCount == 1) {
		 // if we have current cookie info this is session_name
		echo '<b>There is one $_COOKIE key named <span>' . $cookieName . '</b></span><br>';
		if($Sname == '') {
			echo
			'No Requested Session Name query, deleting the present Cookie/Session.<br>';
			$SessionName = $cookieName;
		}
		if(($Sname != '') && ($Sname != $cookieName)) {
			echo
			'<span>The Requested Session Name is not the same as the COOKIE key!</span><br>'.
			'No Cookie/Session deletions will be performed.<br>';
			$SessionName = '';
		}
		if($Sname == $cookieName) {
			echo
			'The Requested Session Name is the same as the present COOKIE key,<br>'.
			'deleting the present Cookie/Session.<br>';
			$SessionName = $cookieName;
		}
	} else {
		echo
		'<b>There are Multiple Session Cookies</b><br>';
		if($Sname == '') {
			echo
				'<p><b>No Cookie/Session name is specified!</b><br>'.
				'If more than one Cookie/Session is present, the name of the<br>'.
				'specific Cookie/Session to delete must be provided.<br>'.
				'Use <span><b>delOneSession.php?Sname=session-to-delete</b></span> to specify the Cookie/Session name.<br>'.
				'<span>Please reload <b>delOneSession.php</b> with a choice of session name for deletion.</span><br></p>';
				$SessionName = ''; }
		if(!empty($Sname)) {
			// see if valid URL query string
			if(array_key_exists($Sname, $_COOKIE)) {
				echo
					'Requested Session is same as an existing COOKIE key. Deleting the Requested Session.<br>';
					$SessionName = $Sname;
			}
		}
	}	
	// delete Cookie and Session
	if ($SessionName != '') {
		setcookie($SessionName, null, time()-360);
		setcookie($SessionName, null, time()-360, '/');
		echo 'Deleted ' . $SessionName . ' Cookie.<br>';
		session_name($SessionName);
		//include("/home/bitnami/session2DB/Zebra.php");
		//if(!isset($_SESSION)) { session_start(); }
			session_unset();
			session_destroy();
		echo 'Destroyed ' . $SessionName . ' Session.<br>';
		echo '<span><h3>Selected Cookie deleted and Session destroyed.</h3></span>';
	}
}

echo
	'</body></html>';
?>