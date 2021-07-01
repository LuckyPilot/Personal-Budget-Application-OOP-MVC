<?php

namespace App\Models;

abstract class CashFlow extends \Core\Model
{
	
	/**
	 * Properties
	 * Values sent by user during adding income/expense process 
	 */
	public $amount = NULL;
	public $date = NULL;
	public $method = NULL;
	public $category = NULL;
	public $comment = NULL;
	
	 /**
	 * Class constructor
	 *
	 * @param array $data Initial property values
	 *
	 * @return void
	 */
	public function __construct( $data=[] ) {
		
		foreach ($data as $key => $value) {
			$this -> $key = $value;	
		}
		
	}
	
}




?>