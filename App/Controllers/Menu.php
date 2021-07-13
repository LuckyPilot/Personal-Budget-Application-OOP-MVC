<?php

namespace App\Controllers;

use \Core\View;
use \App\FlashModals;
use \App\Models\Income;
use \App\Models\Expense;
use \App\Models\ExpenseLimitInformator;
use \App\Models\BalanceGenerator;
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
			 View::renderTemplate( "Usermenu/menu.html", ["userData" => $this -> userData, "incomeResult" => $result] );
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
			View::renderTemplate( "Usermenu/menu.html", ["userData" => $this -> userData, "expenseResult" => $result] );
		}
		 
	}
	
	/**
     * Preparing data when user adding expense and showing modals with expense limit information
     *
     * @return void
     */
	public function informAboutLimitAction() {
		
		$limitController = new ExpenseLimitInformator( $_POST );
		$limitController -> controlExpenseLimit();
		
	}
	
	/**
     * Generating balance from expenses and incomes
     *
     * @return void
     */
	 public function generateBalanceAction() {
		
		 $newBalance = new BalanceGenerator( $_POST );
		 $result = $newBalance -> generateNewBalance();

		 if (empty( $result -> userInputsValidationErrors )) {
			 View::renderTemplate( "Balance/balance.html", ["balance" => $result]);
		 } else {
			 View::renderTemplate( "Usermenu/menu.html", ["userData" => $this -> userData, "balanceErrors" => $result -> userInputsValidationErrors] );
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