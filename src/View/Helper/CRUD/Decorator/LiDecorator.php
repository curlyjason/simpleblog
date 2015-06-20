<?php
namespace App\View\Helper\CRUD\Decorator;

use App\View\Helper\CRUD\Decorator\FieldDecorator;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TableCellDecorator
 *
 * @author dondrake
 */
class LiDecorator extends FieldDecorator {
	
	public function output($field, $options = array()) {
		$tag = false;
		if (isset($options['li'])) {
			$tag = $this->helper->Html->tag('li', NULL, $options['li']);
		}
		return ($tag ? $tag : '<li>') . $this->base->output($field, $options);
	}

}
