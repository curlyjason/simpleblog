<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Site Structures'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="siteStructures form large-10 medium-9 columns">
    <?= $this->Form->create($siteStructure); ?>
    <fieldset>
        <legend><?= __('Add Site Structure') ?></legend>
        <?php
            echo $this->Form->input('model');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
