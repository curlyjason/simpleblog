<?php 

?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
	<?= $this->element('CRUD/crud_actions_ul'); ?>
</div>
<div class="tags index large-10 medium-9 columns">
	<?= $this->element('CRUD/crud_index_table'); ?>
</div>
<?php 
debug($this->Crud->_AssociationActions);die;
$tools = $this->Crud->_AssociationActions->load('Users')->load('tester');
foreach ($tools->content as $action) {
	debug($tools->parse->label($action));
	debug($tools->parse->action($action));

}
debug($this->Crud->_ModelActions);
?>