<?php

namespace App\Models;

/**
 * Validate cashflow inputs
 *
 * PHP version 7.4
 */
class CashFlowDataValidator
{
	
	/**
	 * Properties
	 * Array of errors set druing validation process
	 */
	public $validationErrors = [];
	
	/**
	 * Checking whether amount is valid decimal number. If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateAmount( $amount ) {
		
		 if (empty( $amount )) {
			 $this -> validationErrors['invalidAmount'] = "Amount is required";
		 } elseif (!filter_var( $amount, FILTER_VALIDATE_FLOAT )) {
			 $this -> validationErrors['invalidAmount'] = "Amount has to be decimal number!";
		 }
		 
	}
	
	/**
	 * Checking whether limit is valid integer number and ha positive value. If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateLimit( $amount ) {
		
		 if ($amount < 0) {
			$this -> validationErrors['invalidAmount'] = "Limit has to be positive integer number!";
		 }  elseif (!filter_var( $amount, FILTER_VALIDATE_INT )) {
			$this -> validationErrors['invalidAmount'] = "Amount has to be integer number!";
		 }
		 
	}
	
	/**
	 * Checking whether date is valid date format. If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateDate( $date ) {

		 if (!strtotime( $date )) {
			 $this -> validationErrors['invalidDate'] = "Date has to have valid date format! (YYYY-MM-DD)";
		 } elseif ($date == "") {
			 $this -> validationErrors['invalidDate'] = "Date is required!";
		 }
		 
	}
	
	/**
	 * Checking whether cashflow category was chose . If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateCategory( $category ) {
		
		 if ($category == NULL) {
			 $this -> validationErrors['invalidCategory'] = "Please choose category!";
		 } 
		 
	}
	
	/**
	 * Checking whether name for cashflow category is correct . If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateName( $categoryName ) {
		
		 if (strlen( $categoryName ) == 0) {
			 $this -> validationErrors['invalidName'] = "Category name is required!";
		 } 
		 
	}
	
	/**
	 * Checking whether name for income category is not already in DB . If is, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateIncomeNameAvailability( $categoryName ) {
		
		$checkAvailability = Income::findIncomeCategoryInDB( $categoryName );
		
		if ($checkAvailability) {
			$this -> validationErrors['invalidName'] = "You have already that category!";
		}
		
	}
	
	/**
	 * Checking whether name for expense category is not already in DB . If is, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateExpenseNameAvailability( $categoryName ) {
		
		$checkAvailability = Expense::findExpenseCategoryInDB( $categoryName );
		
		if ($checkAvailability) {
			$this -> validationErrors['invalidName'] = "You have already that category!";
		}
		
	}
	
	/**
	 * Checking whether name for payment method is not already in DB . If is, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateMethodNameAvailability( $categoryName ) {
		
		$checkAvailability = Expense::findPaymentMethodInDB( $categoryName );
		
		if ($checkAvailability) {
			$this -> validationErrors['invalidName'] = "You have already that method!";
		}
		
	}
	
	/**
	 * Checking whether payment method was chose . If not, set info to validationErrors array
	 * 
	 * @return void
	 */
	public function validateMethod( $method ) {
		
		 if ($method == NULL) {
			 $this -> validationErrors['invalidMethod'] = "Please choose method!";
		 } 
		 
	}
		 
}

?>