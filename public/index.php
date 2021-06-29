<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';


/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Starting session
 */
 session_start();

/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('home', ['controller' => 'Home', 'action' => 'index']);
$router->add('registration', ['controller' => 'Home', 'action' => 'register']);
$router->add('account-activation/{token:[\da-f]+}', ['controller' => 'Home', 'action' => 'activateAccount']);
$router->add('login', ['controller' => 'Home', 'action' => 'logIn']);
$router->add('logout', ['controller' => 'Home', 'action' => 'logOut']);
$router->add('usermenu', ['controller' => 'Menu', 'action' => 'index']);
$router->add('add-income', ['controller' => 'Menu', 'action' => 'addIncome']);
$router->add('add-expense', ['controller' => 'Menu', 'action' => 'addExpense']);
$router->add('request-password', ['controller' => 'RequestPasswordReset', 'action' => 'index']);
$router->add('request-password-reset', ['controller' => 'RequestPasswordReset', 'action' => 'requestPasswordReset']);
$router->add('request-password-reset-success', ['controller' => 'RequestPasswordReset', 'action' => 'requestPasswordResetSuccess']);
$router->add('password-reset/{token:[\da-f]+}', ['controller' => 'PasswordRegain', 'action' => 'index']);
$router->add('reset-password', ['controller' => 'PasswordRegain', 'action' => 'resetPassword']);
$router->add('{controller}/{action}');
    
$router->dispatch($_SERVER['QUERY_STRING']);

?>