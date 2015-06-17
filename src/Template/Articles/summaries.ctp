<?php
//debug($navigators);
//debug($this->Crud->_CrudData);
$this->Crud->useCrudData('Navigators');
echo $this->element('Navigators/li_link');
?>
<?= $this->element('Articles/summaries'); ?>
