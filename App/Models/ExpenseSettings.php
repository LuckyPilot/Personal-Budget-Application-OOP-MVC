<?php

namespace App\Models;

use PDO;

/**
 * Managing expenses settings in application
 *
 * PHP version 7.4
 */
class ExpenseSettings extends CashFlowSettings
{
	
	public function __construct( $formData ) {

		parent::__construct( $formData );
		
		if (isset( $this -> newLimit ) && empty( $this -> newLimit )) {
			$this -> newLimit = NULL;
		}

	}
	 
	/**
	 * Adding expense category for user to DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function addExpenseCategory() {
		
		$validationErrors = $this -> validateExpenseCategoryInput();
		
		if (empty( $validationErrors )) {
			$sql = "INSERT INTO expenses_category_assigned_to_users VALUES(NULL, :userId, :newName, :newLimit)";
			 
			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
			$stmt -> bindValue( ":newName", $this -> newName, PDO::PARAM_STR );
			$stmt -> bindValue( ":newLimit", $this -> newLimit, PDO::PARAM_INT );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	 }
	 
	/**
	 * Modifying expense category name for user in DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function modifyExpenseCategoryName() {

		$validationErrors = $this -> validateExpenseCategoryInput();
		
		if (empty( $validationErrors )) {
			$sql = "UPDATE expenses_category_assigned_to_users SET name = :newName WHERE name = :currentName AND user_id = :userId";

			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":newName", $this -> newName, PDO::PARAM_STR );
			$stmt -> bindValue( ":currentName", $this -> categoryToModify, PDO::PARAM_STR );
			$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	 }
	 
	/**
	 * Modifying expense category limit for user in DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function modifyExpenseCategoryLimit() {

		$validationErrors = $this -> validateExpenseCategoryInput();
		
		if (empty( $validationErrors )) {
			$sql = "UPDATE expenses_category_assigned_to_users SET expense_limit = :newLimit WHERE name = :currentName AND user_id = :userId";

			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":newLimit", $this -> newLimit, PDO::PARAM_INT );
			$stmt -> bindValue( ":currentName", $this -> categoryToModify, PDO::PARAM_STR );
			$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	 }
	 
	/**
	 * Deleting expense category for user in DB
	 *
	 * @return true if success, false otherwise
	 */
	 public function deleteExpenseCategory() {
		 
		// First we are deleting all expenses with id of category to delete
		$categoryToDelete = Expense::findExpenseCategoryInDB( $this -> categoryToDelete );
		Expense::deleteExpensesByCategoryFromDB( $categoryToDelete -> id );
		
		// Than we are deleting category
		$sql = "DELETE FROM expenses_category_assigned_to_users WHERE name = :currentName AND user_id = :userId";

		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":currentName", $this -> categoryToDelete, PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		
		return $stmt -> execute();	
		
	 }
	 
	/**
	 * Adding payment method for user to DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function addPaymentMethod() {
		
		$validationErrors = $this -> validatePaymentMethodInput();
		
		if (empty( $validationErrors )) {
			$sql = "INSERT INTO payment_methods_assigned_to_users VALUES(NULL, :userId, :newName)";
			 
			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
			$stmt -> bindValue( ":newName", $this -> newName, PDO::PARAM_STR );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	 }
	 
	/**
	 * Modifying payment method for user in DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function modifyPaymentMethod() {

		$validationErrors = $this -> validatePaymentMethodInput();
		
		if (empty( $validationErrors )) {
			$sql = "UPDATE payment_methods_assigned_to_users SET name = :newName WHERE name = :currentName AND user_id = :userId";

			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":newName", $this -> newName, PDO::PARAM_STR );
			$stmt -> bindValue( ":currentName", $this -> methodToModify, PDO::PARAM_STR );
			$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	 }
	 
	/**
	 * Deleting payment method for user in DB
	 *
	 * @return true if success, false otherwise
	 */
	 public function deletePaymentMethod() {
		 
		// First we are deleting all expenses with id of category to delete
		$methodToDelete = Expense::findPaymentMethodInDB( $this -> methodToDelete );
		Expense::deleteExpensesByMethodFromDB( $methodToDelete -> id );
		
		// Than we are deleting category
		$sql = "DELETE FROM payment_methods_assigned_to_users WHERE name = :currentName AND user_id = :userId";

		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":currentName", $this -> methodToDelete, PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		
		return $stmt -> execute();	
		
	 }
	 
	/**
	 * Validating expense category inputs
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	 private function validateExpenseCategoryInput() {
		 
		$inputValidation = new CashFlowDataValidator();
		 
		if (isset( $this -> newName )) {
			$inputValidation -> validateName( $this -> newName );
			$inputValidation -> validateExpenseNameAvailability( $this -> newName );
		}
		
		if (isset( $this -> newLimit )) {
			$inputValidation -> validateLimit( $this -> newLimit );
		}
	 
		return $inputValidation -> validationErrors;
		
	 }
	 
	/**
	 * Validating payment method inputs
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	 private function validatePaymentMethodInput() {
		 
		 $inputValidation = new CashFlowDataValidator();
		 
		 $inputValidation -> validateName( $this -> newName );
		 $inputValidation -> validateMethodNameAvailability( $this -> newName );
		 
		 return $inputValidation -> validationErrors;
		 
	 }

}

?>