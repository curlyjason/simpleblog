<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Menus'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Child Menus'), ['controller' => 'ChildMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Menu'), ['controller' => 'ChildMenus', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Parent Menus'), ['controller' => 'ParentMenus', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Parent Menu'), ['controller' => 'ParentMenus', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="menus form large-10 medium-9 columns">
    <?= $this->Form->create($menu); ?>
    <fieldset>
        <legend><?= __('Add Menu') ?></legend>
        <?php
            echo $this->Form->input('model');
            echo $this->Form->input('label');
            echo $this->Form->input('controller');
            echo $this->Form->input('action');
            echo $this->Form->input('query');
            echo $this->Form->input('hash');
            echo $this->Form->input('child_menus._ids', ['options' => $childMenus]);
            echo $this->Form->input('parent_menus._ids', ['options' => $parentMenus]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
