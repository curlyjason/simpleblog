<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Site Structure'), ['action' => 'edit', $siteStructure->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Site Structure'), ['action' => 'delete', $siteStructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $siteStructure->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Site Structures'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Site Structure'), ['action' => 'add']) ?> </li>
    </ul>
</div>
<div class="siteStructures view large-10 medium-9 columns">
    <h2><?= h($siteStructure->id) ?></h2>
    <div class="row">
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($siteStructure->id) ?></p>
            <h6 class="subheader"><?= __('Model') ?></h6>
            <p><?= $this->Number->format($siteStructure->model) ?></p>
        </div>
    </div>
</div>
