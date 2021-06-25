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
	 * Values sent by user during password changing/reseting process
	 */
	 private $requestResetEmail = NULL;
	 private $reCaptcha = NULL;
	 private $newPassword = NULL;
	 private $newPasswordConfirmation = NULL;
	 private $resetTokenValue = NULL;
	 
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
	 * Starting reset password procedure by sending email with password reset link to user    
	 *
	 * @return true if success, otherwise false
	 */
	public function requestPasswordReset() {
		 
		$validationErrors = $this -> validateUserEmailInput();
		 
		 if (empty( $validationErrors )) {
			$user = new User( $this -> requestResetEmail );
			 
			 if ($user -> exist) {
				$resetTokenValue = $this -> preparePasswordResetToken( $user -> id );
				if ($this -> sendPasswordResetEmail( $resetTokenValue )) {
					return true;
				}
			}
		}
		 
		 return $validationErrors;
		 
	} 
	
	public function resetUserPassword() {
		
		$validationErrors = $this -> validateUserPasswordInput();
		 
		 if (empty( $validationErrors )) {
			$passwordResetToken = new PasswordResetToken( $this -> resetTokenValue );
			$tokenDataFromDB = $passwordResetToken -> findTokenInDB();
			
			if ($this -> changeUserPassword( $tokenDataFromDB -> user_id )) {
				$passwordResetToken -> deleteTokenFromDB( $tokenDataFromDB -> user_id );
				return true;
			}
		}
		 
		 //return $validationErrors;
		
	}
	
	public function changeUserPassword( $userId ) {
	
		$sql = "UPDATE users SET password = :newPassword WHERE id = :userId ";
		$passwordHash = password_hash( $this -> newPassword, PASSWORD_DEFAULT );
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":newPassword", $passwordHash , PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $userId, PDO::PARAM_INT );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Checking whether passwordResetToken given from URL exists and is valid, if not valid remove it from DB
	 *
	 * @param string $tokenValue Token value fetched from URL
	 *
	 * @return true if exists and is valid, otherwise false
	 */
	public function checkPasswordResetToken( $tokenValue ) {
		
		$passwordResetToken = new PasswordResetToken( $tokenValue );
		$tokenDataFromDB = $passwordResetToken -> findTokenInDB();
		
		if ($tokenDataFromDB) {
			$passwordResetToken -> setExpiryDate( $tokenDataFromDB -> expiry_date );
			
			if ($passwordResetToken -> checkExpiryDate()) {
				return true;
			} else {
				$passwordResetToken -> deleteTokenFromDB();
			}
		}
		
		return false;
		
	}
	
	/**
	 * Validating request password reset form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateUserEmailInput() {
		 
		$inputValidation = new DataValidator();
		 
		$inputValidation -> validateEmailFormat( $this -> requestResetEmail );
		$inputValidation -> validateCaptcha( $this -> reCaptcha );
		 
		return $inputValidation -> validationErrors;
	}
	
	/**
	 * Validating password reset form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateUserPasswordInput() {
		 
		$inputValidation = new DataValidator();
		 
		$inputValidation -> validatePassword( $this -> newPassword, $this -> newPasswordConfirmation );
		 
		return $inputValidation -> validationErrors;
	}
	 
	/**
	 * Sending reset password link to given email
	 *
	 * @param string $resetPasswordTokenValue Value of token to reset password link
	 *
	 * @return true if mail sent, otherwise false
	 */
	private function sendPasswordResetEmail( $resetPasswordTokenValue ) {
		
		if ($resetPasswordTokenValue != false) {
			$resetURL = $this -> prepareResetPasswordURL( $resetPasswordTokenValue );
			$emailText = \Core\View::getTemplate( "RequestPasswordReset/requestResetEmail.txt", [ "resetURL" => $resetURL ] );
			$emailHtml = \Core\View::getTemplate( "RequestPasswordReset/requestResetEmail.html", [ "resetURL" => $resetURL ] );
			$emailSubject = "Password reset Personal Budget Application";
			if (MailSender::sendEmail( $this -> requestResetEmail, $emailSubject, $emailText, $emailHtml )) {
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
		 
		 $resetURL = "https://" . $_SERVER["HTTP_HOST"] . "/password/reset/" . $resetTokenValue;
		 return $resetURL;
		 
	}
	
}

?>