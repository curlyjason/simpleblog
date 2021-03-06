<?php

use App\Lib\NameConventions;
use Cake\Utility\Inflector;
?>		

<div class="<?= $this->Crud->alias()->variableName; ?> form large-10 medium-9 columns">
	<?= $this->Form->create(${$this->Crud->alias()->singularName}); ?>
    <fieldset>
        <legend><?= __(Inflector::humanize($this->request->action) . ' ' . $this->Crud->alias()->singularHumanName) ?></legend>

		<?php
		foreach (array_keys($this->Crud->columns()) as $field) {
			if (in_array($field, $this->Crud->primaryKey(TRUE))) {
				continue;
			}
			if (isset($this->Crud->foreignKeys()[$field])) {
				$field = new NameConventions($field);
				$fieldData = $this->Crud->column($field->name);
				if (!empty($fieldData['null'])) {
					echo $this->Form->input($field->name, ['options' => ${strtolower($field->modelName)}, 'empty' => 'Choose one']);
				} else {
					echo $this->Form->input($field->name, ['options' => ${strtolower($field->modelName)}]);
				}
				continue;
			}
			if (!in_array($field, ['created', 'modified', 'updated'])) {
				$fieldData = $this->Crud->column($field);
				if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
					echo $this->Form->input($field, array('empty' => true, 'default' => ''));
				} else {
					echo $this->Form->input($field);
				}
			}
		}
		if (!empty($this->Crud->associations())) {
			foreach ($this->Crud->associations() as $assoc) {
				if (in_array($assoc['association_type'], ['oneToMany', 'manyToMany'])) {
					echo $this->Form->input($assoc['property'] . '._ids', ['options' => ${$assoc['name']->variableName}]);
				}
			}
//        if (!empty($associations['BelongsToMany'])) {
//            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
//				echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
//            }
//        }
		}
		?>
	</fieldset>
	<?php
	$tools = $this->Crud->useActionPattern('record', $this->Crud->alias('string'), $this->request->action);
	foreach ($tools->content as $tool) {
		echo $this->Crud->RecordAction->output($tools, $tool, ${$this->Crud->alias()->singularName});
//					echo $this->Html->link(__($tools->label($tool)), ['action' => $tools->action($tool), $this->Crud->entity->id]);
	}
	?>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>