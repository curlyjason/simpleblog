<?php
use Cake\Utility\Inflector;
?>
<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
	<?= $this->element('CRUD/crud_actions_ul'); ?>
</div>

<?php
//$this->start('string');
//$this->end();
//debug($this->Crud->columns());
//debug($this->Crud->alias());die;
//debug(${$this->Crud->alias()->singularName});die;
$this->Crud->entity = ${$this->Crud->alias()->singularName};
foreach ($this->Crud->columns() as $field => $data) {
	$type = $this->Crud->columnType($field);
	if (isset($this->Crud->foreignKeys()[$type])) {
		$this->start('string');
		echo "<p>{$this->Crud->output($field)}</p>\n";
		$this->end();
		continue;
	}
	switch ($type) {
		case 'integer':
		case 'float':
		case 'decimal':
		case 'biginteger':
//			debug('number');
//			debug($this->Crud->output($field));
			$this->append('number');
			echo '<h6 class="subheader">'.__(Inflector::humanize($field))."</h6>\n";
			echo "<p>{$this->Crud->output($field)}</p>\n";
			$this->end();
			break;
		case 'date':
		case 'time':
		case 'datetime':
		case 'timestamp':
//			debug('date');
//			debug($this->Crud->output($field));
			$this->append('date');
			echo '<h6 class="subheader">'.__(Inflector::humanize($field))."</h6>\n";
			echo "<p>{$this->Crud->output($field)}</p>\n";
			$this->end();
			break;
		case 'text':
			$this->append('text');
			echo "<div class=\"columns large-9\">\n";
			echo '<h6 class="subheader">'.__(Inflector::humanize($field))."</h6>\n";
			echo "<p>{$this->Crud->output($field)}</p>\n";
			echo "</div>\n";
			$this->end();
			break;
		case 'boolean': 
			$this->append('boolean');
			echo '<h6 class="subheader">'.__(Inflector::humanize($field))."</h6>\n";
			echo "<p>{$this->Crud->output($field)}</p>\n";
			$this->end();
			break;
		default:
			$this->append('string');
			echo '<h6 class="subheader">'.__(Inflector::humanize($field))."</h6>\n";
			echo "<p>{$this->Crud->output($field)}</p>\n";
			$this->end();
			break;
	}
}
/*
 * 	$type = $schema->columnType($field);
	if (isset($associationFields[$field])) {
		$this->append('string');
		echo $this->Crud->output($field, $data['attributes']);
		$this->end();
	}
	if (in_array($type, ['integer', 'float', 'decimal', 'biginteger'])) {
	}
	if (in_array($type, ['date', 'time', 'datetime', 'timestamp'])) {
	}
	return in_array($type, ['text', 'boolean']) ? $type : 'string';
     
 */
?>
<div class="<?= $this->Crud->alias()->variableName; ?> view large-10 medium-9 columns">

    <h2><?= h($this->Crud->displayField()) ?></h2>
    <div class="row">
		<?php if ($string = $this->fetch('string')) : ?>
			<div class="large-5 columns strings">
				<!--this will be watched by the decorator for association links-->
				<?= $string; ?>
			</div>
		<?php endif; ?>
		<?php if ($this->fetch('number')) : ?>
			<div class="large-2 columns numbers end">
				<?= $this->fetch('number'); ?>
			</div>
			<?php endif; ?>
		<?php if ($this->fetch('date')) : ?>
			<div class="large-2 columns dates end">
				<?= $this->fetch('date'); ?>
			</div>
			<?php endif; ?>
		<?php if ($this->fetch('boolean')) : ?>
			<div class="large-2 columns booleans end">
				<?= $this->fetch('boolean'); ?>
			</div>
		<?php endif; ?>
    </div>
	<?php if ($this->fetch('text')) : ?>
		<div class="row texts">
			<?= $this->fetch('text'); ?>
		</div>
	<?php endif; ?>
</div>
<?php
//$relations = $associations['HasMany'] + $associations['BelongsToMany'];
//foreach ($relations as $alias => $details):
//	$otherSingularVar = Inflector::variable($alias);
//	$otherPluralHumanName = Inflector::humanize($details['controller']);
//	?>
<!--
	<div class="related row">
		<div class="column large-12">
			<h4 class="subheader"><?php // __("Related $otherPluralHumanName") ?></h4>
	<?php// if (!empty($$singularVar->$details['property'])): ?>
				<table cellpadding="0" cellspacing="0">
					<tr>
						<?php// foreach ($details['fields'] as $field): ?>
							<th><?php // __('<%= Inflector::humanize($field) %>') ?></th>
		<?php //endforeach; ?>
						<th class="actions">//<?= __('Actions') ?></th>
					</tr>
						<?php //foreach ($$singularVar->$details['property'] as $$otherSingularVar): ?>
						<tr>
							<?php //foreach ($details['fields'] as $field): ?>
								<td><?php // h($$otherSingularVar->$field) ?></td>
							<?php
//							endforeach;
//
//							$otherPk = "\${$otherSingularVar}->{$details['primaryKey'][0]}";
//							?>
							<td class="actions">
								Record Actions
							</td>
						</tr>

				<?php //endforeach; ?>
				</table>
	<?php //endif; ?>
		</div>
	</div>
<?php //endforeach; ?>
-->