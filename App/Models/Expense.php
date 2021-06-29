<?php

namespace App\Models;

use PDO;

class Expense extends CashFlow
{
	
	/**
	 * Adding new expense do DB
	 *
	 * @return true if new expense was added or array with errors otherwise
	 */
	public function addExpense(){
		
		$validationErrors = $this -> validateExpenseInputs();
		
		if (empty( $validationErrors )) {
			if ($this -> addExpenseToDB()) {
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
	private function validateExpenseInputs() {
		
		$inputValidation = new CashFlowDataValidator();
		
		$inputValidation -> validateAmount( $this -> amount ) ;
		$inputValidation -> validateDate( $this -> date );
		$inputValidation -> validateCategory( $this -> category );
		$inputValidation -> validateMethod( $this -> method );
		
		return $inputValidation -> validationErrors;
		
	}
	
	/**
	 * Adding new expense to DB
	 *
	 * @return true if saving new expense to DB success or false otherwise
	 */
	private function addExpenseToDB() {
		
		$sql = "INSERT INTO expenses VALUES( NULL, :userId, :catId, :payId, :amount, :date, :comment )";
		
		$catId = $this -> findExpenseCategoryId();
		$payId = $this -> findPaymentMethodId();
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_STR );
		$stmt -> bindValue( ":catId", $catId -> id, PDO::PARAM_STR );
		$stmt -> bindValue( ":payId", $payId -> id, PDO::PARAM_STR );
		$stmt -> bindValue( ":amount", $this -> amount, PDO::PARAM_STR );
		$stmt -> bindValue( ":date", $this -> date, PDO::PARAM_STR );
		$stmt -> bindValue( ":comment", $this -> comment, PDO::PARAM_STR );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Finding expense category id from expenses_category_assigned_to_users table in DB
	 *
	 * @return custom object if found or false otherwise
	 */
	private function findExpenseCategoryId() {
		
		$sql = "SELECT id FROM  expenses_category_assigned_to_users WHERE user_id = :userId AND name = :catName";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_STR );
		$stmt -> bindValue( ":catName", $this -> category, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetch( PDO::FETCH_OBJ );
		
	}
	
	/**
	 * Finding payment method id from payment_methods_assigned_to_users table in DB
	 *
	 * @return custom object if found or false otherwise
	 */
	private function findPaymentMethodId() {
		
		$sql = "SELECT id FROM  payment_methods_assigned_to_users WHERE user_id = :userId AND name = :catName";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_STR );
		$stmt -> bindValue( ":catName", $this -> method, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetch( PDO::FETCH_OBJ );
		
	}
	
}




?>