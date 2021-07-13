<?php

namespace App\Models;

use PDO;

/**
 * Expenses manager
 *
 * PHP version 7.4
 */
class Expense extends CashFlow
{
	
	/**
	 * Properties
	 * Array with errors from user input  validation process
	 */
	 public $inputValidationErrors = [];
	 
	/**
	 * Adding new expense to DB
	 *
	 * @return true if new expense was added or Expense object otherwise
	 */
	public function addExpense(){
		
		$this -> inputValidationErrors = $this -> validateExpenseInputs();
		
		if (empty( $this -> inputValidationErrors )) {
			if ($this -> addExpenseToDB()) {
				return true;
			}
		}
		
		return $this;
		
	}
	
	/**
	 * Fetching user's expenses from given period from DB
	 *
	 * @param string $begDate Date which begins period
	 * @param string $endDate Date which ends period
	 *
	 * @return array 
	 */
	public function fetchAllExpensesFromDB( $begDate, $endDate ) {
		
		$sql ="SELECT expense_category.name,  SUM(expenses.amount) AS sum FROM expenses INNER JOIN expenses_category_assigned_to_users AS expense_category ON expenses.expense_category_assigned_to_user_id = expense_category.id WHERE expenses.user_id = :userId AND expenses.date_of_expense BETWEEN :begDate AND :endDate GROUP BY expense_category.name ORDER BY SUM(expenses.amount) DESC";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":begDate", $begDate, PDO::PARAM_STR );
		$stmt -> bindValue( ":endDate", $endDate, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetchAll( PDO::FETCH_ASSOC );
	}
	
	/**
	 * Fetching user's expenses from current month and given category from DB
	 *
	 * @param string $catId Id of expense category to fetch
	 *
	 * @return array 
	 */
	public static function fetchExpensesByCategoryFromDB( $userCatId ) {
		
		$sql ="SELECT SUM(expenses.amount) AS sum FROM expenses WHERE expense_category_assigned_to_user_id = :catId AND expenses.date_of_expense BETWEEN :begDate AND :endDate GROUP BY expenses.expense_category_assigned_to_user_id";
		
		$begDate = date( "Y-m-01" );
		$endDate = date( "Y-m-t" );
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":catId", $userCatId, PDO::PARAM_INT );
		$stmt -> bindValue( ":begDate", $begDate, PDO::PARAM_STR );
		$stmt -> bindValue( ":endDate", $endDate, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetch( PDO::FETCH_ASSOC );
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
		
		$catId = $this -> findExpenseCategoryInDB( $this -> category );
		$payId = $this -> findPaymentMethodInDB();
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":catId", $catId -> id, PDO::PARAM_INT );
		$stmt -> bindValue( ":payId", $payId -> id, PDO::PARAM_INT );
		$stmt -> bindValue( ":amount", $this -> amount, PDO::PARAM_STR );
		$stmt -> bindValue( ":date", $this -> date, PDO::PARAM_STR );
		$stmt -> bindValue( ":comment", $this -> comment, PDO::PARAM_STR );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Deleting user expenses from expenses table in DB
	 *
	 * @return true if success, false otherwise
	 */
	public static function deleteExpensesFromDB( $categoryId ) {
		
		$sql = "DELETE FROM expenses WHERE expense_category_assigned_to_user_id = :categoryToDeleteId";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":categoryToDeleteId", $categoryId, PDO::PARAM_INT );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Finding expense category id from expenses_category_assigned_to_users table in DB
	 *
	 * @return custom object if found or false otherwise
	 */
	public static function findExpenseCategoryInDB( $categoryName ) {
		
		$sql = "SELECT * FROM  expenses_category_assigned_to_users WHERE user_id = :userId AND name = :catName";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":catName", $categoryName, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetch( PDO::FETCH_OBJ );
		
	}
	
	/**
	 * Finding payment method id from payment_methods_assigned_to_users table in DB
	 *
	 * @return custom object if found or false otherwise
	 */
	private function findPaymentMethodInDB() {
		
		$sql = "SELECT * FROM  payment_methods_assigned_to_users WHERE user_id = :userId AND name = :catName";
		
		$db = static::getDB();
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":catName", $this -> method, PDO::PARAM_STR );
		
		$stmt -> execute();
		
		return $stmt -> fetch( PDO::FETCH_OBJ );
		
	}
	
}




?>