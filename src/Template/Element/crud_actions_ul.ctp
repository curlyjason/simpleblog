	<ul class="side-nav">
		<li><?= $this->Html->link(__("New {$this->request->controller}"), ['action' => 'add']) ?></li>
<?php 
foreach ($foreignKeys as $key) :
	$singular = Cake\Utility\Inflector::singularize($key['name']);
?>
		<li><?= $this->Html->link(__("List {$key['name']}"), ['controller' => $key['name'], 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__("New $singular"), ['controller' => $key['name'], 'action' => 'add']) ?> </li>
<?php
endforeach;
 ?>
    </ul>
