<?php

namespace App\Models;

use PDO;

/**
 * Managing cash flow settings in application
 *
 * PHP version 7.4
 */
class CashFlowSettings extends \Core\Model
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
	 * Adding income category for user to DB
	 *
	 * @return array $validationErrors Errors messages during validation process or true if name successfully changed
	 */
	
	
	/**
	 * Validating name change form values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */

	
}

?>