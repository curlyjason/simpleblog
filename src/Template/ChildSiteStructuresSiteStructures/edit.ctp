<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $childSiteStructuresSiteStructure->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $childSiteStructuresSiteStructure->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Child Site Structures Site Structures'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Site Structures'), ['controller' => 'SiteStructures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Site Structure'), ['controller' => 'SiteStructures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Site Structures'), ['controller' => 'ChildSiteStructures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Site Structure'), ['controller' => 'ChildSiteStructures', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="childSiteStructuresSiteStructures form large-10 medium-9 columns">
    <?= $this->Form->create($childSiteStructuresSiteStructure); ?>
    <fieldset>
        <legend><?= __('Edit Child Site Structures Site Structure') ?></legend>
        <?php
            echo $this->Form->input('site_structure_id', ['options' => $siteStructures, 'empty' => true]);
            echo $this->Form->input('child_site_structure_id', ['options' => $childSiteStructures, 'empty' => true]);
            echo $this->Form->input('search_keys');
            echo $this->Form->input('render_style');
            echo $this->Form->input('filter');
            echo $this->Form->input('query_limit');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
