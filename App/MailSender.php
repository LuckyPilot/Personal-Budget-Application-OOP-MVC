<?php

namespace App;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Sending email by PHPMailer API
 *
 * PHP version 7.4
 */
class MailSender
{
	
	/**
	 * Send an email
	 *
	 * @param string $to Email adress of receiver
	 * @param string $subject Title of email
	 * @param string $text Text content of message
	 * @param string $html HTML content of message
	 *
	 * @return mixed
	 */
	 public static function sendEmail( $to, $subject, $text, $html ) {
		 
		//Instantiation and passing `true` enables exceptions
		$mail = new PHPMailer( true );

			//Server settings
			//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
			$mail -> isSMTP();                                            				//Send using SMTP
			$mail -> Host       = Config::SMTP_HOST;                     //Set the SMTP server to send through
			$mail -> SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail -> Username   = Config::SMTP_USERNAME;                     //SMTP username
			$mail -> Password   = Config::SMTP_PASSWORD;                               //SMTP password
			$mail -> SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
			$mail -> Port = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail -> setFrom( 'personalbudgetapplication@lukaszmackow.pl', 'Personal Budget Application' );
			$mail -> addAddress( $to );     //Add a recipient

			//Content
			$mail -> isHTML(true);                                  //Set email format to HTML
			$mail -> Subject = $subject;
			$mail -> Body    = $html;
			$mail -> AltBody = $text;

			if ($mail -> send()) {
				return true;
			} else {
				return false;
			}
	
	}


	
}

?>