<?php
/*
 * createComicDataBase.php
 * create a db
*/
	// Database configuration
    $dbHost     = 'localhost'; //Database_Host
    $dbUsername = 'user'; //Database_Username
    $dbPassword = 'password'; //Database_Password

	// Connect to the server
	$conn = new mysqli($dbHost, $dbUsername, $dbPassword);
	if($conn->connect_error){ // limit information displayed on error
		die("Failed to connect with server. "/* . $conn->connect_error*/);
	} else { echo "Connected to server<br>";}
	/* --------------------
	 Create the database
	*/
	$sql = "CREATE DATABASE comicdata";
	if ($conn->query($sql) === TRUE) {
		echo "Database created successfully<br>";
	} else {
		echo "Error creating database: <br>"; // leave off $conn->error;
	}
	$conn->close();
?>