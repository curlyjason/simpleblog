<?php
/**
 * This is the recursive LI output call that works with decorated CrudHelper output
 * 
 * The LiDecorator must be on the fields.
 * The value in the variable pointed to by $this->Crud->alias()->variableName 
 *	needs to be an instance of Cake\ORM\ResultSet (standard query result)
 * This assumes a flat list of all records for the list structure
 *		A filter iterator selects the members that go at each level
 *		'filter_property' names the propery that will be tested in the child entity iterator
 *		'filter_match' names the property that provides the testing value in the parent entity
 *		Testing will be ==
 *		You can get all members back flat if you provide a non-existant property name for both
 *		This called helper assumes only one field is in the columns list. Otherwise the ouput 
 *			will be strange, with more than one LI per record.
 * 
 * A common pattern for filter_propery/filter_match would be 'parent_id' and 'id' (that's how 
 * navigation menus work). The child's parent_id would == the parent's id.
 * 
 */
use App\Lib\ChildFilter;

$filter_property = isset($filter_property) ? $filter_property : 'nothing';
$filter_match = isset($filter_match) ? $filter_match : 'nothing';

$collection = new ArrayObject(${$this->Crud->alias()->variableName}->toArray());
$roots = new ChildFilter($collection->getIterator(), null, $filter_property); //root level trees are hard-coded to have no parent

$List = $this->helpers()->load('List', [$this->Crud, 'filter_property' => $filter_property, 'filter_match' => 'id']);

$this->start('nested');
echo $List->outputRecursiveLi($roots, ${$this->Crud->alias()->variableName});
$this->end();

echo preg_replace('/\s*<ul>\s*<\/ul>\s*/', '', $this->fetch('nested'));
