<?php

namespace App\Models;

use PDO;

/**
 * Sign up new user to application
 *
 * PHP version 7.4
 */
class AccountRegistration extends \Core\Model
{
	/**
	 * Properties
	 * Values sent by user during registration process 
	 */
	 private $name = NULL;
	 private $email = NULL;
	 private $password = NULL;
	 private $passwordConfirmation = NULL;
	 private $terms = NULL;
	 private $reCaptcha = NULL;
	 
	 /**
	 * Class constructor
	 *
	 * @param array $data Initial property values
	 *
	 * @return void
	 */
	public function __construct( $data = [] ) {
		
		foreach ($data as $key => $value) {
			if ($key == "g-recaptcha-response") {
				$this -> reCaptcha = $value;
			} else {
				$this -> $key = $value;
			}			
		}
		
	}
	
	/**
	 * Adding new user
	 *
	 * @return true if new user was registered or array with errors otherwise
	 */
	public function registerNewUser() {
		
		$validationErrors = $this -> validateUserInputs();
		
		if (empty( $validationErrors )) {
			
			$activationToken = new AccountActivationToken();
		
			$db = static::getDB();
			$this -> addNewUserToDB( $db, $activationToken -> getHashedToken() );
			$this -> setInitialDataForNewUserInDB( $db );
			
			$accountActivation = new AccountActivation( $activationToken -> value );
			$accountActivation -> sendActivationEmail( $this -> email );
				
			return true;
		}
		
		return $validationErrors;
	
	}
	
	/**
	 * Validating property values
	 *
	 * @return array $inputValidation Errors messages during validation process
	 */
	 private function validateUserInputs() {
		 
		$inputValidation = new UserDataValidator();
		
		$inputValidation -> validateName( $this -> name );
		$inputValidation -> validateEmailFormat( $this -> email );
		$inputValidation -> validateEmailAvailability( $this -> email );
		$inputValidation -> validatePassword( $this -> password, $this -> passwordConfirmation );
		$inputValidation -> validateTerms( $this -> terms );
		$inputValidation -> validateCaptcha( $this -> reCaptcha );
		
		return $inputValidation -> validationErrors;
	
	}
	 
	/**
	 * Adding new user credentials to DB
	 *
	 * @param object $db Connection with database
	 * @param string $activationTokenHash Hashed value of activation token
	 *
	 * @return true if saving new user credentials to DB success or false otherwise
	 */
	 private function addNewUserToDB( &$db, $activationTokenHash ) {
		
		$passwordHash = password_hash( $this -> password, PASSWORD_DEFAULT );
		
		$sql = "INSERT INTO users ( username, email, password, activation_token_hash ) VALUES( :name, :email , :passwordHash, :activationTokenHash)";
		
		$stmt = $db -> prepare($sql);
		
		$stmt -> bindValue( ":name", $this -> name, PDO::PARAM_STR );
		$stmt -> bindValue( ":email", $this -> email, PDO::PARAM_STR );
		$stmt -> bindValue( ":passwordHash", $passwordHash, PDO::PARAM_STR );
		$stmt -> bindValue( ":activationTokenHash", $activationTokenHash, PDO::PARAM_STR );
		
		return $stmt -> execute();
	}
	 
	 /**
	 * Adding initial data for user to DB
	 *
	 * @param object $db Connection with database
	 *
	 * @return void
	 */
	private function setInitialDataForNewUserInDB( &$db ) {
		
		$user = new User( $this -> email );
		
		$this -> addIncomesCategoriesForNewUserToDB( $db, $user -> id );
		$this -> addExpensesCategoriesForNewUserToDB( $db, $user -> id );
		$this -> addPaymentMethodsForNewUserToDB( $db, $user -> id );
		
	}
	
	/**
	 * Adding incomes categories names for new user to DB
	 *
	 * @param object $db Connection with database
	 * @param int $userId Registered user Id
	 *
	 * @return void
	 */
	private function addIncomesCategoriesForNewUserToDB( &$db, $userId ) {
		
		$query = $db -> query( "SELECT name FROM incomes_category_default" );
		
		while ($defaultIncomeCategories = $query -> fetch( PDO::FETCH_ASSOC )) {
			
			$db -> query( "INSERT INTO incomes_category_assigned_to_users VALUES (NULL, '$userId', '".$defaultIncomeCategories['name']."')" );
			
		}
		
	}
	
	/**
	 * Adding expenses categories names for new user to DB
	 *
	 * @param object $db Connection with database
	 * @param int $userId Registered user Id
	 *
	 * @return void
	 */
	private function addExpensesCategoriesForNewUserToDB( &$db, $userId ) {
		
		$query = $db -> query( "SELECT name FROM expenses_category_default" );
		
		while ($defaultExpenseCategories = $query -> fetch( PDO::FETCH_ASSOC )) {
			
			$db -> query( "INSERT INTO expenses_category_assigned_to_users VALUES (NULL, '$userId', '".$defaultExpenseCategories['name']."')" );
			
		}
		
	}
	
	/**
	 * Adding payment methods names for new user to DB
	 *
	 * @param object $db Connection with database
	 * @param int $userId Registered user Id
	 *
	 * @return void
	 */
	private function addPaymentMethodsForNewUserToDB( &$db, $userId ) {
		
		$query = $db -> query( "SELECT name FROM payment_methods_default" );
		
		while ($defaultPaymentMethods = $query -> fetch( PDO::FETCH_ASSOC )) {
			
			$db -> query( "INSERT INTO payment_methods_assigned_to_users VALUES (NULL, '$userId', '".$defaultPaymentMethods['name']."')" );
			
		}
		
	}
}

?>