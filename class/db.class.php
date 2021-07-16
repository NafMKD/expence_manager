<?php

/**
 * @author Nafiyad Menberu (@nafMKD)
 *
 * 
 * Database Connection
 */
class db
{
	
	/*private $host = "localhost";
	private $user = "root";
	private $pwd = "";
	private $dbname = "project";
	*/
	private $host = "remotemysql.com";
	private $user = "KXH2lfLQyx";
	private $pwd = "zQ1DhT9T9u";
	private $dbname = "KXH2lfLQyx";

	protected $emailSend = 'guchemenberu32@gmail.com';
	protected $passSend = '';

	protected function conn(){
		$db = mysqli_connect($this->host, $this->user, $this->pwd, $this->dbname);

		if(!$db){
			echo "Database Connection Error".mysqli_connect_error($db);
		}
		return $db;
	}
}
