<?php

namespace App\Models;

/**
 * Unique random tokens
 *
 * PHP version 7.4
 */
abstract class Token extends \Core\Model
{
	
	/**
	 * Properties
	 */
	public ?string $value = NULL;
	public ?string $expiryDate = NULL;  //(format Y-m-d H:i:s) 
	 
	 /**
	 * Class constructor. Create exisitng token or new random token if token not exist
	 *
	 * @return void
	 */
	public function __construct( ?string $tokenValue = NULL ) {
		 
		 if ($tokenValue) {
			 $this -> value = $tokenValue;
		 } else {
			 $this -> value = bin2hex( random_bytes( 16 ) );
		 }
		 
	}
	
	/**
	 * Get the token value
	 *
	 * @return string $token The value
	 */
	public function getTokenValue() { 
	
		 return $this -> value;
		 
	}
	
	/**
	 * Get the hashed token value
	 *
	 * @return string $token The hashed value
	 */
	public function getHashedToken() {
		
		 return hash_hmac( "sha256", $this -> value, \App\Config::SECRET_TOKEN_KEY );
		 
	}
	
	/**
	 * Set the token expiry date
	 *
	 * @return void
	 */
	public function setExpiryDate( $expiryDate ) { 
	
		 $this -> expiryDate = $expiryDate;
		 
	}
	
	/**
	 * Checking expiry date of user token fetched from DB based on rememberMe cookie
	 *
	 * @return true if valid or false if expired
	 */
	public function checkExpiryDate() {
		
		if (strtotime( $this -> expiryDate ) < time()) {
			return false;
		}
		
		return true;
	}
	
}

?>