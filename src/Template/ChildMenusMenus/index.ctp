<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Child Menus Menu'), ['action' => 'add']) ?></li>
    </ul>
</div>
<div class="childMenusMenus index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('menu_id') ?></th>
            <th><?= $this->Paginator->sort('child_menu_id') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($childMenusMenus as $childMenusMenu): ?>
        <tr>
            <td><?= $this->Number->format($childMenusMenu->id) ?></td>
            <td><?= $this->Number->format($childMenusMenu->menu_id) ?></td>
            <td><?= $this->Number->format($childMenusMenu->child_menu_id) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $childMenusMenu->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $childMenusMenu->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $childMenusMenu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childMenusMenu->id)]) ?>
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
