<?php

namespace Core;

/**
 * Base controller
 *
 * PHP version 7.0
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params)
    {
        $this->route_params = $route_params;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name  Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }
	
	 /**
     * Redirecting method to given url adress
     *
     * @return void
     */
	protected function redirect($url) {
		header( "Location: https://".$_SERVER['HTTP_HOST'].$url , true, 303 );
		exit();
	}
	
	 /**
     * Require user to be logged in before giving access to the page, remember requested page to redirect to this page after log in.
	 * If user is not logged in redirect to home page.
     *
     * @return void
     */
	protected function requireLogin() {
		if (!isset( $_SESSION['userId'])) {
			$this->rememberRequestedPage();
			$this->redirect( "/" );
		}
	}
	
	 /**
     * Remember the originally requested page in the session
     *
     * @return void
     */
    private function rememberRequestedPage() {
		$_SESSION['requestedPage'] = $_SERVER['REQUEST_URI'];
	}
	
	/**
     * Get requested page url after login or usermenu page otherwise
     *
     * @return url of requested page or url to usermenu page
     */
    protected function getRequestedPage() {
		return $_SESSION['requestedPage'] ?? "/usermenu";
	}
}

?>