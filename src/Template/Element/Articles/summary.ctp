<article>
	<h3><?=$article->title ?></h3>
	<div class ="articleBody">
		<?= $this->Html->para('summaryText', $article->summary); ?>
	</div>
</article>
