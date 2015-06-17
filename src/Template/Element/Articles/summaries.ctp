<?php
foreach ($articles as $article) {
	$this->set('article', $article);
	echo $this->element('Articles/summary');
	$tools = $this->Crud->useActionPattern('record', $this->Crud->alias('string'), $this->request->action);
	foreach ($tools->content as $tool) {
		echo $this->Crud->RecordAction->output($tools, $tool, $article) . '               ';
	}
}