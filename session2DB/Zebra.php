<?php
/*
 * open the session
 * connect to session_data
*/
require_once (__DIR__).'/linkZSession_DataTable.php';
// include the Zebra_Session class
require (__DIR__).'/Zebra_Database.php';
require (__DIR__).'/Zebra_Session.php';
// instantiate the class
// note that you don't need to call the session_start() function
// as it is called automatically when the object is instantiated
// also note that we're passing the database connection link as the first argument
$session = new Zebra_Session($link, 'A_c0dE_4_sEcUr1tY');
// current session settings
/*	print_r('<pre><strong>Current session settings:</strong><br><br>');
	print_r($session->get_settings());
	print_r('</pre>');
*/
?>