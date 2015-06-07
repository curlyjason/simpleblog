<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('List Addresses'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="addresses form large-10 medium-9 columns">
    <?= $this->Form->create($address); ?>
    <fieldset>
        <legend><?= __('Add Address') ?></legend>
        <?php
            echo $this->Form->input('address');
            echo $this->Form->input('user_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
