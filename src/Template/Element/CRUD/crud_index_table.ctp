<?php
//debug($this->Crud);
$this->Crud->useCrudData('Menus');

?>

    <table cellpadding="0" cellspacing="0">
    <thead>
        <tr>
			<?php
			foreach ($crud_data->columns() as $column_name => $column_specs) {
				echo '<th>' . $this->Paginator->sort($column_name) . '</th>';
			}
			?>
            <th class="actions"><?= __('Actions') ?></th>
        </tr>
    </thead>
    <tbody>
	<?php foreach (${$crud_data->alias()->variableName} as $entity): $this->Crud->entity = $entity;?>
        <tr class="record">
			<?php
			foreach ($crud_data->columns() as $field => $specs) :
				echo "\t\t\t\t" . $this->Crud->field('index', $field) . "\n";
			endforeach;
			?>
            <td class="actions">
                <?= $this->Html->link(__('View'), ['action' => 'view', $entity->id]) ?>
                <?= $this->Html->link(__('Edit'), ['action' => 'edit', $entity->id]) ?>
                <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $entity->id], ['confirm' => __('Are you sure you want to delete # {0}?', $entity->id)]) ?>
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
