<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Child Blocks Block'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Blocks'), ['controller' => 'Blocks', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Block'), ['controller' => 'Blocks', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="childBlocksBlocks index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('block_id') ?></th>
            <th><?= $this->Paginator->sort('child_block_id') ?></th>
            <th><?= $this->Paginator->sort('search_keys') ?></th>
            <th><?= $this->Paginator->sort('render_style') ?></th>
            <th><?= $this->Paginator->sort('filter') ?></th>
            <th><?= $this->Paginator->sort('query_limit') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($childBlocksBlocks as $childBlocksBlock): ?>
        <tr>
            <td><?= $this->Number->format($childBlocksBlock->id) ?></td>
            <td>
                <?= $childBlocksBlock->has('block') ? $this->Html->link($childBlocksBlock->block->id, ['controller' => 'Blocks', 'action' => 'view', $childBlocksBlock->block->id]) : '' ?>
            </td>
            <td><?= $this->Number->format($childBlocksBlock->child_block_id) ?></td>
            <td><?= h($childBlocksBlock->search_keys) ?></td>
            <td><?= h($childBlocksBlock->render_style) ?></td>
            <td><?= h($childBlocksBlock->filter) ?></td>
            <td><?= $this->Number->format($childBlocksBlock->query_limit) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $childBlocksBlock->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $childBlocksBlock->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $childBlocksBlock->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childBlocksBlock->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
