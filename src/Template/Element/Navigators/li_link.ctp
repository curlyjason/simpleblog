<?php
foreach (${$this->Crud->alias()->variableName} as $key => $value) {
	$this->Crud->entity = $value;
	echo '<ul>';
	foreach ($this->Crud->columns() as $column => $type) {
		$this->Crud->addAttributes($column, ['action' => $value->action, 'controller' => $value->controller, '?' => $value->query, '#' => $value->hash], FALSE);
		echo $this->Crud->output($column);
		echo '</li>';
	}
	echo '</ul>';
}
?>