<?php

namespace App\Models;

/**
 * General cash flow settings in application
 *
 * PHP version 7.4
 */
abstract class CashFlowSettings extends \Core\Model
{
	 
	/**
	 * Class constructor
	 * Setting initial class properties depends from form data sent by user.
	 *
	 * @param string $formData User inputs 
	 *
	 * @return void
	 */
	 public function __construct( $formData ) {
		 
		 foreach ($formData as $key => $data) {
			 if ($key == "newName") {
				 $this -> $key = ucfirst( strtolower( $data ));
			 } else {
				 $this -> $key = $data;
			 }
		 }
		 
	 }
	
}

?>