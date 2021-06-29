<?php
//Code found on stack overflow, changed for connecting to my db

class DbManager {

	//Database configuration
	private $dbhost = 'mongo';
	private $dbport = '27018';
	private $conn;
	
	function __construct(){
        //Connecting to MongoDB
        try {
			//Establish database connection
            $this->conn = new MongoDB\Driver\Manager('mongodb://mongo:27017', ["authMechanism" => "SCRAM-SHA-1", "username" => 'root', "password" => 'root']);
        }catch (MongoDBDriverExceptionException $e) {
            echo $e->getMessage();
			echo nl2br("n");
        }
    }

	function getConnection() {
		return $this->conn;
	}

}













?>