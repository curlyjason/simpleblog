<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
		<?= $this->element('CRUD/crud_actions_ul'); ?>
    </ul>
</div>
<div class="menus form large-10 medium-9 columns">
	<?php echo $this->element('CRUD/formx'); ?>
	<?php // echo $this->element('CRUD/form'); ?>
</div>
