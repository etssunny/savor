<?php

/**
* Performs all user specific DB operations
*/
class User
{
	// $this->db == $config['db']
	protected $db;
	
	public function __construct($db)
	{
		$this->db = $db;
	}	

	/**
	 * Matches a user against email-password pair
	 */
	public function fetchUserByCredential($email, $password)
	{
		$result = $this->db->query("SELECT * FROM `users` 
									WHERE  
									email = '$email' 
									AND password = '$password'
									AND status = 1");
		 
		if($result->num_rows == 1)
	    { 
	    	return $result->fetch_object();
	    }
	    else
	    {
	        return false;
	    }   	 
	}

	public function insert($data)
	{ 
		//variable Decleration 
		$firstName = $data['first_name']; 
		$lastName = $data['last_name'];  
		$email = $data['email'];
		$sex = $data['sex'];
		$password = $data['password']; 
		$signupDate = $data['signup_date']; 
		$ip = $data['ip']; 
		$userName = $this->makeUserName($email);  

		$sql = $this->db->query("INSERT INTO `users` (`first_name`,`last_name`,`username`,`email`,`sex`,`password`,`signup_date`,`ip`,`verified`,`status`) VALUES ('$firstName','lastName','$userName','$email','$sex','$password','$signupDate','$ip',1,1)");

		if ($sql)
		{			 
			return $this->db->insert_id; 
		} 
		else
		{
			return false; 
		}
	}

	private function makeUserName($email)
	{
		$userName = explode('@', $email)[0];

		for($i=1; $i<=500; $i++)
		{
			$exists = $this->db->query("SELECT username FROM `users` WHERE username = '$userName' "); 
			if($exists->num_rows == 0) 
			{
				break;
			}	 
			else 
			{
				$userName = $userName.'-'.rand(2,9999);
			} 	
		} 
		return $userName;
	} 

	public function verification($id)
	{
		$result = $this->db->query("SELECT * FROM `users` 
									WHERE  
									id = '$id' 
									AND verified = 1"); 
		if($result->num_rows == 0) 
		{ 
			return false;  
		}
		else
		{
			return true;
		}
	}

	public function emailCheck($email)
	{
		$emailResult = $this->db->query("SELECT email FROM `users` WHERE email = '$email' ");
		if($emailResult->num_rows > 0)
		{
			return false; 	 	 
		}
		else
		{
			return $email;
		}
	} 
	 
}


/*
End class User
location: includes/classes/class.user.php
*/