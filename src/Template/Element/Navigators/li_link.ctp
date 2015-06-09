<?php

use Cake\Collection\Collection;

$collection = new Collection(${$this->Crud->alias()->variableName});
$roots = $collection->filter(function ($nav, $key) {
    return $nav->parent_id === NULL;
});
//$children = $collection->filter(function ($nav, $key) {
//    return $nav->gender === 'male';
//});
echo $this->List->outputRecursiveLi($roots, $this->Crud, ${$this->Crud->alias()->variableName});

?>