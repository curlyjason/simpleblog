<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $childMenusMenu->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $childMenusMenu->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Child Menus Menus'), ['action' => 'index']) ?></li>
    </ul>
</div>
<div class="childMenusMenus form large-10 medium-9 columns">
    <?= $this->Form->create($childMenusMenu); ?>
    <fieldset>
        <legend><?= __('Edit Child Menus Menu') ?></legend>
        <?php
            echo $this->Form->input('menu_id');
            echo $this->Form->input('child_menu_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
