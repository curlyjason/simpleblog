<?php 
$this->start('css');
	echo $this->Html->css('crud_root');
$this->end();
?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
	<?= $this->element('CRUD/crud_actions_ul'); ?>
</div>
<div class="tags index large-10 medium-9 columns">
	<?= $this->element('CRUD/crud_index_table_form'); ?>
</div>
<?php 

?>
<div class="paginator">
	<ul class="pagination">
		<?= $this->Paginator->prev('< ' . __('previous')) ?>
		<?= $this->Paginator->numbers() ?>
<?= $this->Paginator->next(__('next') . ' >') ?>
	</ul>
	<p><?= $this->Paginator->counter() ?></p>
</div>
<?php
$this->Crud->useCrudData('Navigators');
$this->Crud->useActionPattern('model', 'Navigators', 'index');
$this->Crud->Field = $this->Crud->createFieldHandler('index');
echo $this->element('Navigators/li_link');
