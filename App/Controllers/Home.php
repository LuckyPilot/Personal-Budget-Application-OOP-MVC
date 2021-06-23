<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\UserManager;
use \App\FlashModals;
use \App\MailSender;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Home extends \Core\Controller
{
	
    /**
     * Show the home page
     *
     * @return void
     */
    public function indexAction() {
		
		$user = new UserManager();
		
		if ($user -> isUserLoggedIn()) {
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
		
		$user = new UserManager();
		$result = $user -> registerNewUser(  $_POST );
		
		if ( $result === true ) {
			FlashModals::addModal( "registrationSuccess" );
			$this -> redirect( "/" );
		} else {
			View::renderTemplate( "Home/home.html", ["regUser" => $result] );
		}
		
	}
	 
	 /**
     * Log in user and saving userId in session array
     *
     * @return void
     */
	public function logInAction() {
		
		$user = new UserManager();
		$result = $user -> logInUser( $_POST );
		
		if ( $result === true ) {
			$this -> redirect( $this -> getRequestedPage() );
		} else {
			View::renderTemplate( "Home/home.html", ["logUser" => $result] );
		}	
		
	}
	 
	 /**
     * Showing success modal when correctly loged out
     *
     * @return void
     */
	 public function logOutAction() {
		 
		 FlashModals::addModal( "logOutSuccess" );
		 $this -> redirect( "/" );
		 
	 }
	 
}

?>