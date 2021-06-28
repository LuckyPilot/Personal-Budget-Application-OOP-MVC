<?php

namespace App\Models;

use PDO;

/**
 * Unique password reset tokens
 *
 * PHP version 7.4
 */
class PasswordResetToken extends Token 
{
	
	/**
	 * Adding password reset token to users table in DB
	 *
	 * @return true if login was remember successfully or false otherwise
	 */
	public function addHashedTokenToDB( $userId ) {
		 
		$hashedToken = $this -> getHashedToken();
		 
		$sql = "UPDATE users SET password_token_hash = :hashedToken, password_token_expiry = :expiryDate WHERE id = :userId";
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":hashedToken", $hashedToken, PDO::PARAM_STR );
		$stmt -> bindValue( ":expiryDate", $this -> expiryDate , PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $userId, PDO::PARAM_INT );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Deleting pasword reset token from DB 
	 *
	 * @return void
	 */
	public function deleteTokenFromDB() {
		 
		$hashedToken = $this -> getHashedToken();
		
		$sql = "UPDATE users SET password_token_hash = NULL, password_token_expiry = NULL WHERE password_token_hash = :hashedToken";
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":hashedToken", $hashedToken, PDO::PARAM_STR );
		
		$stmt -> execute();
		
	}
	
	/**
	 * Find user token in DB users table
	 *
	 * @return custom object if found or false otherwise
	 */
	public function findTokenInDB() {
		
		$passwordResetTokenHash = $this -> getHashedToken();
		
		$sql = "SELECT id, password_token_expiry FROM users WHERE password_token_hash = :passwordResetTokenHash";
		
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":passwordResetTokenHash", $passwordResetTokenHash, PDO::PARAM_STR );
		$stmt -> execute();
		 
		return $stmt -> fetch( PDO::FETCH_OBJ );
	}
	
}

?>