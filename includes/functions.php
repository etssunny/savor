<?php
include_once 'includes/classes/class.user.php';
include_once 'includes/config.php';

/**
* If user Already Logged In
*/

function loggedIn()
{
	global $config; 
	$userObj = new User($config['db']);
 	if(!isset($_SESSION['Savor']))
	{ 	
		return false;
	}
	$id = $_SESSION['Savor']->id;
 	$user = $userObj->userLoggedIn($id); 
	if($user == 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

/**
* Check verification	
*/

function verified()
{
	global $config; 
	$userObj = new User($config['db']);  

	if(!isset($_SESSION['Savor']))
	{
		return false;
	}
	$id = $_SESSION['Savor']->id; 
	$userId = $userObj->verification($id);  

	if($userId == false)
	{
		return false;
	} 
	else
	{
		return true;
	}
}

/**
* send the Verification Email and verification user
*/

function sendVerificationEmail($uid = 0)
{
	if(verified())
	{
		header('location: step-1.php');
		exit;
	} 

	if($uid == 0 && !isset($_SESSION['Savor']))
	{
		header('location: step-1.php');
		exit;
	}  
} 

/**
*  Generate a globally unique identifier 
*/

function guid()
{

    if (function_exists('com_create_guid') === true)
    {
        $result =  trim(com_create_guid(), '{}');
        return str_replace(array('{','}'), array('',''), $result);
    }

    return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));

} 

/**
* Base Url Creation
*/

function baseUrl()
{
	$url = "enter_new_password.php?id=";
	return $url;
}

/**
* Reset Password email
*/

function resetPasswordEmail($data)
{  
	$passwordLength = $data['passwordLength'];
	$password = $data['password']; 
	$confirmPassword  = $data['cpassword'];
	$post = $data['post'];
	$link = $data['link'];
	if(verified())
	{
		header('location: step-1.php');
		exit;
	}
	global $config; 
	$userObj = new User($config['db']);
	$user = $userObj->matchForgotPassword($link); 
	$userID = $user->id; 
	if(empty($user))
	{
		$error = "Security Problems!"; 
		exit;
	}
	else
	{
		if(loggedIn())
		{
			header('location: step-1.php');
			exit;
		} 
		else
		{ 
			if(isset($post))
			{  	
				if(!($passwordLength < 8))
				{   
					if($password == $confirmPassword)
					{
				 		$userPwdUpdate = $userObj->resetUpdtedPassword($userID, $password);
				 		if($userPwdUpdate == true)
				 		{
				 			header('location: login.php');
				 		}
					}
					else
					{
						return "The Confirm Password field does not match the Password field.";
					} 
				}
				else
				{
					return"The Password field must be at least 8 characters in length.";
				}
			}
		} 	
	} 
} 

/**
* Check Reset Email 
*/

function checkResetEmail()
{
	if(verified())
	{
		header('location: step-1.php');
		exit;
	}
	else
	{
		header('location: check_reset_email.php'); 
	}
}

?>