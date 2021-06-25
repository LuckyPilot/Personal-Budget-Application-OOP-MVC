<?php

namespace App\Controllers;

use \App\Models\LoggedUser;

/**
 * Authenticated controller
 * Parent controller for all controllers to which access is given only for logged users
 * Property of this controller includes all logged user datas require to application work.
 *
 * PHP version 7.4
 */
abstract class Authenticated extends \Core\Controller
{
	
	/**
	 * Properties
	 * User related object with all user datas from DB
	 */
	public $userData = NULL;
	
	/**
	 * Class constructor 
	 * Fetching all user datas from DB as LoggedUser object and assign them to $userData
	 *
	 * @return void
	 */
	public function __construct() {
		
		if (isset($_SESSION["userId"])){
			$this -> userData = new LoggedUser( $_SESSION["userId"] );
		}
		
		
	}

	 /**
     * Require from user to be authenticated before giving access to all methods in the controller
     *
     * @return void
     */
    protected function before() {
		$this->requireLogin();  
    }
	
}

?>