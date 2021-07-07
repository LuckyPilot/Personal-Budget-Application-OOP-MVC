<?php

namespace App\Controllers;

use \Core\View;
use \App\FlashModals;

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
	
}

?>