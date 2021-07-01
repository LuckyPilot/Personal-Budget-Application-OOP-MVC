<?php

namespace App\Models;

use PDO;
	 
/**
 * Incomes manager
 *
 * PHP version 7.4
 */
class Income extends CashFlow
{
	
	/**
	 * Properties
	 * Array with errors from user input  validation process
	 */
	 public $inputValidationErrors = [];
	 
	/**
	 * Adding new income do DB
	 *
	 * @return true if new income was added or Income object otherwise
	 */
	public function addIncome(){
		
		$this -> inputValidationErrors = $this -> validateIncomeInputs();
		
		if (empty( $this -> inputValidationErrors )) {
			if ($this -> addIncomeToDB()) {
				return true;
			}
		}
		
		return $this;
		
	}
	
	/**
	 * Fetchinn user's incomes from given period from DB
	 *
	 * @param string $begDate Date which begins period
	 * @param string $endDate Date which ends period
	 *
	 * @return array 
	 */
	public function fetchIncomesFromDB( $begDate, $endDate ) {
		
		$sql ="SELECT incomes_category.name,  SUM(incomes.amount) AS sum FROM incomes INNER JOIN incomes_category_assigned_to_users AS incomes_category ON incomes.income_category_assigned_to_user_id = incomes_category.id WHERE incomes.user_id = :userId AND incomes.date_of_income BETWEEN :begDate AND :endDate GROUP BY incomes_category.name ORDER BY SUM(incomes.amount) DESC";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":begDate", $begDate, PDO::PARAM_STR );
		$stmt -> bindValue( ":endDate", $endDate, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetchAll( PDO::FETCH_ASSOC );
	}
	
	/**
	 * Validating property values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateIncomeInputs() {
		
		$inputValidation = new CashFlowDataValidator();
		
		$inputValidation -> validateAmount( $this -> amount ) ;
		$inputValidation -> validateDate( $this -> date );
		$inputValidation -> validateCategory( $this -> category );
		
		return $inputValidation -> validationErrors;
		
	}
	
	/**
	 * Adding new income to DB
	 *
	 * @return true if saving new income to DB success or false otherwise
	 */
	private function addIncomeToDB() {
		
		$sql = "INSERT INTO incomes VALUES( NULL, :userId, :catId, :amount, :date, :comment )";
		
		$catId = $this -> findIncomeCategoryId();
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":catId", $catId -> id, PDO::PARAM_INT );
		$stmt -> bindValue( ":amount", $this -> amount, PDO::PARAM_STR );
		$stmt -> bindValue( ":date", $this -> date, PDO::PARAM_STR );
		$stmt -> bindValue( ":comment", $this -> comment, PDO::PARAM_STR );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Finding income category id from incomes_category_assigned_to_users table in DB
	 *
	 * @return custom object if found or false otherwise
	 */
	private function findIncomeCategoryId() {
		
		$sql = "SELECT id FROM  incomes_category_assigned_to_users WHERE user_id = :userId AND name = :catName";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":catName", $this -> category, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetch( PDO::FETCH_OBJ );
		
	}
	
}

?>