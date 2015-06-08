<?php
echo $this->Form->create(null, [
    'url' => ['action' => 'simpleSearch']
]);
echo $this->Form->input('search');
echo $this->Form->end();