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
endforeach; die;
// done with the primary model

//// loop for the associated models
//foreach ($crud_data->foreignKeys() as $key => $value) :
//	// now loop the actions for this model
//	foreach ($assocActions->tools as $tool) :
//?>
	<li> //<?= '';//$this->Crud->ModelAction->output($modelActions, $tool, $value['name']) ?> </li>
//<?php
//	endforeach;
//endforeach;	
//// done with the associated models and thier actions
?>
</ul>
