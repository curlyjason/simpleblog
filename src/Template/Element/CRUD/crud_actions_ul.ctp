<?php $ent = strtolower(Cake\Utility\Inflector::singularize($this->request->controller)) ?>
<?php
if ($this->request->action != 'add'):
	$this->start('newDeleteActions');
	?>
	<li><?= $this->Html->link(__("New {$this->request->controller}"), ['action' => 'add']) ?></li>
		<?php if ($this->request->action != 'index'): ?>
		<li><?=
			$this->Form->postLink(
					__('Delete'), ['action' => 'delete', $$ent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $$ent->id)]
			)
			?></li>
	<?php endif; ?>
	<?php $this->end(); ?>
<?php endif; ?>
<ul class="side-nav">
	<?php
	echo $this->fetch('newDeleteActions');
	foreach ($foreignKeys as $key) :
		$singular = Cake\Utility\Inflector::singularize($key['name']);
		?>
		<li><?= $this->Html->link(__("List {$key['name']}"), ['controller' => $key['name'], 'action' => 'index']) ?> </li>
		<li><?= $this->Html->link(__("New $singular"), ['controller' => $key['name'], 'action' => 'add']) ?> </li>
		<?php
	endforeach;
	?>
</ul>
