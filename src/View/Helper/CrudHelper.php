<?php
namespace App\View\Helper;

use Cake\View\Helper;

class CrudHelper extends Helper
{
	
	public $helpers = ['Html', 'Form'];

	protected $_nativeModelActionPatterns = [
		'index' => [['new' => 'add']],
		'add' => [['list' => 'index']],
		'view' => [['new' => 'add'], ['List' => 'index']],
		'edit' => [['new' => 'add'], ['List' => 'index']]
	];
	
	protected $_associatedModelActionPatterns = [
		'index' => [['new' => 'add'], ['List' => 'index']],
		'add' => [['new' => 'add'], ['List' => 'index']],
		'view' => [['new' => 'add'], ['List' => 'index']],
		'edit' => [['new' => 'add'], ['List' => 'index']]
	];

	protected $_recordActionPatterns = [
		'index' => ['edit', 'view', 'delete'],
		'add' => ['cancel', 'save'],
		'edit' => ['cancel', 'save', 'delete'],
		'view' => ['edit', 'delete']
	];
	
	protected $_nativeModelActionDisplay = TRUE;
	
	protected $_associatedModelWhitelist;
	
	protected $_associatedModelBlacklist;
	
	/**
	 * All the CrudData object, indexed by the alias of the model that created them
	 *
	 * @var array
	 */
	protected $_CrudData = [];
	
	/**
	 * The current crud data object
	 *
	 * @var CrudData object
	 */
	public $CrudData;
	
	/**
	 * Instance of some CrudField sub-type to do field-vlaue output
	 * 
	 * CrudField will do default 'view' output for all the standard field types 
	 * and EditField will do default 'input' generation for all the types
	 *
	 * @var CrudField
	 */
	public $Field;
	
	public $entity;
	
	/**
	 * Make the helper, possibly configuring with CrudData objects
	 * 
	 * @param \Cake\View\View $View
	 * @param array $config An array of CrudData objects
	 */
	public function __construct(\Cake\View\View $View, array $config = array()) {
		parent::__construct($View, $config);
		foreach ($config as $CrudDataObject) {
			$this->addCrudData($CrudDataObject);
		}
	}
	
	/**
	 * Add another CrudData object to the class
	 * 
	 * @param \App\Model\Table\CrudData $data
	 */
	public function addCrudData(\App\Model\Table\CrudData $data) {
		$this->_CrudData[$data->alias()->name] = $data;
	}
	
	/**
	 * Remove a CrudData object from the class
	 * 
	 * @param string $alias 
	 */
	public function removeCrudData($alias) {
		if (isset($this->_CrudData[$alias])) {
			unset($this->_CrudData[$alias]);
		}
	}
	
	/**
	 * Make the chosen CrudData object the current one (and return it too)
	 * 
	 * @param string $alias
	 * @return object CrudData object
	 * @throws \BadMethodCallException
	 */
	public function useCrudData($alias) {
		if (isset($this->_CrudData[$alias])) {
			$this->CrudData = $this->_CrudData[$alias];
			return $this->CrudData;
		} else {
			$trace = \Cake\Error\Debugger::trace(['args' => TRUE]);
			\Cake\Log\Log::error("The CrudHelper had no $alias data to use.\n$trace");
			throw new \BadMethodCallException("The helper had no $alias data to use.");
		}
	}
	
	public function output($field) {
		if (!$this->CrudData) {
			$this->useCrudData(ucfirst($this->request->controller));
		}
		if (!$this->Field) {
			$this->setFieldHandler($this->request->action);
		}
		return $this->Field->output($field);
	}
	
	public function setFieldHandler($action) {
		switch ($action) {
			case 'index':
				$this->Field = new CRUD\Decorator\TableCellDecorator(
					new CRUD\Decorator\BelongsToDecorator(
							new CRUD\CrudFields($this)));
				break;
			case 'view':
				$this->Field = new CRUD\CrudFields($this);
				break;
			case 'edit':
			case 'add':
				$this->Field = new CRUD\EditFields($this);
				break;

			default:
				if (method_exists($this, $action)) {
					$this->Field = $this->$action();
				} else {
					$this->Field = new CRUD\Decorator\LabelDecorator(new CRUD\CrudFields($this));
				}
		}
//		return $this->Field->output($field);
	}
	

	/**
	 * var_dump output
	 * 
	 * The list of 'property' names and their values
	 * 
	 * @return array
	 */
	public function __debugInfo() {
		$properties = [
			'_nativeModelActionPatterns', 
			'_associatedModelActionPatterns',
			'_recordActionPatterns',
			'_nativeModelActionDisplay',
			'_associatedModelWhitelist',
			'_associatedModelBlacklist',
			'_CrudData',
			'CrudData'
		];
		foreach ($properties as $name) {
			$properties[$name] = $this->$name;
		}
		return $properties;
	}
	
}