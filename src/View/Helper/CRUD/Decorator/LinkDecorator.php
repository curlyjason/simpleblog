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

		$this->helper->addAttributes($field, [
			'action' => $this->helper->entity->action,
			'controller' => $this->helper->entity->controller,
			'?' => $this->helper->entity->query,
			'#' => $this->helper->entity->hash], FALSE); // false makes values overwrite, not merge

		return $this->helper->Html->link($this->base->output($field, $options), $options);
	}

}
