<?php

namespace App\Models;

/**
 * Validate user inputs
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