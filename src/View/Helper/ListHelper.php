<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Collection\Collection;

/**
 * CakePHP ListHelper
 * @author jasont
 */
class ListHelper extends Helper {
	
	public $Crud;
	
	public function __construct(\Cake\View\View $View, array $config = array()) {
		parent::__construct($View, $config);
		$this->Crud = $config[0];
	}

	public function outputRecursiveLi($level, $data) {
//		debug($this->Crud);die;
		foreach ($level as $index => $value) {
			$this->Crud->entity = $value;
			echo '<ul>';
			foreach ($this->Crud->columns() as $column => $type) {
				$this->Crud->addAttributes($column, ['action' => $value->action, 'controller' => $value->controller, '?' => $value->query, '#' => $value->hash], FALSE);
				echo $this->Crud->output($column);
//				$id = $value->id;
			}
			$collection = new Collection($data);
			$children = $collection->filter(function ($nav, $key) {
//				debug($nav);
//				debug($key);
//					debug($id);
//					debug($id->items[$key]->id);
//					get_class_methods($id);die;
////					debug($nav);die;
////					debug($id);die;
				return $nav->parent_id === 9;
			});
			if (iterator_count($children) > 0) {
//				$this->outputRecursiveLi($children, $crud, $data);
//				die;
			}
//				debug(iterator_count($children));
			echo '</li>';
		}
		echo '</ul>';
	}

}

//	public function filter($param) {
//		
//	}

