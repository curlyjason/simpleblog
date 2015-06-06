<?php

namespace App\View\Helper\CRUD\Decorator;

/**
 * BelongsToDecorator will make a standard link to owning records
 * 
 * This will watch every field and if it finds that the field is the 
 * foreign key in a belongsTo, it will turn the key into a link to the 
 * owning record. The link will be to the view action and will follow 
 * cake conventions.
 * 
 * eg:
 * $field = time_bomb_id
 * and it is found to be used in a manyToOne (belongsTo) relationship,
 * the link will go to /time_bombs/view/{time_bomb_id}
 *
 * @author dondrake
 */
class BelongsToDecorator extends FieldDecorator {

	public function output($field, $options = array()) {
		// if there is a override type on the field, don't make it a belongsTo link
		if (!in_array($this->helper->columnType($field), $this->helper->override())) {
			
			// if this is a belongsTo field, make it a link to the parent record
			if ($this->fieldIsKey($field, 'manyToOne')) {

				$output = $this->base->output($field, $options);
//			debug($this->helper->helpers());

				return ( $this->helper->entity->has($this->helper->foreignKeys()[$field]['property']) ?
//					"<a href=\"/{$this->helper->foreignKeys()[$field]['name']}/view/$output\">$output</a>" :
								$this->helper->Html->link(
										$output, //This should be a reference to the associate model's display
										[
									'controller' => $this->helper->foreignKeys()[$field]['name'],
									'action' => 'view',
									$output //This should be a reference to the associate model's primary key
										]
								) :
								'' );
			}
		}
		return $this->base->output($field, $options);
	}

	protected function fieldIsKey($field, $association) {
		return (
				isset($this->helper->foreignKeys()[$field]) &&
				!$this->helper->foreignKeys()[$field]['owner'] &&
				$this->helper->foreignKeys()[$field]['association_type'] === $association
				);
	}

}
