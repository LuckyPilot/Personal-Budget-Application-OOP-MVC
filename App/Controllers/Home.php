<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\Registration;
use \App\Models\Login;
use \App\Models\LoginToken;
use \App\FlashModals;

/**
 * Home controller
 *
 * PHP version 7.4
 */
class Home extends \Core\Controller
{
	
    /**
     * Show the home page
     *
     * @return void
     */
    public function indexAction() {
		
		$user = new Login();
		
		if ($user -> isUserLoggedIn()) {
			FlashModals::addModal( "logInSuccess");
			$this -> redirect( "/usermenu" );
		} else {
			View::renderTemplate( "Home/home.html" );
		}
        
    }
	
	/**
     * Register new user and showing success modal when correctly signed up
     *
     * @return void
     */
	public function registerAction() {
		
		$newUser = new Registration( $_POST );
		$result = $newUser -> registerNewUser();
		
		if ( $result === true ) {
			FlashModals::addModal( "registrationSuccess" );
			$this -> redirect( "/home" );
		} else {
			View::renderTemplate( "Home/home.html", ["regErrors" => $result] );
		}
		
	}
	 
	 /**
     * Log in user and saving userId in session array
     *
     * @return void
     */
	public function logInAction() {
		
		$logUser = new Login( $_POST );
		$result = $logUser -> logInUser( $_POST );
		
		if ( $result === true ) {
			FlashModals::addModal( "logInSuccess");
			$this -> redirect( $this -> getRequestedPage() );
		} else {
			View::renderTemplate( "Home/home.html", ["loginError" => $result] );
		}	
		
	}
	 
	 /**
     * Showing success modal when correctly loged out
     *
     * @return void
     */
	 public function logOutAction() {
		 
		 FlashModals::addModal( "logOutSuccess" );
		 $this -> redirect( "/home" );
		 
	 }
	 
}

?>