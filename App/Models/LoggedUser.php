<?php

namespace App\Models;

use PDO;

/**
 * Logged user class fetching additionally initial user data from DB
 *
 * PHP version 7.4
 */
class LoggedUser extends User
{
	
	/**
	 * Properties
	 * User related data fetched from DB
	 */
	 public $incomesCategory = [];
	 public $expensesCategory = [];
	 public $paymentMethods = [];
	 
	/**
	 * Setting initial data to users arrays in DB from defaults array in DB for registered user
	 *
	 * @param object $db Connection with database
	 * @param string $registeredUserEmail Email of registered user
	 *
	 * @return void
	 */
	public function __construct( ?int $userId = NULL ) {
		
		parent::__construct( NULL, $userId );
		$this -> fetchIncomesCategory( $userId );
		$this -> fetchExpensesCategory( $userId );
		$this -> fetchPaymentMethods( $userId );
		
	}
	 
	/**
	 * Fetching incomes categories from DB for logged in user and save them in incomesCategory array
	 *
	 * @param int $userId id of logged in user
	 *
	 * @return void
	 */
	 private function fetchIncomesCategory( $userId ) {
		 
		 $sql = "SELECT name FROM incomes_category_assigned_to_users WHERE user_id= :userId";
		 
		 $db = static::getDB();
		 $stmt = $db -> prepare($sql);
		 $stmt -> bindValue( ":userId", $userId, PDO::PARAM_INT );
		 $stmt -> execute();
		 
		 $this -> incomesCategory = $stmt -> fetchAll( PDO::FETCH_ASSOC );
	}
	 
	/**
	 * Fetching expenses categories from DB for logged in user and save them in expensesCategory array
	 *
	 * @param int $userId id of logged in user
	 *
	 * @return void
	 */
	 private function fetchExpensesCategory( $userId ) {
		 
		 $sql = "SELECT name FROM expenses_category_assigned_to_users WHERE user_id= :userId";
		 
		 $db = static::getDB();
		 $stmt = $db -> prepare($sql);
		 $stmt -> bindValue( ":userId", $userId, PDO::PARAM_INT );
		 $stmt -> execute();
		 
		 $this -> expensesCategory = $stmt -> fetchAll( PDO::FETCH_ASSOC );
	}
	 
	/**
	 * Fetching payment methods from DB for logged in user and save them in paymentMethods array
	 *
	 * @param int $userId id of logged in user
	 *
	 * @return void
	 */
	 private function fetchPaymentMethods( $userId ) {
		 
		 $sql = "SELECT name FROM payment_methods_assigned_to_users WHERE user_id= :userId";
		 
		 $db = static::getDB();
		 $stmt = $db -> prepare($sql);
		 $stmt -> bindValue( ":userId", $userId, PDO::PARAM_INT );
		 $stmt -> execute();
		 
		 $this -> paymentMethods = $stmt -> fetchAll( PDO::FETCH_ASSOC );
	}
	 
}

?>