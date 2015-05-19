<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $childBlocksBlock->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $childBlocksBlock->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Child Blocks Blocks'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Blocks'), ['controller' => 'Blocks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Block'), ['controller' => 'Blocks', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="childBlocksBlocks form large-10 medium-9 columns">
    <?= $this->Form->create($childBlocksBlock); ?>
    <fieldset>
        <legend><?= __('Edit Child Blocks Block') ?></legend>
        <?php
            echo $this->Form->input('block_id', ['options' => $blocks, 'empty' => true]);
            echo $this->Form->input('child_block_id');
            echo $this->Form->input('search_keys');
            echo $this->Form->input('render_style');
            echo $this->Form->input('filter');
            echo $this->Form->input('query_limit');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
