<?php

?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
	<?= $this->element('CRUD/crud_actions_ul'); ?>
</div>

<?php
echo $this->element('CRUD/form');
