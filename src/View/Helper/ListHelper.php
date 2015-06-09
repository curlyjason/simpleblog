<?php

namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Collection\Collection;

/**
 * CakePHP ListHelper
 * @author jasont
 */
class ListHelper extends Helper {

	public function outputRecursiveLi($level, $crud, $data) {
		foreach ($level as $key => $value) {
			$crud->entity = $value;
			echo '<ul>';
			foreach ($crud->columns() as $column => $type) {
				$crud->addAttributes($column, ['action' => $value->action, 'controller' => $value->controller, '?' => $value->query, '#' => $value->hash], FALSE);
				echo $crud->output($column);
				$id = $value->id;
				$collection = new Collection($data);
				$children = $collection->filter(function ($nav, $key, $id) {
					debug($id);die;
					return $nav->parent_id === $value->id;
				});
				$this->outputRecursiveLi($children, $crud);
				echo '</li>';
			}
			echo '</ul>';
		}
	}

}
