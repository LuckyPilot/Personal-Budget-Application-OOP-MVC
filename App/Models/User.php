<?php

namespace App\NewModels;

use PDO;

/**
 * Basic user class fetching all properties from DB based on id or email
 *
 * PHP version 7.0
 */
class User extends \Core\Model
{
	/**
	 * Properties
	 */
	 public ?int $id = NULL; 
	 public ?string $name = NULL;
	 public ?string $hashedPassword = NULL;
	 public ?string $email = NULL;
	 public bool $exist = false;
	 
	/**
	 * Class constructor
	 * Setting properties with current DB values
	 */
	 public function __construct( ?string $email = NULL, ?int $id = NULL ) {
		 
		 $dataFromDB = $this -> findUserInDB( $email, $id );
		 
		 if ($dataFromDB) {
			 
			 $this -> exist = true;
			 $this -> id = $dataFromDB -> id;
			 $this -> name = $dataFromDB -> username;
			 $this -> hashedPassword = $dataFromDB -> password;
			 $this -> email = $dataFromDB -> email;
			 
		 }
		 
	 }
	 
	/**
	 * Checking whether user already exists in DB or not
	 *
	 * @param string $email User Email
	 * @param int $id User ID
	 *
	 * @return custom object if user exist or false otherwise
	 */
	 private function findUserInDB( $email, $id ) {
		 
		 $sql = "SELECT * FROM users WHERE email = :userEmail OR id = :userId ";
		 
		 $db = static::getDB();
		 $stmt = $db -> prepare($sql);
		 $stmt -> bindValue( ":userEmail", $email, PDO::PARAM_STR ); 
		 $stmt -> bindValue( ":userId", $id, PDO::PARAM_INT ); 
		 
		 $stmt -> setFetchMode( PDO::FETCH_CLASS, get_called_class() );
		 
		 $stmt -> execute();
		 
		 return $stmt -> fetch();
		 
	}
	 
}

?>