<?php

namespace App\Controllers;

use \Core\View;
use \App\FlashModals;
use \App\Models\Income;
use \App\Models\Expense;
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
     * Adding income to DB and showing modal if success
     *
     * @return void
     */
	 public function addIncomeAction() {
		 
		 $newIncome = new Income( $_POST );
		 $result = $newIncome -> addIncome();
		 
		 if ($result === true) {
			 FlashModals::addModal( "incomeSuccess" );
			 $this -> redirect( "/usermenu" );
		 } else {
			 View::renderTemplate( "Usermenu/menu.html", ["userData" => $this -> userData, "incomeErrors" => $result] );
		 }
		 
	 }
	 
	/**
     * Adding expense to DB and showing modal if success
     *
     * @return void
     */
	public function addExpenseAction() {
		 
		$newExpense = new Expense( $_POST );
		$result = $newExpense -> addExpense();
		 
		if ($result === true) {
			FlashModals::addModal( "expenseSuccess" );
			$this -> redirect( "/usermenu" );
		} else {
			View::renderTemplate( "Usermenu/menu.html", ["userData" => $this -> userData, "expenseErrors" => $result] );
		}
		 
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