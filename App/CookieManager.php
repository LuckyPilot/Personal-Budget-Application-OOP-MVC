<?php

namespace App;

/**
 * Managing cookie on site
 *
 * PHP version 7.4
 */
class CookieManager 
{
	
	/**
	 * Create cookie
	 *
	 * @param string $cookieName Name of cookie
	 * @param mixed $cookieValue Value of cookie
	 * @param int(unix timestamp) $cookieExpiryDate Expiry date of cookie, default max unix time
	 * @param string $cookiePath Path of cookie, default whole domain
	 *
	 * @return void
	 */
	public static function createCookie( $cookieName, $cookieValue, $cookieExpiryDate = 2147483647, $cookiePath =  "/" ) {
		
		setcookie( $cookieName, $cookieValue, $cookieExpiryDate, $cookiePath);
		
	}
	
	/**
	 * Delete cookie 
	 *
	 * @param string $cookieName Name of cookie
	 *
	 * @return void
	 */
	public static function deleteCookie( $cookieName ) {
		
		return setcookie( $cookieName, "", time() - 3600, "/" );
		
	}

	
}

?>