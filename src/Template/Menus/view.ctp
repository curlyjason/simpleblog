<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Block'), ['action' => 'edit', $block->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Block'), ['action' => 'delete', $block->id], ['confirm' => __('Are you sure you want to delete # {0}?', $block->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Blocks'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Block'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="blocks view large-10 medium-9 columns">
    <h2><?= h($block->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Model') ?></h6>
            <p><?= h($block->model) ?></p>
            <h6 class="subheader"><?= __('Label') ?></h6>
            <p><?= h($block->label) ?></p>
            <h6 class="subheader"><?= __('Controller') ?></h6>
            <p><?= h($block->controller) ?></p>
            <h6 class="subheader"><?= __('Action') ?></h6>
            <p><?= h($block->action) ?></p>
            <h6 class="subheader"><?= __('Query') ?></h6>
            <p><?= h($block->query) ?></p>
            <h6 class="subheader"><?= __('Hash') ?></h6>
            <p><?= h($block->hash) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($block->id) ?></p>
        </div>
    </div>
</div>
