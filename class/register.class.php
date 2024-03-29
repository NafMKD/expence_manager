<?php 

require 'PHPMailerAutoload.php';
/**
 * @author Nafiyad Menberu (@nafMKD)
 *
 * 
 * Register Class
 */
class register extends db
{
	// For Class Use Only

	/**
	 * Date Generator for inserting to database
	 * @param string $type -> type of date format to be returned
	 */ 
	private function dateGenenetor($type){
        date_default_timezone_set("Africa/Addis_Ababa");
		return date($type);
    }
	
	############################################################################
	// Public Use


	/**
	 * Send Verification Email
	 * @param string $fullName -> Full Name of The User
	 * @param email $email -> Email of the user Also Email use as username in login time
	 */
	public function sendEmail($email, $fullName){

			// generating random number 
			$random = mt_rand(100000, 999999);

			// sending email
			$mail = new PHPMailer;

			$mail->isSMTP();                                      
			$mail->Host = 'smtp.gmail.com';  
			$mail->SMTPAuth = true;                              
			$mail->Username = $this->emailSend;                
			$mail->Password = $this->passSend;                           
			$mail->SMTPSecure = 'tls';                            
			$mail->Port = 587;                                    

			$mail->setFrom($this->emailSend, 'Expense Manager');
			$mail->addAddress($email, $fullName);   

			$mail->isHTML(true); 

			$mail->Subject = 'Verify Your Email Address!';
			$mail->Body    = 'Verification code <b>'.$random.'</b> \n\n\n 
					use this link to insert the verification code <a href="http://expensem.herokuapp.com/email.php?email='.$email.'"> click here </a>
			';

			$mail->send();

			// inserting to db
			mysqli_query($this->conn(), "UPDATE user_detail SET emailCode = '$random' WHERE email = '$email'");
		
	}

	/**
	 * Send Verification Email
	 * @param string $fullName -> Full Name of The User
	 * @param email $email -> Email of the user Also Email use as username in login time
	 */
	public function sendPassEmail($email){

			// generating random number 
			$random = mt_rand(100000, 999999);

			// sending email
			$mail = new PHPMailer;
			$mail->isSMTP();                                      
			$mail->Host = 'smtp.gmail.com';  
			$mail->SMTPAuth = true;                              
			$mail->Username = $this->emailSend;                
			$mail->Password = $this->passSend;                           
			$mail->SMTPSecure = 'tls';                            
			$mail->Port = 587;                                    

			//fetching data 
			$userDataquery = mysqli_query($this->conn(),"SELECT * FROM user_detail WHERE email = '$email' ");
			$userData = mysqli_fetch_assoc($userDataquery);

			$mail->setFrom($this->emailSend, 'Expense Manager');
			$mail->addAddress($email, $userData['fullName']);   

			$mail->isHTML(true); 

			$mail->Subject = 'Password Reset!';
			$mail->Body    = 'Verification code <b>'.$random.'</b> \n\n\n 
					use this link to insert the verification code <a href="http://expensem.herokuapp.com/change.php?email='.$email.'&token='.md5($userData['password']).'> click here </a>
			';

			$mail->send();

			// inserting to db
			mysqli_query($this->conn(), "UPDATE user_detail SET passCode = '$random' WHERE email = '$email'");
		
	}

