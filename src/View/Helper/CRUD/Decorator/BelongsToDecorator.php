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
		if ($this->fieldIsKey($field, 'manyToOne')) {
			
			$output = $this->base->output($field, $options);
//			debug($this->helper->helpers());
			
			return ( $this->helper->entity->has($this->helper->CrudData->foreignKeys()[$field]['property']) ? 
//					"<a href=\"/{$this->helper->CrudData->foreignKeys()[$field]['name']}/view/$output\">$output</a>" :
					$this->helper->Html->link(
							$output,
							[
								'controller' => $this->helper->CrudData->foreignKeys()[$field]['name'], 
								'action' => 'view', $output
							]
					) :
					'' );
		}
		return $this->base->output($field, $options);
	}

	protected function fieldIsKey($field, $association) {	
		return (
				isset($this->helper->CrudData->foreignKeys()[$field]) && 
				!$this->helper->CrudData->foreignKeys()[$field]['owner'] && 
				$this->helper->CrudData->foreignKeys()[$field]['association_type'] === $association
		);
	}

}
