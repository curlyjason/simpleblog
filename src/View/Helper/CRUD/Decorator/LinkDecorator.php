<?php

namespace App\View\Helper\CRUD\Decorator;

use App\View\Helper\CRUD\Decorator\FieldDecorator;

/**
 * Description of LinkDecorator
 *
 * @author dondrake
 */
class LinkDecorator extends FieldDecorator {

	public function output($field, $options = array()) {

		// we're counting on having the link array overwrite every time so no old values accidentally persist
		$this->helper->addAttributes($field, ['link' =>
			['controller' => $this->helper->entity->controller,
			'action' => $this->helper->entity->action,
			'?' => $this->helper->entity->query,
			'#' => $this->helper->entity->hash]]);

		return $this->helper->Html->link($this->base->output($field, $options), $this->helper->columns()[$field]['attributes']['link']);
	}

}
