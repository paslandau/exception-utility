<?php
  namespace paslandau\ExceptionUtility\Exceptions;

/**
 * 
 * Enter description here ...
 * @author Hirnhamster
 *
 */
class ArgumentException extends \Exception{

	/**
	 * @param string $message
	 */
	public function __construct($message){
		parent::__construct($message,1000,null);
	}

}
?>