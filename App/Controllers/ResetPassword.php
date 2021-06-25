<?php

namespace App\Controllers;

use \Core\View;
use \App\FlashModals;
use \App\Models\Password;

/**
 * Home controller
 *
 * PHP version 7.4
 */
class ResetPassword extends \Core\Controller
{
	
    /**
     * Show the request reset password page
     *
     * @return void
     */
    public function indexAction() {
		
		View::renderTemplate( "RegainPassword/regainPassword.html" );
		
	}
	 
	/**
     * Send email wih password reset link or display input validation errors
     *
     * @return void
     */
	public function requestPasswordResetAction() {
		
		$newPassword = new Password( $_POST );
		$result = $newPassword -> resetUserPassword();
		
		 if ($result === true) {
			 $this -> redirect( "/password-reset-success" );
		 } elseif(empty( $result )) {
			 FlashModals::addModal( "passwordResetFail" );
		 }
		 
		View::renderTemplate( "RegainPassword/regainPassword.html", ["passResetErrors" => $result] );
		
	}
	
	/**
     * Show the reset password success message
     *
     * @return void
     */
	public function passwordResetSuccess() {
		
		FlashModals::addModal( "passwordResetSuccess" );
		$this -> redirect( "/regain-password");
		
	}
	
	/**
     * Going back to home page after showing reet password succes message
     *
     * @return void
     */
	public function backToLoginPageAction() {
		
		$this -> redirect( "/home" );
		
	}
	
}

?>