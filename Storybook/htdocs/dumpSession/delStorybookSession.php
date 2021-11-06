<?php     
echo 'Destroy Storybook SESSION';
// Start session
if (isset($_COOKIE['Storybook'])) {
    unset($_COOKIE['Storybook']); 
    setcookie('Storybook', null, -7200, '/'); 
}
session_name('Storybook');
//include("/home/bitnami/session2DB/Zebra.php");
//if(!isset($_SESSION)) { session_start(); }
    session_unset();
    session_destroy();
?>