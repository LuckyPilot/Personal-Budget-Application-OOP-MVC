<?php

namespace App\Models;

use \App\CookieManager;

/**
 * Log out user from application
 *
 * PHP version 7.4
 */
class Logout 
{
	/**
	 * Log out user by destroying session, login token from DB and rememberMe cookie
	 *
	 * @return void
	 */
	 public function logOutUser() {
		 
		//Disable automatic login from remember me functionality
		$this -> disableAutomaticLogin();
		 
		// Unset all of the session variables.
		$_SESSION = array();

		// Delete other session cookies.
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}

		// Finally, destroy the session.
		session_destroy();
		
	}
	
	/**
	 * Deleting user token from remembers_logins table in DB
	 *
	 * @return void
	 */
	private function disableAutomaticLogin() {
		
		$rememberMeCookie = $_COOKIE["rememberMe"] ?? false;
		
		if ($rememberMeCookie) {
			$loginToken = new RememberLoginToken( $rememberMeCookie );
			$loginToken -> deleteTokenFromDB();
			CookieManager::deleteCookie( "rememberMe" );
		}
		
	}

	
}

?>