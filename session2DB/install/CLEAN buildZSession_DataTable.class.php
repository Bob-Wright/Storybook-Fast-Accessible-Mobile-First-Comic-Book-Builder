<?php
error_reporting(E_ALL); // disable this for production code
ini_set('display_errors', TRUE);

/*
 * session_data
 * This table is used for session data
*/

class buildSession_DataTable {
	// Database configuration
    private $dbHost     = 'localhost'; //MySQL_Database_Host
    private $dbUsername = 'user'; //MySQL_Database_Username
    private $dbPassword = 'password'; //MySQL_Database_Password
    private $dbName     = 'Session'; //MySQL_Database_Name
    private $Session_DataTable    = 'session_data';

    function __construct(){
        if(!isset($this->db)){
            // Connect to the database
            $conn = new mysqli($this->dbHost, $this->dbUsername, $this->dbPassword, $this->dbName);
            if($conn->connect_error){ // limit information displayed on error
                die("Failed to connect with database. "/* . $conn->connect_error*/);
            }else{
				echo "Connected to database<br>";
                $this->db = $conn;
            }
        }
    }
    
/* --------------------
create the session_data table
*/
public function createTable(){
	   // Check whether data already exists in database
		$checkQuery = "SELECT * FROM ".$this->Session_DataTable;
			// echo $prevQuery."<br>";
		$checkResult = $this->db->query($checkQuery);
		if($checkResult != NULL){
		$drop = "DROP TABLE ".$this->Session_DataTable.";";
			if ($this->db->query($drop) === TRUE) {
					echo "session_data Table dropped successfully<br>";
					} else {
					echo "Error dropping session_data Table: <br>"; // leave off $conn->error;
					}
		}

if ($this->db->query('CREATE TABLE IF NOT EXISTS session_data (
  session_id varchar(32) NOT NULL default "",
  hash varchar(32) NOT NULL default "",
  session_data blob NOT NULL,
  session_expire int(11) NOT NULL default "0",
  PRIMARY KEY session_id (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;') === TRUE) {
			echo "<br>session_data Table created successfully<br>";
			} else {
			echo "<br>Error creating session_data Table: <br>"; // leave off $conn->error;
		}
}}
?>	