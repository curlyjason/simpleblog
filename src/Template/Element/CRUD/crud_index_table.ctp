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
		<?php
		foreach (${$crud_data->alias()->variableName} as $entity): $this->Crud->entity = $entity;
			$uuid = new \App\Lib\Uuid();
			$this->Crud->entity->_uuid = $uuid;
			?>
	        <tr <?= $uuid->attr('id', 'row') ?> class="record">
				<td hidden="TRUE">
					<?= $this->Form->create(NULL, ['id' => $uuid->uuid('form'), 'url' => ['action' => 'edit', $entity->id]]); ?>
					<?= $this->Form->input('id', ['value' => $entity->id]); ?>
					<?= $this->Form->end(); ?>
				</td>
				<?php
				foreach ($crud_data->columns() as $field => $specs) :
					echo "\t\t\t\t" . $this->Crud->output($field) . "\n";
				endforeach;
				?>
	            <td class="actions">
					<?php
					$tools = $this->Crud->actionPattern('record', $this->request->action);
					foreach ($tools->tools as $tool) {
						echo $this->Crud->RecordAction->output($tools, $tool, $entity);
//					echo $this->Html->link(__($tools->label($tool)), ['action' => $tools->action($tool), $this->Crud->entity->id]);
					}
					echo $this->Form->submit('Submit', ['form' => $uuid->uuid('form')]);
					?>
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
