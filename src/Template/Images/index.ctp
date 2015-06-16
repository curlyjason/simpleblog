<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <li><?= $this->Html->link(__('New Image'), ['action' => 'add']) ?></li>
        <li><?= $this->Html->link(__('List Articles'), ['controller' => 'Articles', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Article'), ['controller' => 'Articles', 'action' => 'add']) ?> </li>
    </ul>
</div>
<div class="images index large-10 medium-9 columns">
    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
            <th><?= $this->Paginator->sort('img_file') ?></th>
            <th><?= $this->Paginator->sort('id') ?></th>
            <th><?= $this->Paginator->sort('article_id') ?></th>
            <th><?= $this->Paginator->sort('modified') ?></th>
            <th><?= $this->Paginator->sort('created') ?></th>
            <th><?= $this->Paginator->sort('mimetype') ?></th>
            <th><?= $this->Paginator->sort('filesize') ?></th>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($images as $image): ?>
        <tr>
            <td><?= h($image->img_file) ?></td>
            <td><?= $this->Number->format($image->id) ?></td>
            <td>
                <?= $image->has('article') ? $this->Html->link($image->article->title, ['controller' => 'Articles', 'action' => 'view', $image->article->id]) : '' ?>
            </td>
            <td><?= h($image->modified) ?></td>
            <td><?= h($image->created) ?></td>
            <td><?= h($image->mimetype) ?></td>
            <td><?= $this->Number->format($image->filesize) ?></td>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $image->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $image->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $image->id], ['confirm' => __('Are you sure you want to delete # {0}?', $image->id)]) ?>
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
