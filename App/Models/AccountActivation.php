<?php

namespace App\Models;

use \App\MailSender;

/**
 * Sign up new user to application
 *
 * PHP version 7.4
 */
class AccountActivation 
{
	/**
	 * Properties
	 */
	 private $activationTokenValue;
	 
	/**
	 * Class constructor
	 *
	 * @param string $tokenValue Activation token value
	 *
	 * @return void
	 */
	public function __construct( $tokenValue ) {
		
		$this -> activationTokenValue = $tokenValue;
		
	}
	
	/**
	 * Activate user account after clicking on link sent during registration proces
	 *
	 * @return true if account is activated and false otherwise
	 */
	public function activateAccount() {
		
		$activationToken = new AccountActivationToken( $this -> activationTokenValue );
		
		if ($activationToken -> findTokenInDB()) {
			$activationToken -> deleteTokenFromDB();
			
			return true;
		}
		
		return false;
		
	}
	
	/**
	 * Sending account activation link to registration email
	 *
	 * @param string $userEmail Email of registered user
	 *
	 * @return true if mail sent, otherwise false
	 */
	public function sendActivationEmail( $userEmail ) {
		
		$activationURL = $this -> prepareActivationURL( $this -> activationTokenValue );
		$emailText = \Core\View::getTemplate( "Home/accountActivationEmail.txt", [ "activationURL" => $activationURL ] );
		$emailHtml = \Core\View::getTemplate( "Home/accountActivationEmail.html", [ "activationURL" => $activationURL ] );
		$emailSubject = "Account activation Personal Budget Application";
		if (MailSender::sendEmail( $userEmail, $emailSubject, $emailText, $emailHtml )) {
			return true;
		}
		
		return false;
		
	}
	
	/**
	 * Prepering account activation URL based on unique token
	 *
	 * @return string $activationURL Account activation URL
	 */
	 private function prepareActivationURL() {
		 
		 $activationURL = "https://" . $_SERVER["HTTP_HOST"] . "/account-activation/" . $this -> activationTokenValue;
		 return $activationURL;
		 
	}
	 
}

?>