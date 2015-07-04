<?php
namespace App\View\Helper\CRUD;

use App\View\Helper\CRUD\ColumnOutputInterface;
use Cake\I18n\Number;
//use App\View\Helper\CRUD\FieldSetups;
/**
 * CrudFields base class to establish output for the possible field types
 * 
 * @author dondrake
 */
class CrudColumns implements ColumnOutputInterface {
	
	protected $column_types = [
			'date', 
			'time', 
			'datetime', 
			'timestamp', 
			'boolean',
			'uuid',
			'string',
			'binary',
		
			'biginteger',
			'integer',
			'float',
			'decimal'
	];
	
	/**
	 * The containing helper class and all its properties
	 * 
	 * This is the way of getting all the data knowledge donwn 
	 * into the hole we're digging.
	 *
	 * @var CrudHelper
	 */
	public $helper;
	
	protected $Text;

	protected $Number;

	public function __construct($helper) {
		$this->helper = $helper;
		$this->Number = new Number;
//		if (get_class($config[0]) === 'CrudHelper' || is_subclass_of($config[0], 'CrudHelper')) {
//			$this->_helper = $config[0];
//		}
//		parent::__construct();
	}

	/**
	 * The main call point for output of a field
	 * 
	 * This gives the sub-classes a chance to decide if any special 
	 * process should take place before calling for final output
	 * 
	 * @param string $column
	 * @return string
	 */
	public function output($column) {
		$outputStrategy = $this->helper->columnType($column);
		if (method_exists($this, $outputStrategy)) {
			return $this->$outputStrategy($column);
		} else {
			return $this->helper->FieldSetups->$outputStrategy($column);
		}
	}
	
	protected function integer($column) { 
		return $this->Number->format($this->helper->entity->$column, $this->attribute($column, 'number')); 
	}
	
	protected function biginteger($column) {
		return $this->Number->format($this->helper->entity->$column, $this->attribute($column, 'number'));
	}
	
	protected function decimal($column) {
		return $this->Number->format($this->helper->entity->$column, $this->attribute($column, 'number'));
	}
	
	protected function float($column) {
		return $this->Number->format($this->helper->entity->$column, $this->attribute($column, 'number'));
	}
	
	protected function date($column) {
		return h($this->helper->entity->$column);
	}
	
	protected function time($column) {
		return h($this->helper->entity->$column);
	}
 
	protected function datetime($column) {
		return h($this->helper->entity->$column);
	}
 
	protected function timestamp($column) {
		return h($this->helper->entity->$column);
	}
 
	protected function boolean($column) {
		return h($this->helper->entity->$column  ? __('Yes') : __('No'));
	}

	protected function uuid($column) {
		return h($this->helper->entity->$column);
	}

	protected function string($column) {
		return h($this->helper->entity->$column);
	}

	/**
	 * Still need some kind of output solution for this
	 * 
	 * @param string $column
	 * @return string
	 */
	protected function binary($column) {
		return h('Info about the binary blob');
	}

	protected function text($column) {
		return $this->helper->Text->autoParagraph(h($this->helper->entity->$column));
	}

	protected function input($column, $options = []){
		return $this->helper->Form->input($column, $this->attribute($column, 'input'));
	}
	
	/**
	 * Look up attributes that were set for a column/tag combination
	 * 
	 * CrudData's columns carray attribute information for the output decorators, 
	 * elements and helpers. They're indexed by tag.
	 * 
	 * <pre>
	 * [
	 *	name => [
	 *		attributes => [
	 *			input => [ 'required' => true ] 
	 *		],
	 *	cost => [
	 *		attributes => [
	 *			number => [ 'pattern' => '$ #,###.00' ] 
	 *		]
	 *	]
	 * ]
	 * </pre>
	 * 
	 * @param string $column
	 * @param string $tag
	 * @return type
	 */
	protected function attribute($column, $tag){
		return isset($this->helper->column($column)['attributes'][$tag]) ? 
				$this->helper->column($column)['attributes'][$tag] :
				[];
	}
	
}
