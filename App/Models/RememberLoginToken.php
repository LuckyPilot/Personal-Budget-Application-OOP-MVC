<?php

namespace App\Models;

use PDO;

/**
 * Unique remember login tokens
 *
 * PHP version 7.4
 */
class RememberLoginToken extends Token 
{
	
	/**
	 * Adding automatic login token to remembered_logins table in DB
	 *
	 * @return true if login was remember successfully or false otherwise
	 */
	public function addHashedTokenToDB() {
		 
		$hashedToken = $this -> getHashedToken();
		 
		$sql = "INSERT INTO remembered_logins VALUES( :hashedToken, :userId, :expiryDate )";
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":hashedToken", $hashedToken, PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		$stmt -> bindValue( ":expiryDate", $this -> expiryDate , PDO::PARAM_STR );
		
		return $stmt -> execute();
		
	}
	
	/**
	 * Deleting remembered login from DB
	 *
	 * @return void
	 */
	public function deleteTokenFromDB() {
		 
		$hashedToken = $this -> getHashedToken();
		
		$sql = "DELETE FROM remembered_logins WHERE token_hash = :hashedToken OR user_id = :userId";
		 
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":hashedToken", $hashedToken, PDO::PARAM_STR );
		$stmt -> bindValue( ":userId", $_SESSION["userId"], PDO::PARAM_INT );
		
		$stmt -> execute();
		
	}
	
	/**
	 * Find user token in DB remembered_logins table
	 *
	 * @return custom object if found or false otherwise
	 */
	public function findTokenInDB() {
		
		$rememberedTokenHash = $this -> getHashedToken();
		
		$sql = "SELECT * FROM remembered_logins WHERE token_hash = :rememberedTokenHash";
		
		$db = static::getDB();
		
		$stmt = $db -> prepare( $sql );
		$stmt -> bindValue( ":rememberedTokenHash", $rememberedTokenHash, PDO::PARAM_STR );
		$stmt -> execute();
		 
		return $stmt -> fetch( PDO::FETCH_OBJ );
	}
	
}

?>