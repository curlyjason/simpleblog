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
//		debug($entity->table_tag);
			$uuid = new \App\Lib\Uuid();
			$this->Crud->entity->_uuid = $uuid;
			?>
			<tr <?= $uuid->attr('id', 'row') ?> class="record">
				<td colspan="<?= count($this->Crud->columns()) ?>">
					<?= $this->Form->create($entity, ['id' => $uuid->uuid('form'), 'url' => ['action' => 'edit', $entity->id]]); ?>
					<?= $entity->table_tag ? $entity->table_tag : '<table>' ?>
					<?php //debug($this->Crud->primaryKey()); die;?>
					<?php // echo $this->Form->input($this->Crud->primaryKey()[0]); ?>
		<tbody>
			<tr>
				<?php
				foreach ($crud_data->columns() as $field => $specs) :
					echo "\t\t\t\t" . $this->Crud->output($field) . "\n";
				endforeach;
				?>
				<td class="actions">
					<?php
					$tools = $this->Crud->useActionPattern('record', $crud_data->alias('string'), $this->request->action);
					foreach ($tools->content as $tool) {
						echo $this->Crud->RecordAction->output($tools, $tool, $entity);
					}
					?>
				</td>
			</tr>
		</tbody>
	</table>
	<?= $this->Form->end(); ?>
	</td>
	</tr>

<?php endforeach; ?>
</tbody>
</table>
