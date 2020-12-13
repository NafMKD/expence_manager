<?php 

/**
 * @author Nafiyad Menberu (@NafMKD)
 * 
 * Update and Delete Class
 */
class update extends db
{
	
	##################################################################
	// Public Use

	/****************************************************************/
	// Updating Database

	/**
	 * Updating User Detail
	 * @param intiger $UserID -> to identify which user is to be updated
	 * @param string $fullName -> Full Name of The User
	 * @param email $email -> Email of the user Also Email use as username in login time
	 * @param string $password -> Password for account, password stored as md5 hash in database 
	 */
	public function updaterUser($type, $userID, $fullName, $email, $password){

		// preparing for inserting
		$fullName = mysqli_real_escape_string($this->conn(), $fullName);
		$email = mysqli_real_escape_string($this->conn(), $email);
		$password = mysqli_real_escape_string($this->conn(), $password);

		// appling md5 hash to password string 
		$password = md5($password);

		// preparing query
		$query = "UPDATE user_detail SET fullName = '$fullName', email = '$email', password = '$password' WHERE id = '$userID' ";

		// sending request and inserting data
		if(mysqli_query($this->conn(), $query)){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * Updating Loan Payment Status
	 * @param intiger $id -> to identify which Loan is to be updated 
	 * @param boolean || intiger  $isPaid -> to set the value (true or false || 1 or 0)
	 */
	public function updateLoan($id, $isPaid){
		
		// preparing query
		$query = "UPDATE loans SET isPaid = '$isPaid' WHERE id = '$id'";

		// sending request and inserting data
		if(mysqli_query($this->conn(), $query)){
			return 1;
		}else{
			return 0;
		}
	}

	/**
	 * Changing Password
	 * @param intiger $UserID -> to identify which user is to be updated
	 * @param string $password -> Password for account, password stored as md5 hash in database 
	 */
	public function changePassword($userID,$password){
		// preparing for inserting;
		$password = mysqli_real_escape_string($this->conn(), md5($password));

		// preparing query
		$query = "UPDATE user_detail SET password = '$password' WHERE id = '$userID' ";

		// sending request and inserting data
		if(mysqli_query($this->conn(), $query)){
			header("location: /project/?newPassword");
		}else{
			return 0;
		}
	}


	/****************************************************************/
	// Deleting From Database

	/**
	 * Deleting Loan 
	 * @param string $type -> BYGROUP or INDIVIDUAL 
	 * @param intiger $id -> to identify which Loan is to be deleted 
	 */
	public function deleteLoan($type,$id){
		
		if($type == "BYGROUP"){
			// preparing query
			$query = "DELETE FROM loans WHERE loan_grp_id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				return "Loan Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}elseif($type == "INDIVIDUAL"){
			// preparing query
			$query = "DELETE FROM loans WHERE id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				return "Loan Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}
	}

	/**
	 * Deleting Expence 
	 * @param string $type -> BYGROUP or INDIVIDUAL 
	 * @param intiger $id -> to identify which Expence is to be deleted 
	 */
	public function deleteExpence($type,$id){
		
		if($type == "BYGROUP"){
			// preparing query
			$query = "DELETE FROM expence WHERE exp_grp_id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				return "Expence Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}elseif($type == "INDIVIDUAL"){
			// preparing query
			$query = "DELETE FROM expence WHERE id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				return "Expence Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}
	}

	/**
	 * Deleting Expence Group 
	 * @param string $type -> BYUSER or INDIVIDUAL 
	 * @param intiger $id -> to identify which Expence Group is to be deleted 
	 */
	public function deleteExpenceGroup($type,$id){
		
		if($type == "BYUSER"){
			// preparing query
			$query = "DELETE FROM expence_group WHERE user_id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				return "Expence Group Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}elseif($type == "INDIVIDUAL"){
			// preparing query
			$query = "DELETE FROM expence_group WHERE id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				$this->deleteExpence("BYGROUP", $id);
				return "Expence Group Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}
	}

	/**
	 * Deleting Loan Group 
	 * @param string $type -> BYUSER or INDIVIDUAL 
	 * @param intiger $id -> to identify which Loan Group is to be deleted 
	 */
	public function deleteLoanGroup($type,$id){
		
		if($type == "BYUSER"){
			// preparing query
			$query = "DELETE FROM loan_group WHERE user_id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				return "Loan Group Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}elseif($type == "INDIVIDUAL"){
			// preparing query
			$query = "DELETE FROM loan_group WHERE id = '$id' ";

			// sending request and inserting data
			if(mysqli_query($this->conn(), $query)){
				$this->deleteLoan("BYGROUP", $id);
				return "Loan Group Successfuly Deleted!";
			}else{
				return "Something Went Wrong, Please Try Again!";
			}
		}
	}

	
}