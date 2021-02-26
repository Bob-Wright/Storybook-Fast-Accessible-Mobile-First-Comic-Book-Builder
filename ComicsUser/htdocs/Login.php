<?php
/*
 * Login.php
 * this code processes the facebook user authentication
*/

// Start session
//session_name("Storybook");
//require_once("/home/bitnami/session2DB/Zebra.php");

/*if(!isset($_SESSION['accesses'])) {
$_SESSION['accesses'] = 0; // initialize it
} else {
$_SESSION['accesses']++;}*/

/* ----------------------------------------- */
$FBloginButton = '';
$output = '';
$loginGood = FALSE;

//require_once 'config.php';
require_once '/home/bitnami/ComicsUser/htdocs/config.php';
// Include get IP file
//require_once 'get_ip_address.php';
require_once '/home/bitnami/ComicsUser/htdocs/get_ip_address.php';
// Include User class
require_once '/home/bitnami/ComicsUser/htdocs/ComicsUser.class.php';
    // Initialize User class
    // $user = new User();

//if(isset($_SESSION['accessToken'])) { //echo '<p>SESSION userData<br>'; print_r($_SESSION['accessToken']); echo'</p>';}
if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;
        
          // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();
        
        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
        
        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }
    
    // Redirect the user back to the same page if url has "code" parameter in query string
    if(isset($_GET['code'])){
        header('Location: ./OauthPortal.php');
    }
    
    // Getting user's profile info from Facebook
    try {
        $graphResponse = $fb->get('/me?fields=name,first_name,last_name,email,picture');
        $fbUser = $graphResponse->getGraphUser();
        // echo 'Graph returned user profile info.';
    } catch(FacebookResponseException $e) {
        echo 'Graph returned an error getting user profile info: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location: ./");
        exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error getting user profile info: ' . $e->getMessage();
        exit;
    }
    
    // Initialize User class
    $user = new ComicsUser();
    
    // Getting user's profile data
    $fbUserData = array();
    $fbUserData['oauth_id']   = !empty($fbUser['id'])?$fbUser['id']:'';
    $fbUserData['name']		  =	!empty($fbUser['name'])?$fbUser['name']:'';
    $fbUserData['first_name'] = !empty($fbUser['first_name'])?$fbUser['first_name']:'';
    $fbUserData['last_name']  = !empty($fbUser['last_name'])?$fbUser['last_name']:'';
    $fbUserData['email']      = !empty($fbUser['email'])?$fbUser['email']:'';
    $fbUserData['picture']    = !empty($fbUser['picture']['url'])?$fbUser['picture']['url']:'';

	// get the users's IP address
	$link = get_ip_address();
    $fbUserData['link'] = $link;
    $fbUserData['oauth_provider'] = 'Facebook';
    
    // Insert or update user data to the database
    $userData = $user->checkUser($fbUserData);
    // Storing user data in the session
    $_SESSION['userData'] = $userData;
	// see how many users we have before we add this one
	$userCount = $user->userCount();
    // Get logout url
    $logoutURL = $helper->getLogoutUrl($accessToken, FB_APP_URL.'ComicsUser/logout.php');
    $_SESSION['logoutURL'] = $logoutURL;
	
    // Render Facebook profile data
    if(!empty($userData)){
        $output .= '<div class="user-data"><br>';
        $output .= '<div id="profileHdr"><span><img id="profilePic" src="'.$userData['picture'].'" alt="FB user profile image"></span><span id="profileTitl"><h2>Profile Data Details</h2></span></div>';
        $output .= '<div id="profileData"><br>';
		$output .= '<p><b>Facebook ID:</b> '.$userData['oauth_id'].'<br>';
        $output .= '<b> Full Name:</b> '.$userData['name'].'<br>';
        $output .= '<b>Name:</b> '.$userData['first_name'].' '.$userData['last_name'].'<br>';
        $output .= '<b>Email:</b> '.$userData['email'].'<br>';
        $output .= '<b>Posts:</b> '.$userData['posts'].'<br>';
        $output .= '<b>Views:</b> '.$userData['views'].'<br>';
        $output .= '<b>User IP:</b> '.$userData['link'].'</p>';
        //$output .= '<b>Comic Name:</b> '.$userData['gallery_name'].'</p>';
		$output .= '<p>This data will be associated with your account.</p>';
		$output .= '<p>The number of Hosted Users is '.$userCount.'.</p>';
        $output .= '</div>';
        $output .= '<div id="FBlogoutButton"><a href="'.$logoutURL.'"><img id="logoutButton" src="../ComicsUser/Images/facebook-logout-button.png" alt="Facebook logout button" title="Logout using Facebook"></a></div>';
        $output .= '</div>';
		$_SESSION['output'] = $output;
		$_SESSION['oauth_id'] = $userData['oauth_id'];
		$_SESSION['posts'] = $userData['posts'];
		$loginGood = TRUE;
	}else{ // show problem status
		$output = '<h1 class="loginError">A problem occurred, please try again.</h1><br>';}
} else {
    // Render Facebook login button
	//echo FB_REDIRECT_URL;
	// get our location from the session
	$loginURL = $helper->getLoginUrl(FB_REDIRECT_URL.PAGE_URL, $permissions);
    $FBloginButton = '<a href='.htmlspecialchars($loginURL).'><img id="loginButton" src="../ComicsUser/Images/facebook-sign-in-button.png" alt="Facebook login button" title="Logon using Facebook"></a>';
	//$_SESSION['FBloginButton'] = $FBloginButton;
}
?>