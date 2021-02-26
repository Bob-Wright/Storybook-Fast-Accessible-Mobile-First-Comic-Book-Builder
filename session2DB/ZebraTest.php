<?php
    // try to connect to the MySQL server
    $link = mysqli_connect('localhost','root','SOi5MrrH7p8h','Session') or die('Could not connect to database!');
    // include the Zebra_Session class
    require '/home/bitnami/session2DB/Zebra_Session.php';
    // instantiate the class
    // note that you don't need to call the session_start() function
    // as it is called automatically when the object is instantiated
    // also note that we're passing the database connection link as the first argument
    $session = new Zebra_Session($link, 'A_c0dE_4_sEcUr1tY');
    // current session settings
    print_r('<pre><strong>Current session settings:</strong><br><br>');
    print_r($session->get_settings());
    print_r('</pre>');
    // from now on, use sessions as you would normally
    // the only difference is that session data is no longer saved on the server
    // but in your database
    print_r('
        The first time you run the script there should be an empty array (as there\'s nothing in the $_SESSION array)<br>
        After you press "refresh" on your browser, you will see the values that were written in the $_SESSION array<br>
    ');
    print_r('<pre>');
    print_r($_SESSION);
    print_r('</pre>');
    // add some values to the session
    $_SESSION['value1'] = 'hello';
    $_SESSION['value2'] = 'world';
    // now check the table and see that there is data in it!
    // to completely delete a session un-comment the following line
    //$session->stop();
?>