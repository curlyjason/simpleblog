<article>
	<h3><?=$article->title ?></h3>
	<div class ="articleBody">
		<?= $this->Html->para('articleText', \Cake\Utility\Text::truncate($article->text, 250)); ?>
	</div>
</article>