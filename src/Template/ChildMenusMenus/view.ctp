<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Child Menus Menu'), ['action' => 'edit', $childMenusMenu->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Child Menus Menu'), ['action' => 'delete', $childMenusMenu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childMenusMenu->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Child Menus Menus'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Menus Menu'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="childMenusMenus view large-10 medium-9 columns">
    <h2><?= h($childMenusMenu->id) ?></h2>
    <div class="row">
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($childMenusMenu->id) ?></p>
            <h6 class="subheader"><?= __('Menu Id') ?></h6>
            <p><?= $this->Number->format($childMenusMenu->menu_id) ?></p>
            <h6 class="subheader"><?= __('Child Menu Id') ?></h6>
            <p><?= $this->Number->format($childMenusMenu->child_menu_id) ?></p>
        </div>
    </div>
</div>
