<?php     
echo
'<html><head>'.
'<style>'.
'*, *:before, *:after, html {box-sizing: border-box;}'.
'body {font-weight: 400; background-color: #EEEFFF; font-size: 1.6vw; width: 100%; height: 100%; overflow-x: hidden;}'.
'span {color: FireBrick;}'.
'</style>'.
'</head><body>'.
'<h1 style="color: MediumBlue;">makeOneSession</h1>'.
'Makes one specified Session Cookie and Session for a Domain.<br>'.
'If the Cookie/Session already exists it will be joined/restarted by this script.<br>';

$Sname = '';
if(getenv('QUERY_STRING') == '') {
	echo
	'<p><span><b>The name of the specific Cookie/Session to make or join must be provided.</b></span><br>'.
	'Use <span><b>makeOneSession.php?Sname=session-to-make</b></span> to specify the Cookie/Session name.</p>';
}
if(getenv('QUERY_STRING') != '') {
	// parse query
	$qstring = getenv('QUERY_STRING');
	// echo '<p>'.$qstring.'</p>';
	parse_str($qstring, $pstrings);
	// see if valid URL query string
	if(array_key_exists('Sname', $pstrings)) {
		$Sname = $pstrings['Sname'];} // desired session name
	// Start or join session
	session_name($Sname);
	session_start();
	//require_once("/home/bitnami/session2DB/Zebra.php");
	echo 'A Session named <span><b>' . $Sname . '</b></span> was started.<br>';
}
echo
	'</body></html>';
?>