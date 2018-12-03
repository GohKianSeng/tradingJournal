<?php
include './config/MysqlConn.php';

session_start();

if(isset($_GET["token"])){

	$sqlconn = new MysqlConn();
	$tradeResult = $sqlconn->VerifyResetPaswoordToken($_GET["token"]);
	if (isset($tradeResult)){
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
    <!-- NProgress -->
    <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Animate.css -->
    <link href="../vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="../build/css/custom.css?bbb" rel="stylesheet">
    
    <style type="text/css" media="screen">

	.alert {
	  text-shadow: 0 0px 0 #fff;
	  
	}

    </style>

  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="resetpassword"></a>
      
      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form action="/PerformTransaction.php" method="post">
              <h1>Reset Password</h1>
              <div class="item form-group">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="" style="margin-bottom: 0px;" />
              </div>
              <div style="height:30px"> </div>
              <div class="item form-group">
              	<input type="password" class="form-control" id="password2" name="password2" data-validate-linked="password" placeholder="Type Password Again" required="" style="margin-bottom: 0px" />
              </div>
              
              <div>                
                <input type="submit" class="btn btn-default submit" value="Submit" style="margin-left: 130px;">                                
              </div>
              <input type="hidden" name="ActionType" id="ActionType" value="ResetPasswordNow" >
	      <input type="hidden" name="Token" id="Token" value="<?php echo $_GET["token"] ?>" >	      
              <div class="clearfix"></div>

              <div class="separator">
                                
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

    </body>
  
  
    <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>      
    
    <!-- PNotify -->
    <script src="../vendors/pnotify/dist/pnotify.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.buttons.js"></script>
    <script src="../vendors/pnotify/dist/pnotify.nonblock.js"></script>
    <script src="../vendors/validator/validator.js"></script>
    <!-- Custom Theme Scripts -->
    
    <script>
    	function init_validator () {
		 
	    if( typeof (validator) === 'undefined'){ return; }
	    console.log('init_validator'); 
	  
		  // initialize the validator function
	      validator.message.date = 'not a real date';
	
	      // validate a field on "blur" event, a 'select' on 'change' event & a '.reuired' classed multifield on 'keyup':
	      $('form')
	        .on('blur', 'input[required], input.optional, select.required', validator.checkField)
	        .on('change', 'select.required', validator.checkField)
	        .on('keypress', 'input[required][pattern]', validator.keypress);
	
	      $('.multi.required').on('keyup blur', 'input', function() {
	        validator.checkField.apply($(this).siblings().last()[0]);
	      });
	
	      $('form').submit(function(e) {
	        e.preventDefault();
	        var submit = true;
	
	        // evaluate the form using generic validaing
	        if (!validator.checkAll($(this))) {
	          submit = false;
	        }
	
	        if (submit)
	          this.submit();
	
	        return false;
			});
		  
	  };
    
	$(document).ready(function() {
		init_validator();
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

		?>		
	});	
</script>
  
</html>
<?php
}
else{
	header('Location: login.php?Message=ResetPasswordTokenExpired');;
}

}
?>
