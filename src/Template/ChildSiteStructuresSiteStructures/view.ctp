<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('Edit Child Site Structures Site Structure'), ['action' => 'edit', $childSiteStructuresSiteStructure->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Child Site Structures Site Structure'), ['action' => 'delete', $childSiteStructuresSiteStructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childSiteStructuresSiteStructure->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Child Site Structures Site Structures'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Site Structures Site Structure'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Site Structures'), ['controller' => 'SiteStructures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Site Structure'), ['controller' => 'SiteStructures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Site Structures'), ['controller' => 'ChildSiteStructures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Site Structure'), ['controller' => 'ChildSiteStructures', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="childSiteStructuresSiteStructures view large-10 medium-9 columns">
    <h2><?= h($childSiteStructuresSiteStructure->id) ?></h2>
    <div class="row">
        <div class="large-5 columns strings">
            <h6 class="subheader"><?= __('Site Structure') ?></h6>
            <p><?= $childSiteStructuresSiteStructure->has('site_structure') ? $this->Html->link($childSiteStructuresSiteStructure->site_structure->id, ['controller' => 'SiteStructures', 'action' => 'view', $childSiteStructuresSiteStructure->site_structure->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Child Site Structure') ?></h6>
            <p><?= $childSiteStructuresSiteStructure->has('child_site_structure') ? $this->Html->link($childSiteStructuresSiteStructure->child_site_structure->id, ['controller' => 'ChildSiteStructures', 'action' => 'view', $childSiteStructuresSiteStructure->child_site_structure->id]) : '' ?></p>
            <h6 class="subheader"><?= __('Search Keys') ?></h6>
            <p><?= h($childSiteStructuresSiteStructure->search_keys) ?></p>
            <h6 class="subheader"><?= __('Render Style') ?></h6>
            <p><?= h($childSiteStructuresSiteStructure->render_style) ?></p>
            <h6 class="subheader"><?= __('Filter') ?></h6>
            <p><?= h($childSiteStructuresSiteStructure->filter) ?></p>
        </div>
        <div class="large-2 columns numbers end">
            <h6 class="subheader"><?= __('Id') ?></h6>
            <p><?= $this->Number->format($childSiteStructuresSiteStructure->id) ?></p>
            <h6 class="subheader"><?= __('Query Limit') ?></h6>
            <p><?= $this->Number->format($childSiteStructuresSiteStructure->query_limit) ?></p>
        </div>
        <div class="large-2 columns dates end">
            <h6 class="subheader"><?= __('Created') ?></h6>
            <p><?= h($childSiteStructuresSiteStructure->created) ?></p>
            <h6 class="subheader"><?= __('Modified') ?></h6>
            <p><?= h($childSiteStructuresSiteStructure->modified) ?></p>
        </div>
    </div>
</div>
