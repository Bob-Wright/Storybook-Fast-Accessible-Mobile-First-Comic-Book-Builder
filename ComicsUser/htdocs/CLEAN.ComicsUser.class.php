<?php
/*
 * ComicsUser Class
 * This class is used for user database related (connect, insert, read, update, and delete) operations
*/

// disable error reporting for production code
error_reporting(E_ALL);
ini_set('display_errors', TRUE);

	/*
	TABLE `comicsusers`
	  `id`KEY,
	  `oauth_provider`
	  `oauth_id`
	  `name`
	  `first_name`
	  `last_name`
	  `email`
	  `views`
	  `posts`
	  `picture`
	  `link`
	  `created`
	  `modified`
	*/

class ComicsUser {
	// Database configuration
    private $dbHost     = 'localhost'; //MySQL_Database_Host
    private $dbUsername = 'user'; //MySQL_Database_Username
    private $dbPassword = 'password'; //MySQL_Database_Password
    private $dbName     = 'comicsusers'; //MySQL_Database_Name
    private $userTbl    = 'comicsusers';

    function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){ // limit information displayed on error
                die("Failed to connect with database. "/* . $conn->connect_error*/);
            }else{
                $this->db = $conn;
            }
        }
    }

	/* --------------------
	create the users table
	*/
public function createTable(){
   // Check whether user data already exists in database
	$checkQuery = "SELECT * FROM ".$this->userTbl;
		// echo $prevQuery."<br>";
	$checkResult = $this->db->query($checkQuery);
	if($checkResult != NULL){
	$drop = "DROP TABLE `".$this->userTbl."`;";
		if ($this->db->query($drop) === TRUE) {
				echo "User Table dropped successfully<br>";
				} else {
				echo "Error dropping User Table: <br>"; // leave off $conn->error;
	}}
	$sql =
	"CREATE TABLE IF NOT EXISTS `comicsusers` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `oauth_provider` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `oauth_id` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `views` int(11) NOT NULL DEFAULT 0,
	  `posts` int(11) NOT NULL DEFAULT 0,
	  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `link` varchar(55) COLLATE utf8mb4_unicode_ci NOT NULL,
	  `created` datetime DEFAULT NULL,
	  `modified` datetime NOT NULL
	) COLLATE=utf8mb4_unicode_ci;
	";
	if ($this->db->query($sql) === TRUE) {
		echo "User Table created successfully<br>";
		} else {
		echo "Error creating User Table: <br>"; // leave off $conn->error;
	}
}
	
	// ---------------------------------
	// insert or update a user record
public function checkUser($userData = array()){
	if(!empty($userData)){
		// Check whether user data already exists in database
		//echo "oauth_id : ".$userData['oauth_id']."<br>";
		$prevQuery = "SELECT * FROM ".$this->userTbl." WHERE oauth_id = '".$userData['oauth_id']."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows > 0){
			//echo "update userData<br>";
			// Update user data already exists
			$query = "UPDATE ".$this->userTbl." SET oauth_provider = '".$userData['oauth_provider']."', name = '".$userData['name']."', first_name = '".$userData['first_name']."', last_name = '".$userData['last_name']."', email = '".$userData['email']."', picture = '".$userData['picture']."', link = '".$userData['link']."', modified = NOW() WHERE oauth_id = '".$userData['oauth_id']."'";
			//echo $query."<br>";
			$update = $this->db->query($query);
		}else{
			//echo "insert userData<br>";
			// Insert user data
			$query = "INSERT INTO ".$this->userTbl." ( oauth_provider, oauth_id, name, first_name, last_name, email, picture, link, created, modified) VALUES ('".$userData['oauth_provider']."', '".$userData['oauth_id']."',  '".$userData['name']."', '".$userData['first_name']."', '".$userData['last_name']."', '".$userData['email']."', '".$userData['picture']."', '".$userData['link']."', NOW(), NOW())";
			//$query = '"'.$query.'"';
			//echo $query."<br>";
			$insert = $this->db->query($query);
			/*if ($insert === TRUE) {
				echo "User inserted successfully<br>";
			} else {
			echo 'User insert failed<br>';}*/
		}
		// Get user data from the database
		$result = $this->db->query($prevQuery);
		$userData = $result->fetch_assoc();
		//echo 'UserData is '.$userData.'<br>';
	}
	// Return user data
	return $userData;
}

	// ---------------------------------
	// count user records
