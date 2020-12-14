<?php 

require 'PHPMailerAutoload.php';


/**
 * @author Nafiyad Menberu (@NafMKD)
 *
 * Fetch class
 */
class fetch extends db
{
	
	####################################################################
	// public use

	/******************************************************************/
	// Normal Fetch

	/**
	 * Fetch User Detail From Database
	 * @param string $type (ALL, EMAIL or INDIVIDUAL)
	 * @param intiger||string $Userid (User ID ir Email)
	 * @return array of row data's	
	 */

	public function fethUserDeail($type, $Userid=''){
		
		if ($type == "ALL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM user_detail ORDER BY id DESC");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "INDIVIDUAL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM user_detail WHERE id = '$Userid' ");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "EMAIL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM user_detail WHERE email = '$Userid' ");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}
	}
	
	/**
	 * Fetch Expences From Database
	 * @param string $type (ALL or INDIVIDUAL)
	 * @param intiger $Groupid (Expence Group ID)
	 * @return array of row data's	
	 */

	public function fethExpence($type, $Groupid=''){
		
		if ($type == "ALL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM expence ORDER BY id DESC");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "INDIVIDUAL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM expence WHERE exp_grp_id = '$Groupid' ORDER BY id DESC ");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}
	}

	/**
	 * Fetch Loans From Database
	 * @param string $type (ALL, ISPAID or INDIVIDUAL)
	 * @param intiger $Groupid (Loan Group ID)
	 * @param boolean $isPaid (1 or 0)
	 * @return array of row data's	
	 */

	public function fethLoan($type, $Groupid='', $isPaid=''){
		
		if ($type == "ALL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM loans ORDER BY id DESC");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "INDIVIDUAL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM loans WHERE loan_grp_id = '$Groupid' ORDER BY id DESC");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "ISPAID") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM loans WHERE loan_grp_id = '$Groupid' AND isPaid = '$isPaid' ORDER BY id DESC");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}
	}

	/**
	 * Fetch Loan Group From Database
	 * @param string $type (ALL, BYUSER or INDIVIDUAL)
	 * @param intiger $Userid (User ID or Loan Group ID)
	 * @return array of row data's	
	 */

	public function fethLoanGroup($type, $Userid=''){
		
		if ($type == "ALL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM loan_group ORDER BY id DESC");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "BYUSER") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM loan_group WHERE user_id = '$Userid' ORDER BY id DESC ");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "INDIVIDUAL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM loan_group WHERE id = '$Userid' ORDER BY id DESC ");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}
	}

	/**
	 * Fetch Expence Group From Database
	 * @param string $type (ALL, BYUSER or INDIVIDUAL)
	 * @param intiger $Userid (User ID or Expence Group ID)	
	 * @return array of row data's
	 */
	public function fethExpenceGroup($type, $Userid=''){
		
		if ($type == "ALL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM expence_group ORDER BY id DESC");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "BYUSER") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM expence_group WHERE user_id = '$Userid' ORDER BY id DESC ");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}elseif ($type == "INDIVIDUAL") {
			$array = array();
			$query = mysqli_query($this->conn(),"SELECT * FROM expence_group WHERE id = '$Userid' ORDER BY id DESC ");
			while ($row = mysqli_fetch_assoc($query)) {
				$array[] = $row ;
			}
			return $array;
		}
	}

	/******************************************************************/
	// Logicla Fetch

	/**
	 * Calculating income, expence of the user
	 * @param string $type (EXPENCE, LOAN, LOANPAID or LOANUNPAID)
	 * @param intiger $Groupid (Group ID)	
	 * @return array of income, expence and net balance respectively
	 */
	public function claculateNetBalace($type,$Groupid){
		if($type == "EXPENCE"){
			// fetching array of expences
			$arrayExp = $this->fethExpence("INDIVIDUAL", $Groupid);
			$incomeArray = array();
			$expenceArray = array();

			// assigning each expence to its clasification
			foreach ($arrayExp as $key) {
				if($key['amount'] >= 0){
					$incomeArray[] = $key['amount'];
				}elseif($key['amount'] < 0){
					$expenceArray[] = $key['amount'];
				}
			}

			return array(array_sum($incomeArray), array_sum($expenceArray), array_sum(array(array_sum($incomeArray), array_sum($expenceArray))));
		}elseif($type == "LOAN"){
			// fetching array of loan
			$arrayExp = $this->fethLoan("INDIVIDUAL", $Groupid);
			$incomeArray = array();
			$expenceArray = array();

			// assigning each loan to its clasification
			foreach ($arrayExp as $key) {
				if($key['amount'] >= 0){
					$incomeArray[] = $key['amount'];
				}elseif($key['amount'] < 0){
					$expenceArray[] = $key['amount'];
				}
			}

			return array(array_sum($incomeArray), array_sum($expenceArray), array_sum(array(array_sum($incomeArray), array_sum($expenceArray))));
		}elseif($type == "LOANPAID"){
			// fetching array of loan
			$arrayExp = $this->fethLoan("ISPAID", $Groupid, 1);
			$incomeArray = array();
			$expenceArray = array();

			// assigning each loan to its clasification
			foreach ($arrayExp as $key) {
				if($key['amount'] >= 0){
					$incomeArray[] = $key['amount'];
				}elseif($key['amount'] < 0){
					$expenceArray[] = $key['amount'];
				}
			}

			return array(array_sum($incomeArray), array_sum($expenceArray), array_sum(array(array_sum($incomeArray), array_sum($expenceArray))));
		}elseif($type == "LOANUNPAID"){
			// fetching array of loan
			$arrayExp = $this->fethLoan("ISPAID", $Groupid, 0);
			$incomeArray = array();
			$expenceArray = array();

			// assigning each loan to its clasification
			foreach ($arrayExp as $key) {
				if($key['amount'] >= 0){
					$incomeArray[] = $key['amount'];
				}elseif($key['amount'] < 0){
					$expenceArray[] = $key['amount'];
				}
			}

			return array(array_sum($incomeArray), array_sum($expenceArray), array_sum(array(array_sum($incomeArray), array_sum($expenceArray))));
		}
		
	}

	/**
	 * Verifying email
	 * @param string $email -> (EMAIL or PASSWORD)
	 * @param string $email -> email to verify
	 * @param intiger $code -> 6 digit code
	 * @return status code (1, 2 or 0)
	 */
	public function emailVerify($type, $email, $code){
		//geting user data
		$arrUser = $this->fethUserDeail("EMAIL", $email);

		if($type == "EMAIL"){
			//checking user
			if (count($arrUser) > 0) {
				// checking code
				if($arrUser[0]['emailCode'] == $code){
					mysqli_query($this->conn(), "UPDATE user_detail SET emailCode = 0 , accStat = 1 WHERE email = '$email'");
					$_SESSION['id'] = $arrUser[0]['id'];
					header("location: auth/");
				}else{
					return 0;
				}
			}else{
				return 2;
			}
		}if($type == "PASSWORD"){
			//checking user
			if (count($arrUser) > 0) {
				// checking code
				if($arrUser[0]['passCode'] == $code){
					mysqli_query($this->conn(), "UPDATE user_detail SET passCode = 0 WHERE email = '$email'");
					header("location: change.php?email=".$email."&token=".md5($arrUser[0]['password'])."");
				}else{
					return 0;
				}
			}else{
				return 2;
			}
		}
	}

	/**
	 * Verifing existande of email
	 * @param string $email -> email to verify
	 * @return status code (1 or 0)
	 */
	public function emailChecker($email){
		//fetching data 
		$arraUser = $this->fethUserDeail("EMAIL", $email);

		//chaecking 
		if (count($arraUser) > 0) {
			return 1;
		}else{
			return 0;
		}
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
			$mail->Username = EMAIL;                
			$mail->Password = PASS;                           
			$mail->SMTPSecure = 'tls';                            
			$mail->Port = 587;                                    

			//fetching data 
			$userData = $this->fethUserDeail("EMAIL", $email)[0];

			$mail->setFrom(EMAIL, 'Expense Manager');
			$mail->addAddress($email, $userData['fullName']);   

			$mail->isHTML(true); 

			$mail->Subject = 'Password Reset!';
			$mail->Body    = 'Verification code <b>'.$random.'</b>';
			$mail->AltBody = 'use this link to insert the verification code <a href="http://expensem.herokuapp.com/change.php?email='.$email.'&token='.md5($userData['password']).'> click here </a>';

			$mail->send();

			// inserting to db
			mysqli_query($this->conn(), "UPDATE user_detail SET passCode = '$random' WHERE email = '$email'");
		
	}

}