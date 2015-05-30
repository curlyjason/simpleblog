<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Menu'), ['action' => 'edit', $menu->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Menu'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Menus'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menu'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Menus'), ['controller' => 'ChildMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Menu'), ['controller' => 'ChildMenus', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Menus'), ['controller' => 'ParentMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'ParentMenus', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="menus view large-10 medium-9 columns">
    <h2><?= h($menu->label) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Model') ?></h6>
            <p><?= h($menu->model) ?></p>
            <h6 class="subheader"><?= __('Label') ?></h6>
            <p><?= h($menu->label) ?></p>
            <h6 class="subheader"><?= __('Controller') ?></h6>
            <p><?= h($menu->controller) ?></p>
            <h6 class="subheader"><?= __('Action') ?></h6>
            <p><?= h($menu->action) ?></p>
            <h6 class="subheader"><?= __('Query') ?></h6>
            <p><?= h($menu->query) ?></p>
            <h6 class="subheader"><?= __('Hash') ?></h6>
            <p><?= h($menu->hash) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($menu->id) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($menu->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($menu->modified) ?></p>
        </div>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related ChildMenus') ?></h4>
    <?php if (!empty($menu->child_menus)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Model') ?></th>
            <th><?= __('Label') ?></th>
            <th><?= __('Controller') ?></th>
            <th><?= __('Action') ?></th>
            <th><?= __('Query') ?></th>
            <th><?= __('Hash') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($menu->child_menus as $childMenus): ?>
        <tr>
            <td><?= h($childMenus->id) ?></td>
            <td><?= h($childMenus->model) ?></td>
            <td><?= h($childMenus->label) ?></td>
            <td><?= h($childMenus->controller) ?></td>
            <td><?= h($childMenus->action) ?></td>
            <td><?= h($childMenus->query) ?></td>
            <td><?= h($childMenus->hash) ?></td>
            <td><?= h($childMenus->created) ?></td>
            <td><?= h($childMenus->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'ChildMenus', 'action' => 'view', $childMenus->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'ChildMenus', 'action' => 'edit', $childMenus->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ChildMenus', 'action' => 'delete', $childMenus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childMenus->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
<div class="related row">
    <div class="column large-12">
    <h4 class="subheader"><?= __('Related ParentMenus') ?></h4>
    <?php if (!empty($menu->parent_menus)): ?>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?= __('Id') ?></th>
            <th><?= __('Model') ?></th>
            <th><?= __('Label') ?></th>
            <th><?= __('Controller') ?></th>
            <th><?= __('Action') ?></th>
            <th><?= __('Query') ?></th>
            <th><?= __('Hash') ?></th>
            <th><?= __('Created') ?></th>
            <th><?= __('Modified') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
        <?php foreach ($menu->parent_menus as $parentMenus): ?>
        <tr>
            <td><?= h($parentMenus->id) ?></td>
            <td><?= h($parentMenus->model) ?></td>
            <td><?= h($parentMenus->label) ?></td>
            <td><?= h($parentMenus->controller) ?></td>
            <td><?= h($parentMenus->action) ?></td>
            <td><?= h($parentMenus->query) ?></td>
            <td><?= h($parentMenus->hash) ?></td>
            <td><?= h($parentMenus->created) ?></td>
            <td><?= h($parentMenus->modified) ?></td>

            <td class="actions">
                <?= $this->Html->link(__('View'), ['controller' => 'ParentMenus', 'action' => 'view', $parentMenus->id]) ?>

                <?= $this->Html->link(__('Edit'), ['controller' => 'ParentMenus', 'action' => 'edit', $parentMenus->id]) ?>

                <?= $this->Form->postLink(__('Delete'), ['controller' => 'ParentMenus', 'action' => 'delete', $parentMenus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $parentMenus->id)]) ?>

            </td>
        </tr>

        <?php endforeach; ?>
    </table>
    <?php endif; ?>
    </div>
</div>
