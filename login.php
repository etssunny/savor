<?php
include 'header.php';
include 'includes/config.php';
include 'includes/classes/class.user.php';

$userObj = new User($config['db']); 
if(isset($_POST["login"]))
{
    $email = $config['db']->real_escape_string($_POST['email']); 
    $password = md5($_POST['password']);  
    $user = $userObj->fetchUserByCredential($email, $password);   
    
    if($user)
    {
        $_SESSION['Savor'] = $user;
        if($user->verified == 1) 
        {
            header('location: step-1.php');
        } 
        else 
        {
            header('location: verify-email.php');
        }
    }   
    else
    {
       $error = "Invalid login credentials or account disabled. ";
    }       
} 
?>   

<div class="login-box">
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-sm-offset-3 col-xs-12">
                <form name="form" id="form" method="post">
                <div class="log-box">
                    <h1>Login Now <img src="img/arow.png"></h1>
                    <?php if (isset($error)) { ?>
                        <div class="error-box">
                            <?php echo isset($error) ? $error : '' ; ?>
                        </div>
                    <?php } ?>
                    <div class="form-group mr-top">

                        <label><img src="img/user.png">Email</label>
                        <input type="email" class="form-control coustom" name="email" placeholder="Email" required=""  value="<?php echo isset($_POST["email"]) ? $_POST["email"] : '';?>">
                    </div>
                    <div class="form-group">
                        <label><img src="img/lock.png">Password</label>
                        <input type="password" name="password" class="form-control coustom" placeholder="Password" required="">
                    </div> 
                    <a href="signup.php"><p>Don't have an account</p></a>
                    <div class="last-btn">
                        <p><button class="btn btn-primary btn-custom" type="login" name="login">login</button> </p> 
                        <p><a href="forgot_enter_email.php" class="btn btn-primary btn-custom">Forgot Password?</a></p>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>  

<?php include 'footer.php'; ?>
    