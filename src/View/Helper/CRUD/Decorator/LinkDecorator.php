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
class LinkDecorator extends FieldDecorator {
	
	public function output($field, $options = array()) {
//		return $this->helper->Html->tag('td', $this->base->output($field, $options), $options);
		debug($options);
		return $this->helper->Html->link($this->base->output($field, $options), ['action' => $options['action'], 'controller' => $options['controller']]);
	}

}
