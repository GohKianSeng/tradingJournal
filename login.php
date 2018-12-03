<?php
session_start();

if (isset($_SESSION['UserGUID']) && $_SESSION['loggedin'] == true) {
    header('Location: main.php');
} else {
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Trading Journal</title>

    <!-- Bootstrap -->
    <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css?aaa" rel="stylesheet">
    
    <!-- PNotify -->
    <link href="../vendors/pnotify/dist/pnotify.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.buttons.css" rel="stylesheet">
    <link href="../vendors/pnotify/dist/pnotify.nonblock.css" rel="stylesheet">
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>
      <a class="hiddenanchor" id="forgotpassword"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="/PerformTransaction.php" method="post">
              <h1>Login</h1>
              <div>
                <input type="email" class="form-control" name="username" placeholder="Email Address" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              
              <div>
                
                <input type="submit" class="btn btn-default submit" value="Submit" style="margin-left: 130px;">
                
                
              </div>
              <input type="hidden" name="ActionType" id="ActionType" value="VerifyLogin" >
	   
              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">
                  <a href="#signup" class="to_register"> Create Account </a> | <a href="#forgotpassword" class="to_register" style="margin-left: 15px;"> Forgot Password </a>
                </p>
                
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1></i>My Trading Journal</h1>
                  <p>©2018 All Rights Reserved. <br />My Trading Journal is powered by Bootstrap 3.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form action="/PerformTransaction.php" method="post">
              <h1>Create Account</h1>              
              <div>
                <input type="text" class="form-control" name="name" placeholder="Name" required="" />
              </div>
              <div>
                <input type="email" class="form-control" name="username" placeholder="Email Address" required="" />
              </div>
              <div>
                <input type="password" class="form-control" name="password" placeholder="Password" required="" />
              </div>
              <div>                
                <input type="submit" class="btn btn-default submit" value="Submit" style="margin-left: 138px;">
              </div>

              <div class="clearfix"></div>
              <input type="hidden" name="ActionType" id="ActionType" value="AddUser" >
	    
              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1></i>My Trading Journal</h1>
                  <p>©2018 All Rights Reserved. <br />My Trading Journal is powered by Bootstrap 3.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
		
		
	<div id="forgotpassword" class="animate form forgotpassword_form">
          <section class="login_content">
            <form action="/PerformTransaction.php" method="post">
              <h1>Reset Password</h1>              
              <div>
                <input type="email" class="form-control" name="username" placeholder="Email Address" required="" />
              </div>
              <div>                
                <input type="submit" class="btn btn-default submit" value="Submit" style="margin-left: 138px;">
              </div>

              <div class="clearfix"></div>
              <input type="hidden" name="ActionType" id="ActionType" value="ForgotPassword" >
	    
              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1></i>My Trading Journal</h1>
                  <p>©2018 All Rights Reserved. <br />My Trading Journal is powered by Bootstrap 3.</p>
                </div>
              </div>
            </form>
          </section>
        </div>
		
      </div>
    </div>
  </body>
  
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>

    <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>

    <!-- Custom Theme Scripts -->
    
    <script>
	$(document).ready(function() {
		
		<?php
			if($_GET["Message"] == "OK" || $_GET["Message"] == "UnverifiedFound"){
		?>
				
				new PNotify({
                                  title: 'Notification',
                                  text: 'Please check you email to verify and activate the account.',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
		
			else if($_GET["Message"] == "UserNameExist"){
		?>
				
				new PNotify({
                                  title: 'Error',
                                  text: 'Email exists! Did you forgot your password?',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
			else if($_GET["Message"] == "VerifiedOK"){
		?>
				
				new PNotify({
                                  title: 'Notification',
                                  text: 'Email Verified.',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
			else if($_GET["Message"] == "VerifiedFail"){
		?>
				
				new PNotify({
                                  title: 'Notification',
                                  text: 'Email Already Verified.',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
			else if($_GET["Message"] == "Login Fail"){
		?>
				
				new PNotify({
                                  title: 'Error',
                                  text: 'Invalid Email/Pasword',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
			else if($_GET["Message"] == "ForgotPasswordOK"){
		?>
				
				new PNotify({
                                  title:'Password Reset Request',
                                  text: 'Please Check your email to reset the password.',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
			else if($_GET["Message"] == "ResetPasswordTokenExpired"){
		?>
				
				new PNotify({
                                  title:'Error',
                                  text: 'Reset Password Session Expired.',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
			else if($_GET["Message"] == "PasswordChanged"){
		?>
				
				new PNotify({
                                  title:'Notification',
                                  text: 'Password Changed.',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
		<?php
			}
			else{
		?>
				new PNotify({
                                  title:'Work In Progress',
                                  text: 'Site is still under development. But basic functionality is available.',
                                  type: 'info',
                                  styling: 'bootstrap3',
                                  addclass: 'dark'
                              	});
                <?php              	
			}

		?>		
	});	
</script>
  
</html>
<?php
}
?>
