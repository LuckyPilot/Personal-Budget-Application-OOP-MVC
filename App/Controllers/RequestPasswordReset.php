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
class RequestPasswordReset extends \Core\Controller
{
	
    /**
     * Show the request reset password page
     *
     * @return void
     */
    public function indexAction() {
		
		View::renderTemplate( "RequestPasswordReset/requestPasswordReset.html" );
		
	}
	 
	/**
     * Send email wih password reset link or display input validation errors
     *
     * @return void
     */
	public function requestPasswordResetAction() {
		
		$newPassword = new Password( $_POST );
		$result = $newPassword -> requestPasswordReset();
		
		 if ($result === true) {
			 $this -> redirect( "/request-password-reset-success" );
		 } elseif(empty( $result )) {
			 FlashModals::addModal( "requestPasswordResetFail" );
		 }
		 
		View::renderTemplate( "RequestPasswordReset/requestPasswordReset.html", ["reqPassResetErrors" => $result] );
		
	}
	
	/**
     * Show the reset password success message
     *
     * @return void
     */
	public function requestPasswordResetSuccess() {
		
		FlashModals::addModal( "requestPasswordResetSuccess" );
		$this -> redirect( "/request-password");
		
	}
	
	/**
     * Reseting user password
     *
     * @return void
     */
	public function passwordResetAction() {
		
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