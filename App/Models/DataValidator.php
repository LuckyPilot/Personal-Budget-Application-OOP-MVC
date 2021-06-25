<?php

namespace App\Models;

/**
 * Validate user inputs
 *
 * PHP version 7.4
 */
class DataValidator
{
	
	/**
	 * Properties
	 * Array of errors set druing validation process
	 */
	public $validationErrors = [];
	
	/**
	 * Checking whether name is valid. If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateName( $name ) {
		
		 if (strlen( $name ) == 0) {
			 $this -> validationErrors['invalidName'] = "Name is required";
		 } elseif (strlen( $name ) > 20) {
			 $this -> validationErrors['invalidName'] = "Name cas have maximum 20 chars!";
		 }
		 
	}
	
	/**
	 * Checking whether email is valid. If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateEmailFormat( $email ) {
		
		if (strlen( $email ) == 0) {
			$this -> validationErrors['invalidEmail'] = "Email is required!";
		} elseif (!filter_var( $email, FILTER_VALIDATE_EMAIL )) {
			$this -> validationErrors['invalidEmail'] = "Invalid email!";
		}
		
	}
	
	/**
	 * Checking whether email adress already exists in DB or not. If exist set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateEmailAvailability( $email ) {
		
		$user = new User( $email );
		
		if ( $user -> exist ) {
			 $this -> validationErrors['invalidEmail'] = "User with this email alrady exists!";
		}
		
	}
	
	/**
	 * Checking whether password is valid and identical. If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validatePassword( $password, $passwordConfirmation ) {
		
		 if (strlen( $password ) < 8) {
			$this->validationErrors['invalidPassword'] = "Minimum 8 chars are required!";
		} elseif ($password != $passwordConfirmation) {
			$this->validationErrors['invalidPassword'] = "Passwords have to be identical!";
		}
		
	}
	
	/**
	 * Checking whether terms are accepted. If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateTerms( $terms ) {
		
		if ( $terms == NULL ) {
			$this -> validationErrors['invalidTerms'] = "Please confirm terms!";
		}
		
	}
	
	/**
	 * Checking whether reCaptcha is set. If not, set info to validationErrors array
	 *
	 * @return void
	 */
	public function validateCaptcha( $reCaptcha ) {
		
		$checkCode = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . \App\Config::SECRET_RECAPTCHA_KEY . '&response=' . $reCaptcha);
		$captchaResponse = json_decode( $checkCode );
		
		if ($captchaResponse -> success == false) {
			$this -> validationErrors['invalidCaptcha'] = "Please confirm you aren't boot!";
		}
		
	}
	
}

?>