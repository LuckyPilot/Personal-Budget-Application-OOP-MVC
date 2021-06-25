<?php

namespace App\Models;

use \App\CookieManager;
use \App\FlashModals;

/**
 * Log in user to application
 *
 * PHP version 7.4
 */
class Login
{
	
	/**
	 * Properties
	 * Values sent by user during log in process
	 */
	 private $login = NULL;
	 private $password = NULL ;
	 
	/**
	 * Class constructor
	 *
	 * @param array $data values inserted during log in by user
	 *
	 * @return void
	 */
	public function __construct( $data=[] ) {
		
		foreach ($data as $key => $value) {
				$this -> $key = $value;
		};
		
	}
	
	/**
	 * Log in user
	 *
	 * @return true if new user login data are correct or string - error message otherwise
	 */
	public function logInUser() {
		
		$userFromDB = new User( $this -> login );
		
		if ($userFromDB -> exist) {
			if ($this -> authenticatePassword( $userFromDB -> hashedPassword )) {
				session_regenerate_id( true );
				$_SESSION["userId"] = $userFromDB -> id;
				
				if (isset( $this -> rememberMe )) {
					$this -> rememberUserAsLoggedIn();
				}
				
				return true;
			}
		} 

		return "Incorrect login or password!";
		
	}
	
	/**
	 * Log in user from remembered login function by token value from rememberMe cookie
	 *
	 * @return true if logged in successful or false otherwise
	 */
	public function loginFromRememberMe() {
		
		$loginCookie = $_COOKIE["rememberMe"] ?? false;
		
		if ($loginCookie) {
			$loginToken = new LoginToken( $loginCookie );
			$tokenDataFromDB = $loginToken -> findTokenInDB();
			
			if ($tokenDataFromDB) {
				$loginToken -> setExpiryDate( $tokenDataFromDB -> expiry_date );
				
				if ($loginToken -> checkExpiryDate()) {
					session_regenerate_id( true );
					$_SESSION["userId"] = $tokenDataFromDB -> user_id;
					return true;
				} else {
					$loginToken -> deleteTokenFromDB();
				}
			}
		}
		
		return false;
		
	}
	
	/**
	 * Authenticating inserted password
	 *
	 * @param string $correctPassword User password in hashed version from DB
	 *
	 * @return true if correct otherwise false
	 */
	 private function authenticatePassword( $correctPasword ) {
		 
		return password_verify( $this -> password, $correctPasword ); 
			
	}
	
	/**
	 * Checking whether user is already logged in
	 *
	 * @return true if user is already logged in or false otherwise
	 */
	public function isUserLoggedIn() {
		
		if (isset( $_SESSION["userId"] )) {
			return true;
		} elseif ($this -> loginFromRememberMe()) {
			return true;
		}
		
		return false;
		
	}
	
	/**
	 * Remember user for future log in action by setting login token in DB and create rememberMe cookie
	 *
	 * @return void
	 */
	private function rememberUserAsLoggedIn() {
		
		$userToken = new LoginToken();
		
		// Setting date how long application should remember user as logged in ( 1 month )
		$expiryDate = date( "Y-m-d H:i:s", time() + 60 * 60 * 24 * 30 );
		$userToken -> setExpiryDate( $expiryDate );
		
		if ($userToken -> addHashedTokenToDB()) {
			CookieManager::createCookie( "rememberMe", $userToken -> value );
		}
		
	}
	
}

?>