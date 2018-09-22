<?php
include_once 'includes/classes/class.user.php';
include_once 'includes/config.php';

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

function verifyEmail()
{
	if(verified())
	{
		header('location: step-1.php');
		exit;
	} 
}

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

?>