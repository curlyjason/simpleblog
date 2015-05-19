<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Child Blocks Block'), ['action' => 'edit', $childBlocksBlock->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Child Blocks Block'), ['action' => 'delete', $childBlocksBlock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childBlocksBlock->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Child Blocks Blocks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Blocks Block'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Blocks'), ['controller' => 'Blocks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Block'), ['controller' => 'Blocks', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="childBlocksBlocks view large-10 medium-9 columns">
    <h2><?= h($childBlocksBlock->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Block') ?></h6>
            <p><?= $childBlocksBlock->has('block') ? $this->Html->link($childBlocksBlock->block->id, ['controller' => 'Blocks', 'action' => 'view', $childBlocksBlock->block->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Search Keys') ?></h6>
            <p><?= h($childBlocksBlock->search_keys) ?></p>
            <h6 class="subheader"><?= __('Render Style') ?></h6>
            <p><?= h($childBlocksBlock->render_style) ?></p>
            <h6 class="subheader"><?= __('Filter') ?></h6>
            <p><?= h($childBlocksBlock->filter) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($childBlocksBlock->id) ?></p>
            <h6 class="subheader"><?= __('Child Block Id') ?></h6>
            <p><?= $this->Number->format($childBlocksBlock->child_block_id) ?></p>
            <h6 class="subheader"><?= __('Query Limit') ?></h6>
            <p><?= $this->Number->format($childBlocksBlock->query_limit) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($childBlocksBlock->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($childBlocksBlock->modified) ?></p>
        </div>
    </div>
</div>
