<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Menu'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Child Menus'), ['controller' => 'ChildMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Menu'), ['controller' => 'ChildMenus', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Menus'), ['controller' => 'ParentMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'ParentMenus', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="menus index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('model') ?></th>
            <th><?= $this->Paginator->sort('label') ?></th>
            <th><?= $this->Paginator->sort('controller') ?></th>
            <th><?= $this->Paginator->sort('action') ?></th>
            <th><?= $this->Paginator->sort('query') ?></th>
            <th><?= $this->Paginator->sort('hash') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($menus as $menu): ?>
        <tr>
            <td><?= $this->Number->format($menu->id) ?></td>
            <td><?= h($menu->model) ?></td>
            <td><?= h($menu->label) ?></td>
            <td><?= h($menu->controller) ?></td>
            <td><?= h($menu->action) ?></td>
            <td><?= h($menu->query) ?></td>
            <td><?= h($menu->hash) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $menu->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $menu->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) ?>
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
