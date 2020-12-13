<?php

/**
 * Database Connection
 */
class db
{
	
	private $host = "localhost";
	private $user = "root";
	private $pwd = "";
	private $dbname = "project";
	/*
	private $host = "sql2.freemysqlhosting.net";
	private $user = "sql2371060";
	private $pwd = "cV8%aQ6*";
	private $dbname = "sql2371060";*/

	public function conn(){
		$db = mysqli_connect($this->host, $this->user, $this->pwd, $this->dbname);

		if(!$db){
			echo "Database Connection Error".mysqli_connect_error($db);
		}
		return $db;
	}
}
