<?php
	$modelActions = $this->Crud->useActionPattern('model', 'Menus', $this->request->action);
//	$assocActions = $this->Crud->actionPattern('associate', $this->request->action);
?>
<ul class="side-nav">

<?php  
//debug($modelActions);die;
// Loop for the primary models actions 
foreach ($modelActions->content as $tool) : 
?>
	<li> <?= $this->Crud->ModelAction->output($modelActions, $tool, $crud_data->alias()) ?> </li>
<?php 
endforeach;
// done with the primary model

// loop for the associated models

foreach ($crud_data->foreignKeys() as $key => $value) :
//	debug($value['name']->modelName);
//	debug($value);
	$assocActions = $this->Crud->useActionPattern('association', $value['name']->modelName, $this->request->action);
//	debug($assocActions);die;
	// now loop the actions for this model
	foreach ($assocActions->content as $tool) :
	
?>
	<li> <?= $this->Crud->ModelAction->output($modelActions, $tool, $value['name']->pluralHumanName) ?> </li>
<?php
	endforeach;
endforeach;
// done with the associated models and thier actions
?>
</ul>
