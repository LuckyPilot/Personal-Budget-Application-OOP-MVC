<?php

namespace App;

/**
 * Application configuration
 * All data with empty "" should be fulfilled own data:)
 *
 * PHP version 7.4
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
    const DB_USER = '';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = '';

    /**
     * Show or hide error messages on screen
     * @var boolean
     */
    const SHOW_ERRORS = false;
	
	/**
     * Secret key for hashing tokens
     * @var string
     */
	 const SECRET_TOKEN_KEY = '';
	 
	 /**
     * Secret key for RECAPTCHA
     * @var string
     */
	 const SECRET_RECAPTCHA_KEY = '';
	 
	/**
     * Name for smtp server
     * @var string
     */
	 const SMTP_HOST = '';
	 
	/**
     * Login for smtp server
     * @var string
     */
	 const SMTP_USERNAME = 'personalbudgetapplication@lukaszmackow.pl';
	 
	/**
     * Password for smtp server
     * @var string
     */
	 const SMTP_PASSWORD = '';
}

?>