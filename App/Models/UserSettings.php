<?php

namespace App\Models;

use PDO;

/**
 * Managing user settings in application
 *
 * PHP version 7.4
 */
class UserSettings extends \Core\Model
{
	
	/**
	 * Properties
	 * Value of setting to change (in casse of password array) and user ID
	 */
	 private $userId = NULL;
	 private $newSettingValue = NULL;
	 
	 /**
	 * Class constructor
	 *
	 * @param string $newSettingValue Setting to change
	 * @param int $userId User Id to which changes should be made
	 *
	 * @return void
	 */
	 public function __construct( $newSettingValue, $userId = NULL ) {
		 
		$this -> newSettingValue = $newSettingValue;
		
		if ($userId == NULL) {
			$this -> userId = $_SESSION["userId"];
		} else {
			$this -> userId = $userId;
		}
		 
	 }
	
	/**
	 * Changing user name in DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	 public function changeUserName() {
		 
		$validationErrors = $this -> validateUserNameInput();
		
		if (empty( $validationErrors )) {
			$sql = "UPDATE users SET username = :newName WHERE id = :userId ";
			 
			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":newName", $this -> newSettingValue["newName"], PDO::PARAM_STR );
			$stmt -> bindValue( ":userId", $this -> userId, PDO::PARAM_INT );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	 }
	 
	/**
	 * Changing user password in DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if password successfully changed
	 */
	public function changeUserPassword() {
	
		$validationErrors = $this -> validateUserPasswordInput();
		
		if (empty( $validationErrors )) {
			$sql = "UPDATE users SET password = :newPassword WHERE id = :userId ";
			$passwordHash = password_hash( $this -> newSettingValue["newPassword"], PASSWORD_DEFAULT );
			 
			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":newPassword", $passwordHash , PDO::PARAM_STR );
			$stmt -> bindValue( ":userId", $this -> userId, PDO::PARAM_INT );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	}
	
	/**
	 * Changing user email in DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if email successfully changed
	 */
	public function changeUserEmail() {
		
		$validationErrors = $this -> validateUserEmailInput();
		
		if (empty( $validationErrors )) {
			$sql = "UPDATE users SET email = :newEmail WHERE id = :userId ";
			 
			$db = static::getDB();
			
			$stmt = $db -> prepare( $sql );
			$stmt -> bindValue( ":newEmail", $this -> newSettingValue["newEmail"] , PDO::PARAM_STR );
			$stmt -> bindValue( ":userId", $this -> userId, PDO::PARAM_INT );
			
			return $stmt -> execute();	
		}
		
		return $validationErrors;
		
	}
	
	/**
	 * Validating name change form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateUserNameInput() {
		
		$inputValidation = new UserDataValidator();
		 
		$inputValidation -> validateName( $this -> newSettingValue["newName"] );
		 
		return $inputValidation -> validationErrors;
		
	}
	
	/**
	 * Validating password change form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateUserPasswordInput() {
		 
		$inputValidation = new UserDataValidator();
		 
		$inputValidation -> validatePassword( $this -> newSettingValue["newPassword"], $this -> newSettingValue["newPasswordConfirmation"] );
		 
		return $inputValidation -> validationErrors;
	}
	
	/**
	 * Validating email change form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateUserEmailInput() {
		 
		$inputValidation = new UserDataValidator();
		 
		$inputValidation -> validateEmailFormat( $this -> newSettingValue["newEmail"] );
		$inputValidation -> validateEmailAvailability( $this -> newSettingValue["newEmail"] );
		 
		return $inputValidation -> validationErrors;
	}
	
}

?>