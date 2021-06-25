<?php

namespace App\Controllers;

use \Core\View;
use \App\FlashModals;
use \App\Models\Logout;

/**
 * Menu controller
 *
 * PHP version 7.4
 */
class Menu extends Authenticated
{
	
    /**
     * Show the menu page
     *
     * @return void
     */
    public function indexAction() {
		
        View::renderTemplate( "Usermenu/menu.html", ["userData" => $this -> userData] );
		
    }
	
	/**
     * Log out user
     *
     * @return void
     */
	public function logOutAction() {
		
		$logOut = new Logout();
		$logOut -> logOutUser();
		$this -> redirect( "/logout" );
		
	}
	
}

?>