<?php  
include 'header.php'; 
include 'includes/functions.php';
$link =  $_GET['id'];

if(isset($_POST['Reset']))
{
	$post = $_POST['Reset'];
	$passwordLength = strlen($_POST['password']);
	$password = md5($_POST['password']);
	$confirmPassword = md5($_POST['cpassword']);
	$data = array(
				'passwordLength'=> $passwordLength, 
				'password' 		=> $password, 
				'cpassword' 	=> $confirmPassword ,
				'post'			=> $post,
				'link'			=> $link
				); 
	$error = resetPasswordEmail($data); 
}
 
?>
<div class="login-box">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-xs-12">
                <form name="form" id="form" method="post">
	                <div class="log-box">
	                    <h1>Set New Password <img src="img/arow.png"></h1>
	                    <?php if (isset($error)) { ?> 
	                        <div class="error-box">
	                      <?php echo isset($error) ? $error : '' ; ?>
	                       
	                        </div> 
	                     <?php } ?> 
	                    <div class="form-group">
	                        <label><img src="img/lock.png">Password</label>
	                        <input type="password" name="password" class="form-control coustom" placeholder="Password" required="">
	                    </div> 

	                    <div class="form-group">
	                        <label><img src="img/lock.png">Confirm Password</label>
	                        <input type="password" name="cpassword" class="form-control coustom" placeholder="Confirm Password" required="">
	                    </div> 
	                    <a href="signup.php"><p>Don't have an account</p></a>
	                    <div class="last-btn">
	                        <p><button class="btn btn-primary btn-custom" type="submit" name="Reset">Reset</button> </p> 
	                         
	                    </div>
	                </div>
                </form>
            </div>
        </div>
    </div>
</div>  
 
