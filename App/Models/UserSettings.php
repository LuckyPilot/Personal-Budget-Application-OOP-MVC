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
	 * Validating password reset form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	private function validateUserPasswordInput() {
		 
		$inputValidation = new UserDataValidator();
		 
		$inputValidation -> validatePassword( $this -> newSettingValue["newPassword"], $this -> newSettingValue["newPasswordConfirmation"] );
		 
		return $inputValidation -> validationErrors;
	}
	
	/**
	 * Validating request password reset form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	/*private function validateUserEmailInput() {
		 
		$inputValidation = new DataValidator();
		 
		$inputValidation -> validateEmailFormat( $this -> requestResetEmail );
		$inputValidation -> validateCaptcha( $this -> reCaptcha );
		 
		return $inputValidation -> validationErrors;
	}*/
	
}

?>