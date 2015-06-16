<?php
foreach ($articles as $article) {
	$this->set('article', $article);
	echo $this->element('Articles/summary');
}