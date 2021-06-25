<?php

namespace App\Models;

use PDO;
use \App\MailSender;

/**
 * Managing passwords cases
 *
 * PHP version 7.4
 */
class Password extends \Core\Model
{
	
	/**
	 * Properties
	 * Values sent by user during password reset process
	 */
	 private $resetEmail = NULL;
	 private $reCaptcha = NULL;
	 
	 /**
	 * Class constructor
	 *
	 * @param array $data Initial property values
	 *
	 * @return void
	 */
	 public function __construct( $data = [] ) {
		 
		 foreach ($data as $key => $value) {
			if ($key == "g-recaptcha-response") {
				$this -> reCaptcha = $value;
			} else {
				$this -> $key = $value;
			}			
		}
		 
	 }
	
	/**
	 * Reseting password by sending email with password reset link to user
	 *
	 * @return true if success, otherwise false
	 */
	public function resetUserPassword() {
		 
		$validationErrors = $this -> validateUserEmailInput();
		 
		 if (empty( $validationErrors )) {
			$user = new User( $this -> resetEmail );
			 
			 if ($user -> exist) {
				$resetTokenValue = $this -> preparePasswordResetToken( $user -> id );
				if ($this -> sendPasswordResetEmail( $resetTokenValue )) {
					return true;
				}
			}
		}
		 
		 return $validationErrors;
		 
	} 
	 
	/**
	 * Validating property values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateUserEmailInput() {
		 
		$inputValidation = new DataValidator();
		 
		$inputValidation -> validateEmailFormat( $this -> resetEmail );
		$inputValidation -> validateCaptcha( $this -> reCaptcha );
		 
		return $inputValidation -> validationErrors;
	}
	 
	/**
	 * Sending reset password link to given email
	 *
	 * @param string $resetPasswordTokenValue Value of token to reset password link
	 *
	 * @return true if mail sent, otherwise false
	 */
	public function sendPasswordResetEmail( $resetPasswordTokenValue ) {
		
		if ($resetTokenValue != false) {
			$resetURL = $this -> prepareResetPasswordURL( $resetPasswordTokenValue );
			$emailText = \Core\View::getTemplate( "RegainPassword/resetEmail.txt", [ "resetURL" => $resetURL ] );
			$emailHtml = \Core\View::getTemplate( "RegainPassword/resetEmail.html", [ "resetURL" => $resetURL ] );
			$emailSubject = "Password reset Personal Budget Application";
			if (MailSender::sendEmail( $this -> resetEmail, $emailSubject, $emailText, $emailHtml )) {
				return true;
			}
		}
		
		return false;
		
	}
	
	/**
	 * Prepering password reset token by generating unique token and save that in DB
	 *
	 * @param int $userId Id of user which password should be prepare to reset
	 *
	 * @return token value if success or false otherwise
	 */
	 private function preparePasswordResetToken( $userId ) {
		 
		$userToken = new PasswordResetToken();
		 
		// Setting date how long reset password link will be valid ( 2hours )
		$expiryDate = date( "Y-m-d H:i:s", time() + 60 * 60 * 2 );  
		$userToken -> setExpiryDate( $expiryDate );
		
		if ($userToken -> addHashedTokenToDB( $userId )) {
			return $userToken -> value;
		}

		return false;
		 
	}
	
	/**
	 * Prepering password reset URL based on unique token
	 *
	 * @param string $resetToken Token generated for reset password for user
	 *
	 * @return string $resetURL Reset URL
	 */
	 private function prepareResetPasswordURL( $resetTokenValue ) {
		 
		 $resetURL = "http://" . $_SERVER["HTTP_HOST"] . "/pasword/reset" . $resetTokenValue;
		 return $resetURL;
		 
	}
	
}

?>