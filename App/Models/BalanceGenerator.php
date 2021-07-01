<?php

namespace App\Models;

/**
 * Generating new finance balance
 *
 * PHP version 7.4
 */
class BalanceGenerator 
{
	
	/**
	 * Properties
	 * 
	 */
	 public $begDate;
	 public $endDate;
	 public $incomes = [];
	 public $expenses = [];
	 public $userInputsValidationErrors = [];
	 
	/**
	 * Class constructor
	 * Constructor automatically changes user inputs string period to date format.
	 *
	 * @param string $data Data contains balance period inserted by user  
	 *
	 * @return void
	 */
	 public function __construct( $data ) {
		 
		 switch( $data["period"] ) {
			case "currentMonth":
			$this -> begDate = date( "Y-m-01" );
			$this -> endDate = date( "Y-m-t" );
			break;
			case "previousMonth":
			$previousMonth = strtotime( "last Month" );
			$this -> begDate = date( "Y-m-01", $previousMonth );
			$this -> endDate = date( "Y-m-t", $previousMonth );
			break;
			case "currentYear":
			$this -> begDate = date( "Y-01-01" );
			$this -> endDate = date( "Y-12-31" );
			break;
			default:
			$this -> begDate = $data["begDate"];
			$this -> endDate = $data["endDate"];
		}
		  
	 }
	 
	 /**
	 * Generating new financial balance for user
	 *
	 * @return BalanceGenerator object 
	 */
	 public function generateNewBalance() {
		  
		  $this -> userInputsValidationErrors = $this -> validateDateInputs();
		  
		  if (empty( $this -> userInputsValidationErrors )) {
			  $userIncomes = new Income();
			  $this -> incomes = $userIncomes -> fetchIncomesFromDB( $this -> begDate, $this -> endDate );
			  
			  $userExpenses = new Expense();
			  $this -> expenses = $userExpenses -> fetchExpensesFromDB( $this -> begDate, $this -> endDate );
		  }
		  
		  return $this;
	
	 }
	 
	 /**
	 * Validating user dates inputs
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	 private function validateDateInputs() {
		 
		$inputsValidation = new CashFlowDataValidator();
		$inputsValidation -> validateDate( $this -> begDate );
		$inputsValidation -> validateDate( $this -> endDate );

		return $inputsValidation -> validationErrors;
		
	 }
	
}

?>