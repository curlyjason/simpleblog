<?php
namespace App\View\Helper\CRUD\Decorator;

/**
 * Description of BelongsToDecorator
 *
 * @author dondrake
 */
class BelongsToDecorator extends FieldDecorator {
	
	public function output($field, $options = array()) {
		if ($this->fieldIsKey($field, 'manyToOne')) {
			
			$output = $this->base->output($field, $options);
			
			return ( $this->entity->has($this->helper->CrudData->foreignKeys()[$field]['property']) ? 
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
