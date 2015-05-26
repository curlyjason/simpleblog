<?php
$label = strtoupper(Cake\Utility\Inflector::singularize($key['name']));
     echo $this->Form->create($foreignKey['property']); 
?>
    <fieldset>
        <legend><?= __("Add $label") ?></legend>
        <?php
			foreach ($columns as $field => $type) :
				echo $this->Form->input($field);
			endforeach;
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
