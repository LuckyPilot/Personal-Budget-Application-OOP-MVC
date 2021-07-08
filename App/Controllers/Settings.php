<?php

namespace App\Controllers;

use \Core\View;
use \App\FlashModals;
use \App\Models\UserSettings;
use \App\Models\CashFlowSettings;

/**
 * Settings controller
 *
 * PHP version 7.4
 */
class Settings extends Authenticated
{
	
    /**
     * Show the settings page
     *
     * @return void
     */
    public function indexAction() {
		
        View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData] );
		
    }
	
	/**
     * Changing user name
     *
     * @return void
     */
	 public function changeNameAction() {
		 
		 $changeName = new UserSettings( $_POST );
		 $result = $changeName -> changeUserName();
		 
		 if ($result === true) {
			 FlashModals::addModal( "changeNameSuccess" );
			 $this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "profileChangeErrors" => $result] );
		 }
		 
	 }
	 
	 /**
     * Changing user password
     *
     * @return void
     */
	 public function changePasswordAction() {
		 
		 $changePassword = new UserSettings( $_POST );
		 $result = $changePassword -> changeUserPassword();
		 
		 if ($result === true) {
			 FlashModals::addModal( "changePasswordSuccess" );
			 $this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "profileChangeErrors" => $result] );
		 }
		 
	 }
	 
	 /**
     * Changing user login
     *
     * @return void
     */
	 public function changeEmailAction() {
		 
		 $changeEmail = new UserSettings( $_POST );
		 $result = $changeEmail -> changeUserEmail();
		 
		 if ($result === true) {
			 FlashModals::addModal( "changeLoginSuccess" );
			 $this -> redirect( "/settings" );
		 } else {
			 View::renderTemplate( "Settings/settings.html", ["userData" => $this -> userData, "profileChangeErrors" => $result] );
		 }
		 
	 }
	
}

?>