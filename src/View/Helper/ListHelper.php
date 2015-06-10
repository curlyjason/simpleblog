<?php
namespace App\View\Helper;

use Cake\View\Helper;
use Cake\Collection\Collection;
use FilterIterator;
use ArrayIterator;
use ArrayObject;
use App\Lib\ChildFilter;

/**
 * ListHelper is a recursive list outputer that works inside the CrudFields decoration system
 * 
 * This helper will send the field to CrudHelper's output method. It should be called through 
 * /Elements/Navigators/li_link.ctp or an equivalent.
 * 
 * The CrudHelper's output method is calling output on some object stored in Field. That object 
 * should be decorated with LiDecorator for this method. That decorator opens the <LI> tag and 
 * this recursive loop wraps them in <UL>s and closes them around any nested nodes. So there is 
 * a lot of coordination going on.
 * 
 * This assumes only one field is in the columns list. Since we loop on columns, if there 
 * are more fields, you'll end up with multiple LIs per record.
 * 
 * @author jasont
 */
class ListHelper extends Helper {
	
	public $Crud;
	public $tabs = 0;
	public $filter_property;
	public $filter_match;
	
	public function __construct(\Cake\View\View $View, array $config = array()) {
		parent::__construct($View, $config);
//		debug($config);die;
		$this->Crud = $config[0];
		$this->filter_property = $config['filter_property'];
		$this->filter_match = $config['filter_match'];
	}

	public function outputRecursiveLi($level, $data) {
		
		echo str_repeat("\t", $this->tabs) . "<ul>\n";
		
		foreach ($level as $index => $value) {
			$this->Crud->entity = $value;
			foreach ($this->Crud->columns() as $column => $type) {
				
				echo str_repeat("\t", $this->tabs+1) . $this->Crud->output($column) . "\n";
				
				$collection = new ArrayObject($data->toArray());
				$children = new ChildFilter($collection->getIterator(), $value->{$this->filter_match}, $this->filter_property);
				$this->tabs++;
				$this->outputRecursiveLi($children, $data);
				
				echo str_repeat("\t", $this->tabs--) . "</li>\n";
			}
		}
		echo str_repeat("\t", $this->tabs) . "</ul>\n";
		return;
	}
}