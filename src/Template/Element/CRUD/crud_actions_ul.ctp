<?php // $this->set('entity', $crud_data->_entityName($crud_data->alias())) 
//debug($crud_data->alias())?>
<?php
if ($this->request->action != 'add'):
	$this->start('newDeleteActions');
	?>
	<li><?= $this->Html->link(__("New {$this->request->controller}"), ['action' => 'add']) ?></li>
		<?php if ($this->request->action != 'index'): ?>
		<li><?=
			$this->Form->postLink(
					__('Delete'), 
					['action' => 'delete', ${$crud_data->alias()->entityName}->id], 
					['confirm' => __('Are you sure you want to delete # {0}?', ${$crud_data->alias()->entityName}->id)]
			)
			?></li>
	<?php endif; ?>
	<?php $this->end(); ?>
<?php endif; ?>
<ul class="side-nav">
	<?php
	echo $this->fetch('newDeleteActions');
	foreach ($crud_data->foreignKeys() as $key) :
		?>
		<li><?= $this->Html->link(__("List {$key['name']->singularHumanName}"), ['controller' => $key['name'], 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__("New {$key['name']->singularHumanName}"), ['controller' => $key['name'], 'action' => 'add']) ?> </li>
		<?php
	endforeach;
	?>
</ul>
