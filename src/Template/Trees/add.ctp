<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Trees'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="trees form large-10 medium-9 columns">
    <?= $this->Form->create($tree); ?>
    <fieldset>
        <legend><?= __('Add Tree') ?></legend>
        <?php
            echo $this->Form->input('parent_tree_id');
            echo $this->Form->input('name');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
