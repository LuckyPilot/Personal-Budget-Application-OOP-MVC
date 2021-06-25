<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Password;
use \App\FlashModals;

/**
 * Home controller
 *
 * PHP version 7.4
 */
class PasswordReset extends \Core\Controller
{
	
	/**
     * Show the reset password page
     *
     * @return void
     */
    public function indexAction() {
		
		$passwordResetToken = $this -> route_params["token"];
		
		$newPassword = new Password();
		
		if ($newPassword -> checkPasswordResetToken( $passwordResetToken )) {
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
		
		$newPassword = new Password( $_POST );
		$result = $newPassword -> resetUserPassword();
		
		 if ($result === true) {
			FlashModals::addModal( "passwordResetSuccess" );
		 } 
		 
		View::renderTemplate( "PasswordReset/passwordReset.html", ["passResetErrors" => $result] );
		
	}
	
}

?>