	/**
	 * Insert New User To DataBase
	 * @param string $fullName -> Full Name of The User
	 * @param email $email -> Email of the user Also Email use as username in login time
	 * @param string $password -> Password for account, password stored as md5 hash in database 
	 */
	public function registerUser($fullName, $email, $password){

		// preparing for inserting
		$date = $this->dateGenenetor("m/d/Y");
		$fullName = mysqli_real_escape_string($this->conn(), ucfirst($fullName));
		$email = mysqli_real_escape_string($this->conn(), $email);
		$password = mysqli_real_escape_string($this->conn(), md5($password));
		

		//checking the email 
		$arrayF = array();
		$queryF = mysqli_query($this->conn(),"SELECT * FROM user_detail WHERE email = '$email' ");
		$rowF = mysqli_fetch_assoc($queryF);
		while ($rowF = mysqli_fetch_assoc($queryF)){
			$arrayF[] = $rowF;
		}

		if (count($arrayF) > 0) {
			return 2;
		}else{

			// preparing query
			$query = "INSERT INTO user_detail(fullName, email, password, accStat, emailCode, passCode, dateReg, loginLog) VALUES('$fullName', '$email', '$password', 0, 0, 0, '$date', '')";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				$this->sendEmail($email, $fullName);
				header("location: email.php?email=".$email."");
			}else{
				return 0;
			}

		}
		
	}

	/**
	 * Insert New Loan Group To DataBase
	 * @param intiger $user_id -> User Id to catagorize groups to users 
	 * @param string $title -> Title for Loan Group Which apear in head
	 * @param string $discription -> Description for Group in Detail 
	 * @param date $date -> date for data
	 */
	public function registerLoanGroup($user_id, $title, $discription, $date){

		// preparing for inserting
		$user_id = mysqli_real_escape_string($this->conn(), $user_id);
		$title = mysqli_real_escape_string($this->conn(), ucfirst($title));
		$discription = mysqli_real_escape_string($this->conn(), $discription);

		// preparing query
		$query = "INSERT INTO loan_group(user_id, title, discription, date) VALUES('$user_id', '$title', '$discription', '$date')";

		// sending request and inserting data
		if(mysqli_query($this->conn(), $query)){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * Insert New Expence Group To DataBase
	 * @param intiger $user_id -> User Id to catagorize groups to users 
	 * @param string $title -> Title for Expence Group Which apear in head
	 * @param string $discription -> Description for Group in Detail 
	 * @param date $date -> date for data
	 */
	public function registerExpenceGroup($user_id, $title, $discription, $date){

		// preparing for inserting
		$date = $this->dateGenenetor("m/d/Y");
		$user_id = mysqli_real_escape_string($this->conn(), $user_id);
		$title = mysqli_real_escape_string($this->conn(), ucfirst($title));
		$discription = mysqli_real_escape_string($this->conn(), $discription);

		// preparing query
		$query = "INSERT INTO expence_group(user_id, title, discription, date) VALUES('$user_id', '$title', '$discription', '$date')";

		// sending request and inserting data
		if(mysqli_query($this->conn(), $query)){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * Insert New Expence To DataBase
	 * @param intiger $Group_id -> Group Id to catagorize Expences to Group 
	 * @param string $title -> Title for Expence  Which apear in head
	 * @param string $discription -> Description for Expence in Detail 
	 * @param string $amount -> Amount of Expence 
	 * @param date $date -> date for data
	 */
	public function registerExpence($Group_id, $title, $discription, $amount, $date){

		// preparing for inserting
		$date = $this->dateGenenetor("m/d/Y");
		$Group_id = mysqli_real_escape_string($this->conn(), $Group_id);
		$title = mysqli_real_escape_string($this->conn(), ucfirst($title));
		$discription = mysqli_real_escape_string($this->conn(), $discription);
		$amount = mysqli_real_escape_string($this->conn(), $amount);

		// preparing query
		$query = "INSERT INTO expence(exp_grp_id, title, discription, amount, date) VALUES('$Group_id', '$title', '$discription', '$amount', '$date')";

		// sending request and inserting data
		if(mysqli_query($this->conn(), $query)){
			return 1;
		}else{
			return 0;
		}
	}


	/**
	 * Insert New Loan To DataBase
	 * @param intiger $Group_id -> Group Id to catagorize Loans to Group 
	 * @param string $title -> Title for Loan  Which apear in head
	 * @param string $discription -> Description for Loan in Detail 
	 * @param string $amount -> Amount of Loan 
	 * @param date $date -> date for data
	 */
	public function registerLoan($Group_id, $title, $discription, $amount, $date){

		// preparing for inserting
		$date = $this->dateGenenetor("m/d/Y");
		$Group_id = mysqli_real_escape_string($this->conn(), $Group_id);
		$title = mysqli_real_escape_string($this->conn(), ucfirst($title));
		$discription = mysqli_real_escape_string($this->conn(), $discription);
		$amount = mysqli_real_escape_string($this->conn(), $amount);

		// preparing query
		$query = "INSERT INTO loans(loan_grp_id, title, discription, amount, date) VALUES('$Group_id', '$title', '$discription', '$amount', '$date')";

		// sending request and inserting data
		if(mysqli_query($this->conn(), $query)){
			return 1;
		}else{
			return 0;
		}
	}
}
