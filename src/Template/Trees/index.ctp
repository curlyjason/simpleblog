<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Tree'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="trees index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th><?= $this->Paginator->sort('updated') ?></th>
            <th><?= $this->Paginator->sort('parent_tree_id') ?></th>
            <th><?= $this->Paginator->sort('name') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($trees as $tree): ?>
        <tr>
            <td><?= $this->Number->format($tree->id) ?></td>
            <td><?= h($tree->created) ?></td>
            <td><?= h($tree->modified) ?></td>
            <td><?= h($tree->updated) ?></td>
            <td><?= $this->Number->format($tree->parent_tree_id) ?></td>
            <td><?= h($tree->name) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $tree->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $tree->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $tree->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tree->id)]) ?>
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
