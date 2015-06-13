<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $organization->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $organization->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Organizations'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Addresses'), ['controller' => 'Addresses', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Address'), ['controller' => 'Addresses', 'action' => 'add']) ?></li>
    </ul>
</div>
<div class="organizations form large-10 medium-9 columns">
    <?= $this->Form->create($organization) ?>
    <fieldset>
        <legend><?= __('Edit Organization') ?></legend>
        <?php
            echo $this->Form->input('name');
            echo $this->Form->input('truthy');
            echo $this->Form->input('explanation');
            echo $this->Form->input('addresses._ids', ['options' => $addresses]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
