<?php

namespace App\View\Helper\CRUD\Decorator;

/**
 * EmptySelectorDecorator will add an 'empty' attribute to drop-list selectors that allow NULL
 * 
 * This will watch every field and if it finds that the field is a 
 * hasMany link, a date input of any stripe 
 * [[or a select list]]  ----------------- this needs a $var-exists check based on the field name ---------------
 * and that NULL is allowed, it will add a 'Choose one' to the select list 
 * 
 * @author dondrake
 */
class EmptySelectorDecorator extends FieldDecorator {
	
	protected $belongsTo = NULL;
	
	public function output($field, $options = []) {
		$data = $this->helper->column($field);
		
		// Watch for belongsTo
		// If NULL is allowed set an 'empty' attribute
		if (isset($this->helper->foreignKeys()[$field]) && $data['null']) {
//			debug($this->helper->CrudData);
			$this->helper->addAttributes($field, ['input' => ['empty' => 'Choose one']]);
		}

		// Watch for Date/Time which Cake renders in select lists
		// If NULL is allowed set an 'empty' attribute
		if (preg_match('/date|time/', $data['type']) && $data['null']) {
			$this->helper->addAttributes($field, ['input' => ['empty' => '--', 'default' => '']]);
		}
			
//		return $this->base->output($field, $this->helper->column($field)['attributes']);
		return $this->base->output($field);
	}

//	protected function fieldIsKey($field, $type) {
//
//		$associations = collection($this->helper->associations())->filter(function($association, $key) use ($field) {
//			return $association['foreign_key'] === $field;
//		});
//		foreach ($associations as $association) {
//			if (isset($this->helper->foreignKeys()[$field]) &&
//				!$association['owner'] &&
//				$association['association_type'] === $type) {
//				return $association;
//			}			
//		}
//		return false;
//	}

}
