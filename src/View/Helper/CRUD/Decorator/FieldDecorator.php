<?php
namespace App\View\Helper\CRUD\Decorator;
use App\View\Helper\CRUD\FieldOutputInterface;
/**
 * FieldOutputDecorator
 *
 * @author dondrake
 */
class FieldDecorator implements FieldOutputInterface {
	
	public $base;
	
	public $helper;
	
	public function __construct($object) {
		$this->base = $object;
	}
	
	public function output($field, $options = array()) {
		return $this->base->output($field, $options);
	}

}
