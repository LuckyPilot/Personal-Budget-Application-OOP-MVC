<?php

namespace App\Models;

use PDO;

/**
 * Managing incomes settings in application
 *
 * PHP version 7.4
 */
class IncomeSettings extends CashFlowSettings
{
	
	/**
	 * Adding income category for user to DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function addIncomeCategory() {

		$validationErrors = $this -> validateIncomeCategoryInput();
		
		if (empty( $validationErrors )) {
			$sql = "INSERT INTO incomes_category_assigned_to_users VALUES(NULL, :userId, :newName)";
			 
			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
			$stmt -> bindValue( ":newName", $this -> newName, PDO::PARAM_STR );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	 }
	 
	/**
	 * Modifying income category for user in DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function modifyIncomeCategory() {

		$validationErrors = $this -> validateIncomeCategoryInput();
		
		if (empty( $validationErrors )) {
			$sql = "UPDATE incomes_category_assigned_to_users SET name = :newName WHERE name = :currentName AND user_id = :userId";

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
	 * Deleting income category for user in DB
	 *
	 * @return true if success, false otherwise
	 */
	 public function deleteIncomeCategory() {
		 
		 // First we are deleting all incomes with id of category to delete
		$categoryToDelete = Income::findIncomeCategoryInDB $this -> categoryToDelete );
		Income::deleteIncomesFromDB( $categoryToDelete -> id );
		
		// Than we are deleting category
		$sql = "DELETE FROM incomes_category_assigned_to_users WHERE name = :currentName AND user_id = :userId";

		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":currentName", $this -> categoryToDelete, PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		
		return $stmt -> execute();	
		
	 }
	
	/**
	 * Validating income category inputs
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	 private function validateIncomeCategoryInput() {
		 
		$inputValidation = new CashFlowDataValidator();
		 
		$inputValidation -> validateCategoryName( $this -> newName );
		$inputValidation -> validateIncomeNameAvailability( $this -> newName );
	 
		return $inputValidation -> validationErrors;
		
	 }

}

?>