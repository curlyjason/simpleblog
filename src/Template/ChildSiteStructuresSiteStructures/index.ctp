<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Child Site Structures Site Structure'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Site Structures'), ['controller' => 'SiteStructures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Site Structure'), ['controller' => 'SiteStructures', 'action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Child Site Structures'), ['controller' => 'ChildSiteStructures', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Child Site Structure'), ['controller' => 'ChildSiteStructures', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="childSiteStructuresSiteStructures index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('site_structure_id') ?></th>
            <th><?= $this->Paginator->sort('child_site_structure_id') ?></th>
            <th><?= $this->Paginator->sort('search_keys') ?></th>
            <th><?= $this->Paginator->sort('render_style') ?></th>
            <th><?= $this->Paginator->sort('filter') ?></th>
            <th><?= $this->Paginator->sort('query_limit') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($childSiteStructuresSiteStructures as $childSiteStructuresSiteStructure): ?>
        <tr>
            <td><?= $this->Number->format($childSiteStructuresSiteStructure->id) ?></td>
            <td>
                <?= $childSiteStructuresSiteStructure->has('site_structure') ? $this->Html->link($childSiteStructuresSiteStructure->site_structure->id, ['controller' => 'SiteStructures', 'action' => 'view', $childSiteStructuresSiteStructure->site_structure->id]) : '' ?>
            </td>
            <td>
                <?= $childSiteStructuresSiteStructure->has('child_site_structure') ? $this->Html->link($childSiteStructuresSiteStructure->child_site_structure->id, ['controller' => 'ChildSiteStructures', 'action' => 'view', $childSiteStructuresSiteStructure->child_site_structure->id]) : '' ?>
            </td>
            <td><?= h($childSiteStructuresSiteStructure->search_keys) ?></td>
            <td><?= h($childSiteStructuresSiteStructure->render_style) ?></td>
            <td><?= h($childSiteStructuresSiteStructure->filter) ?></td>
            <td><?= $this->Number->format($childSiteStructuresSiteStructure->query_limit) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $childSiteStructuresSiteStructure->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $childSiteStructuresSiteStructure->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $childSiteStructuresSiteStructure->id], ['confirm' => __('Are you sure you want to delete # {0}?', $childSiteStructuresSiteStructure->id)]) ?>
            </td>
        </tr>

    <?php endforeach; ?>
    </tbody>
    </table>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
        </ul>
        <p><?= $this->Paginator->counter() ?></p>
    </div>
</div>
