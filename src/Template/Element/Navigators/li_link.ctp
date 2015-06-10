<?php
/**
 * This is the recursive LI output call that works with decorated CrudHelper output
 * 
 * The LiDecorator must be on the fields.
 * The value in the variable pointed to by $this->Crud->alias()->variableName 
 *	needs to be an instance of Cake\ORM\ResultSet (standard query result)
 * This assumes a tree that links on parent_id (though it should take a flat list)
 * 
 */
use App\Lib\ChildFilter;

use Cake\Collection\Collection;

$collection = new ArrayObject(${$this->Crud->alias()->variableName}->toArray());
$roots = new ChildFilter($collection->getIterator(), null);

$List = $this->helpers()->load('List', [$this->Crud]);
echo $List->outputRecursiveLi($roots, ${$this->Crud->alias()->variableName});