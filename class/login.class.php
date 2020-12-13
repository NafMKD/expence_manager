<?php 

/**
 * Login 
 */
class Login extends db
{
	###########################################################################
	// For class use only 
	
	private $email;
	private $password;

	###########################################################################
	// Public use

	/**
	 * Signin to acount
	 * @param email $email -> email to signin
	 * @param string $password -> password to signin
	 */
	public function signin($email, $password){
		// preparing data for request
		$this->email = mysqli_real_escape_string($this->conn(), $email);
		$this->password = mysqli_real_escape_string($this->conn(), md5($password));

		// preparing sql statment
		$sql = "SELECT * FROM user_detail WHERE email = '$this->email' AND password = '$this->password'";

		// sending request
		$query = mysqli_query($this->conn(), $sql);

		// cheking the user existance
		if(mysqli_num_rows($query)== 1){
			$sqli = mysqli_fetch_assoc($query);
			if($sqli['accStat'] == 1){
				$id = $sqli['id'];
				$_SESSION['id']= $id;
				header('location: auth/');
			}else{
				header('location: email.php?email='.$this->email.'&errAccount');
			}
			
		}else{
			$msg = "Email or Password Incorect!";
			return $msg;
		}
	}

}
