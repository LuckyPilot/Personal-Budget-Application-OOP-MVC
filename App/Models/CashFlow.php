<?php

namespace App\Models;

abstract class CashFlow extends \Core\Model
{
	
	/**
	 * Properties
	 * Values sent by user during adding income/expense process 
	 */
	public ?float $amount = NULL;
	public ?string $date = NULL;
	public ?string $category = NULL;
	public ?string $method = NULL;
	public ?string $comment = NULL;
	
	 /**
	 * Class constructor
	 *
	 * @param array $data Initial property values
	 *
	 * @return void
	 */
	public function __construct( $data = [] ) {
		foreach($data as $key => $value){
			$this -> $key = $value; 
		}
	}
	
}




?>