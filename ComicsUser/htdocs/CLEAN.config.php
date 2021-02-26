<?php
/*
 * Basic Site Settings and API Configuration
*/

// disable error reporting for production
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

// Start session
//session_name("Storybook");
//require_once("/home/bitnami/session2DB/Zebra.php");

/*if(!isset($_SESSION['accesses'])) {
$_SESSION['accesses'] = 0; // initialize it
} else {
$_SESSION['accesses']++;}*/

// Include the autoloader provided in the SDK
require_once '/home/bitnami/Facebook/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

// Facebook API configuration
define('FB_APP_ID', '1297101973789783');
define('FB_APP_SECRET', 'you need to use your secret');
define('FB_REDIRECT_URL', 'https://syntheticreality.net/Storybook/');
define('PAGE_URL', 'OauthPortal.php');

define('FB_APP_URL', 'https://syntheticreality.net/');

// Call Facebook API
$fb = new Facebook(array(
    'app_id' => FB_APP_ID,
    'app_secret' => FB_APP_SECRET,
    'default_graph_version' => 'v8.0',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();
	//if(isset($helper)) {echo '<p>helperData<br>'; print_r($helper); echo'</p>';
	// security function
	if (isset($_GET['state'])) {$helper->getPersistentDataHandler()->set('state', $_GET['state']);}
	$permissions = ['email']; // Optional permissions

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
        $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error getting access token: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error getting access token: ' . $e->getMessage();
      exit;
}
?>