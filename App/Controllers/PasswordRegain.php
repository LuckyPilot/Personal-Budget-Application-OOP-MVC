<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\PasswordReset;
use \App\FlashModals;

/**
 * Home controller
 *
 * PHP version 7.4
 */
class PasswordRegain extends \Core\Controller
{
	
	/**
     * Show the reset password page
     *
     * @return void
     */
    public function indexAction() {
		
		$passwordResetToken = $this -> route_params["token"];
		
		$passwordReset = new PasswordReset();
		
		if ($passwordReset -> checkPasswordResetToken( $passwordResetToken )) {
			View::renderTemplate( "PasswordReset/passwordReset.html", ["passwordResetToken" => $passwordResetToken] );
		} else {
			View::renderTemplate( "PasswordReset/invalidPasswordResetToken.html" );
		}
		
	}
	
	/**
     * Reseting user password
     *
     * @return void
     */
	public function resetPasswordAction() {
		
		$passwordReset = new PasswordReset( $_POST );
		$result = $passwordReset -> resetUserPassword();
		
		if ($result === true) {
			FlashModals::addModal( "passwordResetSuccess" );
		}
		 
		View::renderTemplate( "PasswordReset/passwordReset.html", ["passResetErrors" => $result] );
		
	}
	
}

?>