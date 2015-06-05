        <?php
<%
        foreach ($fields as $field) {
            if (in_array($field, $primaryKey)) {
                continue;
            }
            if (isset($keyFields[$field])) {
                $fieldData = $schema->column($field);
                if (!empty($fieldData['null'])) {
%>
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field]//variablize field (lowercase plural) %>, 'empty' => true]);
<%
                } else {
%>
            echo $this->Form->input('<%= $field %>', ['options' => $<%= $keyFields[$field] %>]);
<%
                }
                continue;
            }
            if (!in_array($field, ['created', 'modified', 'updated'])) {
                $fieldData = $schema->column($field);
                if (($fieldData['type'] === 'date') && (!empty($fieldData['null']))) {
%>
            echo $this->Form->input('<%= $field %>', array('empty' => true, 'default' => ''));
<%
                } else {
%>
            echo $this->Form->input('<%= $field %>');
<%
                }
            }
        }
        if (!empty($associations['BelongsToMany'])) {
            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
%>
            echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
<%
            }
        }
%>
        ?>

		
		
</div>
<div class="<%= $pluralVar %> form large-10 medium-9 columns">
    <?= $this->Form->create($this->Crud->alias()->singularName); ?>
    <fieldset>
        <legend><?= __(Inflector::humanize($this->request->action) . ' ' . $this->Crud->alias()->singularHumanName) ?></legend>

<?php
foreach ($this->Crud->columns as $field) {
	if (in_array($field, $this->Crud->primaryKey())) {
		continue;
	}
	if (isset($this->Crud->foreignKeys[$field])) {
		$fieldData = $this->Crud->column($field) {
			if (!empty($fieldData['null'])) {
				
			}
		}
	}
	if (!in_array($field, ['created', 'modified', 'updated'])){
		
	}
//        if (!empty($associations['BelongsToMany'])) {
//            foreach ($associations['BelongsToMany'] as $assocName => $assocData) {
//				echo $this->Form->input('<%= $assocData['property'] %>._ids', ['options' => $<%= $assocData['variable'] %>]);
//            }
//        }
			
}
?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>