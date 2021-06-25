<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version 7.0
 */
class Config
{

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'lukaszm2_budget';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'lukaszm2_budgetAdmin';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'lakiluk163g16';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = true;
	
	/**
     * Secret key for hashing tokens
     * @var string
     */
	 const SECRET_TOKEN_KEY = '61jSg0jqwXaCfeAdjfAIKHcpcRm0A5KT';
	 
	 /**
     * Secret key for RECAPTCHA
     * @var string
     */
	 const SECRET_RECAPTCHA_KEY = '6LcgSBQbAAAAAIVPk3oaooKUjS3qO3bY3eLoQJgf';
	 		//  6LcgSBQbAAAAAIVPk3oaooKUjS3qO3bY3eLoQJgf secret code do recaptchy serwerowej
			//  6LcVpuMaAAAAAO3UAn-mt-fChaxmGW8Sg-yPX2Vi secret code do recaptchy localhostowej
	 
	/**
     * Name for smtp server
     * @var string
     */
	 const SMTP_HOST = 'mail.lukaszmackow.pl';
	 
	/**
     * Login for smtp server
     * @var string
     */
	 const SMTP_USERNAME = 'personalbudgetapplication@lukaszmackow.pl';
	 
	/**
     * Password for smtp server
     * @var string
     */
	 const SMTP_PASSWORD = 'lakiluk163g16';
}

?>