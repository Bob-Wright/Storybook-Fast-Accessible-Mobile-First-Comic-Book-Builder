<?php     
echo 'Destroy Storybook2 SESSION<br>';
// Start session
if (isset($_COOKIE['Storybook2'])) {
    unset($_COOKIE['Storybook2']); 
    setcookie('Storybook2', null, -7200, '/'); 
}
session_name('Storybook2');
//include("/home/bitnami/session2DB/Zebra.php");
//if(!isset($_SESSION)) { session_start(); }
    session_unset();
    session_destroy();
?>