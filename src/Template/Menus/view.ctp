<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Menu'), ['action' => 'edit', $menu->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Menu'), ['action' => 'delete', $menu->id], ['confirm' => __('Are you sure you want to delete # {0}?', $menu->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Menus'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Menu'), ['action' => 'add']) ?> </li>
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
    </div>
</div>
<pre><?= debug($menu); ?></pre>