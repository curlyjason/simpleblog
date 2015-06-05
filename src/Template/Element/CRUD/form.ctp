<?php use App\Lib\NameConventions; 
use Cake\Utility\Inflector; ?>		
</div>
<div class="<?= $this->Crud->alias()->variableName; ?> form large-10 medium-9 columns">
    <?= $this->Form->create($this->Crud->alias()->singularName); ?>
    <fieldset>
        <legend><?= __(Inflector::humanize($this->request->action) . ' ' . $this->Crud->alias()->singularHumanName) ?></legend>

<?php
foreach (array_keys($this->Crud->columns()) as $field) {
	if (in_array($field, $this->Crud->primaryKey())) {
		continue;
	}
	if (isset($this->Crud->foreignKeys[$field])) {
		$field = new NameConventions($field);
		$fieldData = $this->Crud->column($field);
		if (!empty($fieldData['null'])) {
			echo $this->Form->input($field, ['options' => $field->variableName, 'empty' => true]);
		} else {
			echo $this->Form->input('<%= $field %>', ['options' => $$field->variableName]);
		}
		continue;
	}
	if (!in_array($field, ['created', 'modified', 'updated'])){
		$fieldData = $this->Crud->column($field);
		if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
            echo $this->Form->input($field, array('empty' => true, 'default' => ''));
        } else {
            echo $this->Form->input($field);
        }
	}
}
//        if (!empty($associations['BelongsToMany'])) {
//            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
//				echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
//            }
//        }
			
?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>