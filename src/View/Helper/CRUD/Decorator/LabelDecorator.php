<?php
namespace App\View\Helper\CRUD\Decorator;

use App\View\Helper\CRUD\Decorator\FieldDecorator;

/**
 * Description of LabelDecorator
 *
 * @author dondrake
 */
class LabelDecorator extends FieldDecorator{

	public function output($field, $options = array()) {
		
		$name = new \App\Lib\NameConventions($field);
		return '<p><span>' . $name->singularHumanName . ': </span>' . $this->base->output($field, $options) . "</p>\n";
		
	}
	
}
