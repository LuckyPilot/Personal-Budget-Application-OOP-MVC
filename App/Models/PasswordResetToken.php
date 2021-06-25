<?php

namespace App\Models;

use PDO;

/**
 * Unique password reset tokens
 *
 * PHP version 7.4
 */
class PasswordResetToken extends \App\Token 
{
	
	/**
	 * Adding user token to reset_passwords table in DB
	 *
	 * @return true if login was remember successfully or false otherwise
	 */
	public function addHashedTokenToDB( $userId ) {
		 
		$hashedToken = $this -> getHashedToken();
		 
		$sql = "INSERT INTO reset_passwords VALUES( :hashedToken, :userId, :expiryDate )";
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":hashedToken", $hashedToken, PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $userId, PDO::PARAM_INT );
		$stmt -> bindValue( ":expiryDate", $this -> expiryDate , PDO::PARAM_STR );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Deleting remembered login from DB
	 *
	 * @return void
	 */
	public function deleteTokenFromDB( $userID = NULL ) {
		 
		$hashedToken = $this -> getHashedToken();
		
		$sql = "DELETE FROM reset_passwords WHERE token_hash = :hashedToken OR user_id = :userId";
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":hashedToken", $hashedToken, PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $userID, PDO::PARAM_INT );
		
		$stmt -> execute();
		
	}
	
	/**
	 * Find user token in DB reset_passwords table
	 *
	 * @param string $token Token value
	 *
	 * @return custom object if found or false otherwise
	 */
	public function findTokenInDB() {
		
		$passwordResetTokenHash = $this -> getHashedToken();
		
		$sql = "SELECT * FROM reset_passwords WHERE token_hash = :passwordResetTokenHash";
		
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":passwordResetTokenHash", $passwordResetTokenHash, PDO::PARAM_STR );
		$stmt -> execute();
		 
		return $stmt -> fetch( PDO::FETCH_OBJ );
	}
	
}

?>