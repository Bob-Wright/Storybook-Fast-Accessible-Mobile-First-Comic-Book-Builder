<?php
error_reporting(E_ALL); // disable this for production code
ini_set('display_errors', TRUE);
/*
 * Comic Class
 * This class is used for comic database related (connect, read, insert, update, and delete) operations
*/
	/*	TABLE `comicdata`
	 `comic_id`
	 `oauth_id`
	 `comic_name`
	 `comic_title`
	 `comic_subtitle`
	 `comic_category`
	 `comic_author`
	 `comic_script`
	 `comic_pencils`
	 `comic_inks`
	 `comic_coloring`
	 `comic_lettering`
	 `comic_publisher`
	 `comic_audience`
	 `artistname`
	 `cardemail`
	 `created`
	 `lastview`
	 `views`
	*/

class Comic {
	// Database configuration
    private $dbHost     = 'localhost'; //MySQL_Database_Host
    private $dbUsername = 'user'; //MySQL_Database_Username
    private $dbPassword = 'password'; //MySQL_Database_Password
    private $dbName     = 'comicdata'; //MySQL_Database_Name
    private $comicTbl   = 'comicdata';

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
	create the comic table
	*/
public function createTable(){
   // Check whether user comic data already exists in database
	$checkQuery = "SELECT * FROM ".$this->comicTbl;
		// echo $prevQuery."<br>";
	$checkResult = $this->db->query($checkQuery);
	if($checkResult != NULL){
	$drop = "DROP TABLE ".$this->comicTbl.";";
		if ($this->db->query($drop) === TRUE) {
				echo "Comic Table dropped successfully<br>";
				} else {
				echo "Error dropping Comic Table: <br>"; // leave off $conn->error;
	}}
	$sql =
	 "CREATE TABLE IF NOT EXISTS `comicdata` (
	 `comic_id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	 `oauth_id` varchar(24) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_title` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_subtitle` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_category` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_author` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_script` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_pencils` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_inks` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_coloring` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_lettering` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_publisher` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `comic_audience` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `artistname` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `cardemail` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
	 `created` datetime DEFAULT NULL,
	 `lastview` datetime DEFAULT NULL,
	 `views` int(11) DEFAULT NULL
	) COLLATE=utf8mb4_unicode_ci;
	";
	if ($this->db->query($sql) === TRUE) {
		echo "Comic Table created successfully<br>";
		} else {
		echo "Error creating Comic Table: <br>"; // leave off $conn->error;
	}
}
	
	// ----------------------------
	// insert comic data into table
public function insertComic($comicData){
	if(!empty($comicData)){
		// Check whether user comic data already exists in database
		$prevQuery = "SELECT * FROM `".$this->comicTbl."` WHERE oauth_id = '".$comicData['oauth_id']."' AND comic_name = '".$comicData['comic_name']."'";
		//$_SESSION['prevQuery'] = $prevQuery;
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 0){
			// Insert comic data
			$query = "INSERT INTO `".$this->comicTbl."` (oauth_id, comic_name, comic_title, comic_subtitle, comic_category, comic_author, comic_script, comic_pencils, comic_inks, comic_coloring, comic_lettering, comic_publisher, comic_audience, artistname, cardemail, created) VALUES ('".$comicData['oauth_id']."', '".$comicData['comic_name']."', '".$comicData['comic_title']."', '".$comicData['comic_subtitle']."', '".$comicData['comic_category']."', '".$comicData['comic_author']."', '".$comicData['comic_script']."', '".$comicData['comic_pencils']."', '".$comicData['comic_inks']."', '".$comicData['comic_coloring']."', '".$comicData['comic_lettering']."', '".$comicData['comic_publisher']."', '".$comicData['comic_audience']."', '".$comicData['artistname']."', '".$comicData['cardemail']."', now())";
			$insert = $this->db->query($query);
			/*	$_SESSION['insertQuery'] = $query;
			if ($insert === TRUE) {
				$_SESSION['resultMsg'] = "Record updated successfully";
				//$_SESSION['insertCount'] = $_SESSION['insertCount'] + 1;
			} else {
				$_SESSION['resultMsg'] = "Error updating record"; // leave off $conn->error;
			} */
		}
		// Get comic data from the database
		$result = $this->db->query($prevQuery);
		$comicData = $result->fetch_assoc();
	}
    // Return comic data
    return $comicData;
}

	// ---------------------------------
	// return an array of comic names
public function listComic($comic_name){
	if(!empty($comic_name)){
		// comic data exists in database
		$comicData = array();
		// execute function
			$Query = "SELECT * FROM `".$this->comicTbl."` WHERE comic_name LIKE '".$comic_name."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // comic name values into an array
			while($arr = $Result->fetch_assoc()) {
				$comicData[] = $arr['comic_name'];
			}
			$_SESSION['listcomicResult'] = $comicData;
		}
	// Return comic data
	return $comicData;
	}
}

	// ---------------------------------
	// return an array of comic names by oauth_id
public function listOauthcomic($oauth_id) {
	if(!empty($oauth_id)){
		// comic data exists in database
		$comicData = array();
		// execute function
		$Query = "SELECT * FROM `".$this->comicTbl."` WHERE oauth_id LIKE '".$oauth_id."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // comic name values into an array
			while($arr = $Result->fetch_assoc()) {
				$comicData[] = $arr['comic_name'];
			}
			$_SESSION['listcomicResult'] = $comicData;
		}
	// Return comic data
	return $comicData;
	}	
}

	// ---------------------------------
	// return an array of comic names and oauth_ids by datetime age
public function listAgedComic($interval = 8) {
	$comicData = array();
	// execute function
	$Query = "SELECT * FROM `".$this->comicTbl."` WHERE created < DATE_SUB(NOW(), INTERVAL '".$interval."' HOUR)";
	$Result = $this->db->query($Query);
	/* determine number of rows in result set */
	 //printf("Result set has %d rows.<br>", $Result->num_rows);
	if($Result) { // comic values into an array
		while($arr = $Result->fetch_assoc()) {
			$comicData[] = $arr['comic_name'] . ',' . $arr['oauth_id'];
		}
	// Return comic data
	return $comicData;
	}
}

// ---------------------------------
	// delete an array of comic records by comic name
public function deleteComic($comic_name){
	if(!empty($comic_name)){
		// comic data exists in database
		$comicData = array();
		// execute function
		$Query = "SELECT * FROM `".$this->comicTbl."` WHERE comic_name LIKE '".$comic_name."%'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // comic values into an array
			while($arr = $Result->fetch_assoc()) {
				$comicData[] = $arr['comic_name'];
				$comic_name = $arr['comic_name'];
                $query = "DELETE FROM `".$this->comicTbl."` WHERE comic_name = '".$comic_name."'";
				//echo $query."<br>";
                $delete = $this->db->query($query);
			}
		// Return comic data
		return $comicData;
		}
	}
}

// ---------------------------------
	// delete an array of comic records by oauth id
public function deleteOauthComic($oauth_id){
	if(!empty($oauth_id)){
		// comic data exists in database
		$comicData = array();
		// execute function
		$Query = "SELECT * FROM `".$this->comicTbl."` WHERE oauth_id LIKE '".$oauth_id."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		 //printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result) { // comic_name values into an array
			while($arr = $Result->fetch_assoc()) {
				$comicData[] = $arr['oauth_id'];
				$oauth_id = $arr['oauth_id'];
                $query = "DELETE FROM `".$this->comicTbl."` WHERE oauth_id = '".$oauth_id."'";
				//echo $query."<br>";
                $delete = $this->db->query($query);
			}
		// Return comic data
		return $comicData;
		}
	}
}

	// ---------------------------------
	// return a comic record
public function returnComicRecord($comic_name){
	$comicData = '';
	if(!empty($comic_name)){
		// Check whether comic data exists in database
		//echo "comic_name : ".$userData['comic_name']."<br>";
		$Query = "SELECT * FROM `".$this->comicTbl."` WHERE comic_name = '".$comic_name."'";
		$Result = $this->db->query($Query);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $Result->num_rows);
		if($Result->num_rows == 1){
		// Get comic data from the database
		$result = $this->db->query($Query);
		$comicData = $result->fetch_assoc();
		}
	}
	// Return comic data
	return $comicData;
}

	// ------------------------------------
	// update views count and lastview date
public function updateComic($comic_name){
	if(!empty($comic_name)){
		// Check whether user comic data already exists in database
		$prevQuery = "SELECT * FROM `".$this->comicTbl."` WHERE comic_name = '".$comic_name."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// Update comic data if already exists
			// change views = '".$comicData['views']."', lastview = '".$comicData['lastview']."',
			$query = "UPDATE `".$this->comicTbl."` SET views = views+1, lastview = NOW() WHERE comic_name = '".$comic_name."'";
			//echo $query."<br>";
			$update = $this->db->query($query);
		}
		// Get comic data from the database
		$result = $this->db->query($prevQuery);
		$comicData = $result->fetch_assoc();
	}
	// Return comic data
	return $comicData;
}

	// ------------------------------------
	// delete a comic record from the table
public function deleteComicRecord($comic_name){
	if(!empty($comic_name)){
		// Check whether user comic data already exists in database
		$prevQuery = "SELECT * FROM `".$this->comicTbl."` WHERE comic_name = '".$comic_name."'";
		$prevResult = $this->db->query($prevQuery);
		/* determine number of rows in result set */
		// printf("Result set has %d rows.<br>", $prevResult->num_rows);
		if($prevResult->num_rows == 1){
			// DELETE comic data if already exists
			// change views = '".$comicData['views']."', lastview = '".$comicData['lastview']."',
			$query = "DELETE FROM `".$this->comicTbl."` WHERE comic_name = '".$comic_name."'";
			//echo $query."<br>";
			$delete = $this->db->query($query);
		}
		// Get comic data from the database
		$result = $this->db->query($prevQuery);
		$comicData = $result->fetch_assoc();
	}
	// Return comic data
	return $comicData;
}
	// ------------------------------------
}
?>