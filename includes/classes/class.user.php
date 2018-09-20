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
}

/*
End class User
location: includes/classes/class.user.php
*/