public function userCount(){
	//$count = $con->query($sql)->fetch_row()[0];
	$countQuery = "SELECT COUNT(*) FROM ".$this->userTbl."";
	$count = $this->db->query($countQuery)->fetch_row()[0];
	/* determine number of rows in result set */
	// printf("Result set has %d rows.<br>", $prevResult->num_rows);
	//echo $count;		
	return $count;
}

	// ---------------------------------
	// return a user record
public function returnUser($userData){
	if(!empty($userData)){
		// Check whether user data exists in database
		//echo "oauth_id : ".$userData['oauth_id']."<br>";
		$Query = "SELECT * FROM `".$this->userTbl."` WHERE oauth_id = '".$userData."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result->num_rows == 1) {
		// Get user data from the database
		$result = $this->db->query($Query);
		$userData = $result->fetch_assoc();
		}
	}
	// Return user data
	return $userData;
    }

	// ---------------------------------
	// update posts in a user record
public function updatePosts($userData,$count){
	if(!empty($userData)){
		// Check whether user data already exists in database
		//echo "oauth_id : ".$userData['oauth_id']."<br>";
		$prevQuery = "SELECT * FROM `".$this->userTbl."` WHERE oauth_id = '".$userData."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		//printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// Update user data if already exists
			// change posts = '".$userData['posts']."'
			$query = "UPDATE `".$this->userTbl."` SET posts = GREATEST(posts+".$count.", 0), modified = NOW() WHERE oauth_id = '".$userData."'";
			$update = $this->db->query($query);
		}
		// Get user data from the database
		$result = $this->db->query($prevQuery);
		$userData = $result->fetch_assoc();
	}
	// Return user data
	return $userData;
    }

	// ---------------------------------
	// update comicname in a user record
public function updateComic($userData,$comicname){
	if(!empty($userData)){
		// Check whether user data already exists in database
		//echo "oauth_id : ".$userData['oauth_id']."<br>";
		$prevQuery = "SELECT * FROM `".$this->userTbl."` WHERE oauth_id = '".$userData."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		//printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// Update user data if already exists
			$query = "UPDATE `".$this->userTbl."` SET gallery_name = '".$comicname."', modified = NOW() WHERE oauth_id = '".$userData."'";
			$update = $this->db->query($query);
		}
		// Get user data from the database
		$result = $this->db->query($prevQuery);
		$userData = $result->fetch_assoc();
	}
	// Return user data
	return $userData;
    }

	// ---------------------------------
	// update views in a user record
public function updateViews($userData){
	if(!empty($userData)){
		// Check whether user data already exists in database
		//echo "oauth_id : ".$userData['oauth_id']."<br>";
		$prevQuery = "SELECT * FROM `".$this->userTbl."` WHERE oauth_id = '".$userData."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// Update user data if already exists
			// change views = '".$userData['views']."'
			$query = "UPDATE `".$this->userTbl."` SET views = views+1, modified = NOW() WHERE oauth_id = '".$userData."'";
			$update = $this->db->query($query);
		}
		// Get user data from the database
		$result = $this->db->query($prevQuery);
		$userData = $result->fetch_assoc();
	}
	// Return user data
	return $userData;
    }

	// ---------------------------------
	// delete a user record
public function deleteUser($userData){
	if(!empty($userData)){
		// Check whether user data already exists in database
		//echo "oauth_id : ".$userData['oauth_id']."<br>";
		$prevQuery = "SELECT * FROM `".$this->userTbl."` WHERE oauth_id = '".$userData."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// delete user data if exists
			// change views = '".$userData['views']."'
			$query = "DELETE FROM `".$this->userTbl."` WHERE oauth_id = '".$userData."'";
			$delete = $this->db->query($query);
		}
		// Get user data from the database
		$result = $this->db->query($prevQuery);
		$userData = $result->fetch_assoc();
	}
	// Return user data
	return $userData;
    }
/* close connection */
//$mysqli->close();
}
?>