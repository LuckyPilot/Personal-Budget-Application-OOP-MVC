<?php

namespace App\Models;

use PDO;

class Income extends CashFlow
{
	
	/**
	 * Adding new income do DB
	 *
	 * @return true if new income was added or array with errors otherwise
	 */
	public function addIncome(){
		
		$validationErrors = $this -> validateIncomeInputs();
		
		if (empty( $validationErrors )) {
			if ($this -> addIncomeToDB()) {
				return true;
			}
		}
		
		return $validationErrors;
		
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
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_STR );
		$stmt -> bindValue( ":catId", $catId -> id, PDO::PARAM_STR );
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
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_STR );
		$stmt -> bindValue( ":catName", $this -> category, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetch( PDO::FETCH_OBJ );
		
	}
	
}

?>