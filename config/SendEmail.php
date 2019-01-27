<?php

require './config/PHPMailer/PHPMailer.php';
require './config/PHPMailer/SMTP.php';
require './config/PHPMailer/Exception.php';


use PHPMailer\PHPMailer\PHPMailer;

class SendEmail{
		
	public $mail;
			
	function __construct()    {
		$mail = new PHPMailer(true);
		try {
		    //Server settings
		    $mail->isSMTP();                                      // Set mailer to use SMTP
		    $mail->Host = 'smtp.zoho.com';  // Specify main and backup SMTP servers
		    $mail->SMTPAuth = true;                               // Enable SMTP authentication
		    $mail->Username = 'admin@ezyj.me';                 // SMTP username
		    $mail->Password = 'yWqikr1981';                           // SMTP password
		    $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		    $mail->Port = 465;
		    
		    $this->mail = $mail;                                    // TCP port to connect to				    
		} catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}
									
	}
	
	function SendVerifyUserEmailNow($recipient, $Name, $Token)  {
		try {
		    
		    $mail = $this->mail;
		    		
		    //Recipients
		    $mail->setFrom('admin@ezyj.me', 'Admin');
		    $mail->addAddress($recipient, $Name);     // Add a recipient
		    $mail->addReplyTo('admin@ezyj.me', 'Admin');
		    $mail->addBCC('admin@ezyj.me');
		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'EzyJ.me - Email Verification';
		    $mail->Body    = '<html>
Hi '.$Name.', <br /><br />
Please verify your email address by clicking the link below: <a href="https://'.$_SERVER['SERVER_NAME'].'/verify_email.php?token='.$Token.'">https://'.$_SERVER['SERVER_NAME'].'/verify_email.php?token='.$Token.'</a>.
If the above URL does not work try copying and pasting it into your browser. 
<br /><br />Thank you, <br />The EzyJ.me Team
</html>';
							    		
		    $mail->send();
		    
		} catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}	
	}
	
	function SendResetPasswordEmailNow($recipient, $Token, $Name)  {
		try {
		    
		    $mail = $this->mail;
		    		
		    //Recipients
		    $mail->setFrom('admin@ezyj.me', 'Admin');
		    $mail->addAddress($recipient, $Name);     // Add a recipient
		    $mail->addReplyTo('admin@ezyj.me', 'Admin');
		
		    //Content
		    $mail->isHTML(true);                                  // Set email format to HTML
		    $mail->Subject = 'EzyJ.me - Password Reset';
		    $mail->Body    = '<html>
Hi '.$Name.', <br /><br />
Please click on the link below to reset your password: <a href="https://'.$_SERVER['SERVER_NAME'].'/reset_password.php?token='.$Token.'">https://'.$_SERVER['SERVER_NAME'].'/reset_password.php?token='.$Token.'</a>.
If the above URL does not work try copying and pasting it into your browser. 
<br /><br />Thank you, <br />The EzyJ.me Team
</html>';
							    		
		    $mail->send();
		    
		} catch (Exception $e) {
		    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
		}	
	}

}

?>