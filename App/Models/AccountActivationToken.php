<?php

namespace App\Models;

use PDO;

/**
 * Unique account activation tokens
 *
 * PHP version 7.4
 */
class AccountActivationToken extends Token 
{
	
	/**
	 * Find account activation token in DB users table
	 *
	 * @return custom object if found or false otherwise
	 */
	public function findTokenInDB() {
		
		$rememberedTokenHash = $this -> getHashedToken();
		
		$sql = "SELECT * FROM users WHERE activation_token_hash = :rememberedTokenHash";
		
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":rememberedTokenHash", $rememberedTokenHash, PDO::PARAM_STR );
		$stmt -> execute();
		 
		return $stmt -> fetch( PDO::FETCH_OBJ );
	}
	
	/**
	 * Deleting remembered login from DB
	 *
	 * @return void
	 */
	public function deleteTokenFromDB() {
		 
		$hashedToken = $this -> getHashedToken();
		
		$sql = "UPDATE users SET activation_token_hash = NULL WHERE activation_token_hash = :hashedToken";
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":hashedToken", $hashedToken, PDO::PARAM_STR );
		
		$stmt -> execute();
		
	}
	
}

?>