<?php  
include 'header.php';
include 'includes/config.php';
include 'includes/classes/class.user.php';
include 'includes/functions.php';

$userObj = new User($config['db']); 

if(isset($_POST['reset']))
{
	$email = $config['db']->real_escape_string($_POST['email']); 
	$user = $userObj->forgotPassword($email);
	$email = $user->email; 
	$userFirstName = $user->first_name;
	$userLastName = $user->last_name;
	$id = $user->id;
	$link = guid();
		
	if(empty($user))
	{
		$_SESSION['error']="Looks like you got disabled or don't have an account yet"; 
	}
	else
	{   
		$userObj->updateForgotPasswordLink($id,$link); 
		$link_ = baseUrl().$link;
		$emailTemplate = $userObj->emailTemplate();  
		$replace = array('[WEBURL]','[WEBNAME]','[USER]','[LINK]');
		$webData = $userObj->fetchWebData();
		$webName = $webData->webname;
		$webUrl = $webData->weburl;
		$webMail = $webData->webmail;  
		$emailSubject = $emailTemplate->eSubject;
		$replaceWith = array(
								$webUrl, $webName, $userFirstName.' '.$userLastName, $link_, 
							); 
		$msg = str_replace($replace, $replaceWith, $emailTemplate->eContent);  
		
		// prepare email
		$to = $email;
		$subject = $emailSubject;
		$message = $msg;
		$setMailtype = 'html'; 
		$headers = 'From:'  .$webMail . "\r\n" . $webName . phpversion(); 

 		//send Email 
		$sendMail =  mail($to, $subject, $message, $headers, $setMailtype); 
 		checkResetEmail();

 		 

	}
}
?>

 


<div class="login-box">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-xs-12">
                <form name="form" id="form" method="post">
                <div class="log-box">
                    <h1>Reset Password<img src="img/arow.png"></h1> 
                    <div class="form-group mr-top"> 
                        <label><img src="img/user.png">Email</label> 
                        <input maxlength="40" class="form-control coustom" placeholder="Email" name="email" type="email" required value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '';?>">
                    </div>
                     
                    <a href="signup.php"><p>Don't have an account</p></a>
                    <div class="last-btn">
                        <p><button class="btn btn-primary btn-custom" type="submit" name="reset">Reset</button> </p>  
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div> 


<?php 
include 'footer.php';

?>