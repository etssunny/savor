<?php 
//include file on this page
include 'header.php';
include 'includes/config.php';
include 'includes/classes/class.user.php';
include 'includes/functions.php' ;

$userObj = new User($config['db']); 
if(isset($_POST["signup"]))
{
	//variable decleration
	$firstName = $config['db']->real_escape_string($_POST['first_name']);
	$lastName =  $config['db']->real_escape_string($_POST['last_name']); 
	$email = $config['db']->real_escape_string($_POST['email']); 
	$sex = $config['db']->real_escape_string($_POST['sex']);
	$password = md5($_POST['password']); 
	$signupDate = $config['db']->real_escape_string(date("Y-m-d H:i:s"));
	$ip = $config['db']->real_escape_string($_SERVER['REMOTE_ADDR']);
	$data = array("first_name" 	=> $firstName, 
				"last_name" 	=> $lastName, 
				"email" 		=> $email, 
				"sex" 			=> $sex, 
				"password" 		=> $password, 
				"signup_date" 	=> $signupDate, 
				"ip" 			=> $ip
				); 
 	$emailChecked = $userObj->emailCheck($email);
	if(!empty($emailChecked))
	{
		$id = $userObj->insert($data); 

	    $user = $userObj->fetchUserByCredential($email,$password);   
	    if(!empty($user))
	    {
	    	//LOGIN THIS USER  

	        $_SESSION['Savor'] = $user;
	        if($user->verified == 1) 
	        {
	            sendVerificationEmail();
	        } 
	        else 
	        {
	            $_SESSION['error'] = "Invalid login credentials or account disabled.";
	        }
	    }  
	}
	else
	{
		$emailError = "The Email field must contain a unique value.";
	}
	   
} 
?>  
	<!-- SIGNUP VIEW -->
 

<div class="login-box">
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3 col-xs-12">
				<div class="log-box">
				<form action="" method="post">
					<h1>Signup <img src="img/arow.png"></h1>
					<?php if (isset($emailError)) { ?>
                        <div class="error-box">
                            <?php echo isset($emailError) ? $emailError : '' ; ?>
                        </div>
                    <?php } ?>
					<div class="form-group mr-top">
						<label><img src="img/user.png">Fast Name</label>
						<input maxlength="15" placeholder="First Name" name="first_name" type="text" class="form-control coustom" required value="<?php echo isset($_POST["first_name"]) ? $_POST["first_name"] : '';?>">
					</div>
					<div class="form-group">
						<label><img src="img/user.png">Last Nmae</label>
						<input maxlength="20" placeholder="Last Name" name="last_name" type="text"  class="form-control coustom" required value="<?php echo isset($_POST["last_name"]) ? $_POST["last_name"] : '';?>">
					</div>
					<div class="form-group">
						<label><img src="img/user.png">Sex</label>
						<select class="form-control coustom" required name="sex" placeholder="Sex">
							<option <?php echo isset($_POST['sex']) && $_POST['sex'] == 'Male' ? 'selected' : '';   ?> value="Male">Male</option>
							<option <?php echo isset($_POST['sex']) && $_POST['sex'] == 'Female' ? 'selected' : '';   ?> value="Female">Female</option>
							<option <?php echo isset($_POST['sex']) && $_POST['sex'] == 'Other' ? 'selected' : '';   ?> value="Other">Other</option>
						</select>
					</div>
					<div class="form-group">
						<label><img src="img/user.png">Email</label>
						<input maxlength="40" class="form-control coustom" placeholder="Email" name="email" type="email" required value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '';?>">
					</div>
					<div class="form-group">
						<label><img src="img/lock.png">Password</label>
						<input placeholder="Password" class="form-control coustom" name="password" type="password" required>
					</div>
					<a href=" login.php "><p>Al ready have an account</p></a>
					<div class="last-btn">
						<div class="last-btn">
       						 <p><button class="btn btn-primary btn-custom" type="submit"  value="Signup" name="signup" >SignUp</button>  </p>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
</div> 

 
<?php include 'footer.php'; ?>