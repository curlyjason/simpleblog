<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $block->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $block->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Blocks'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="blocks form large-10 medium-9 columns">
    <?= $this->Form->create($block); ?>
    <fieldset>
        <legend><?= __('Edit Block') ?></legend>
        <?php
            echo $this->Form->input('model');
            echo $this->Form->input('label');
            echo $this->Form->input('controller');
            echo $this->Form->input('action');
            echo $this->Form->input('query');
            echo $this->Form->input('hash');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
