<?php

namespace App\Models;

/**
 * Expense limit informator
 *
 * PHP version 7.4
 */
class ExpenseLimitInformator 
{
	
	/**
	 * Properties
	 */
	 private $expenseAmount = NULL;
	 private $expenseLimit = NULL;
	 private $expenseCategory = NULL;
	 private $expenseCategoryId = NULL;
	 
	/**
	 * Class constuctor.
	 *
	 * @param $userInputs Array sent by AJAX from expense form.
	 *
	 * @return void
	 */
	public function __construct( $userInputs ) {
		
		$this -> expenseCategory = $userInputs["category"];
		
		if (is_numeric( $userInputs["amount"] )) {
			$this -> expenseAmount = $userInputs["amount"];
		} else {
			$this -> expenseAmount = 0;
		}
		
		$dataFromDB = Expense::findExpenseCategoryInDB( $userInputs["category"] );
		$this -> expenseLimit = $dataFromDB -> expense_limit;
		$this -> expenseCategoryId = $dataFromDB -> id;
		
	}
	
	/**
	 * Function called by ajax to display bootstrap alert message when expenses in chose category go beyond set limit
	 *
	 * @return void
	 */
	public function controlExpenseLimit(){
		
		if ($this -> expenseLimit == NULL) {
			$HTMLResponse = $this -> prepareNoLimitExpense();
		} else {
			$dataFromDB = Expense::fetchExpensesByCategoryFromDB( $this -> expenseCategoryId );
			$expenseSumFromDB = $dataFromDB["sum"] ?? 0;
			$diff = $this -> expenseLimit - $this -> expenseAmount - $expenseSumFromDB;

			if ($diff < 0) {
				$HTMLResponse = $this -> prepareExceedLimitExpense( $diff );
			} else {
				$HTMLResponse = $this -> prepareLimitExpense( $diff, $expenseSumFromDB );
			}
		}
		
		echo $HTMLResponse;
		
	}
	
	/**
	 * Prepering response if limit wasn't set
	 *
	 * @return string $response String with html code to display alert
	 */
	private function prepareNoLimitExpense() {
		
		$response = '<div class="alert alert-info">Expense limit in category: <strong>'.$this -> expenseCategory.' </strong>wasn\'t set.</div>';
		
		return $response;
		
	}
	
	/**
	 * Prepering response if limit was set and exceeded
	 *
	 * @return string $response String with html code to display alert
	 */
	private function prepareExceedLimitExpense( $exceedAmount ) {
		
		$response = '<div class="alert alert-danger">Spend amount: <strong>'.$this -> expenseAmount.' </strong>zł in category: <strong>'.$this -> expenseCategory.' </strong>will cause exceeding limit of: <strong>'.$exceedAmount.' </strong>zł.</div>';
		
		return $response;
		
	}
	
	/**
	 * Prepering response if limit was set and no exceed
	 *
	 * @return string $response String with html code to display alert
	 */
	private function prepareLimitExpense( $marginAmount, $spentAmount ) {
		
		$response = '<div class="alert alert-success">Your monthly limit in category: <strong>'.$this -> expenseCategory.' </strong>is set for: <strong>'.$this -> expenseLimit.' </strong>zł. You spent already: <strong>'.$spentAmount.' </strong>zł. If you will spend: <strong>'.$this -> expenseAmount.' </strong>zł you will still have: <strong>'.$marginAmount.' </strong>zł to spend in this month.</div>';
		
		return $response;
		
	}
	
}

?>