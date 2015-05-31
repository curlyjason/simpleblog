<?php
namespace App\View\Helper;

use Cake\View\Helper;
use App\View\Helper\CRUD\ToolPackage;

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
		'index' => ['edit', 'view', 'delete', ['Move up' => 'example']],
//		'index' => ['edit', 'view', 'delete'],
		'add' => ['cancel', 'save'],
		'edit' => ['cancel', 'save', 'delete'],
		'view' => ['edit', 'delete']
	];
	
	public $RecordAction;

	protected $_nativeModelActionDisplay = TRUE; 
	
	protected $_associatedModelWhitelist;
	
	protected $_associatedModelBlacklist;
	
	/**
	 * The default (assumed) model alias (derived from the current controller)
	 *
	 * @var string
	 */
	protected $_defaultAlias;
	
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
	 * All the Field output-control objects indexed by the alias of the model they serve
	 *
	 * @var array
	 */
	protected $_Field;

	/**
	 * Instance of some CrudField sub-type to do field-vlaue output (possibly wrapped in decorators)
	 * 
	 * CrudField sub-classes will do default 'view' output for all the standard field types 
	 * and EditField sub-classes will do default 'input' generation for all the types
	 * 
	 * Decorators on them must be subclasses of FieldDecorator
	 *
	 * @var CrudField
	 */
	public $Field;
	
	/**
	 * The class that will contain your customer output configurations
	 *
	 * @var object
	 */
	protected $FieldSetups;

	/**
	 * The current entity
	 *
	 * @var Entity
	 */
	public $entity;
	
	/**
	 * Get the tool list for the requested context
	 * 
	 * @param string $grouping 3 groups, 'model', 'associate', 'record'
	 * @param string $action 
	 * @return ToolPackage
	 */
	public function actionPattern($grouping, $action) {
		switch ($grouping) {
			case 'model':
				$property = '_nativeModelActionPatterns';
				break;
			case 'associate':
				$property = '_associatedModelActionPatterns';
				break;
			case 'record':
				$property = '_recordActionPatterns';
				break;
			default:
				return [];
				break;
		}
		if (isset($this->{$property}['index'])) {
			return new ToolPackage($grouping, $action, $this->{$property}['index']);
		} else {
			return [];
		}
	}
	
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
			$this->_defaultAlias = \Cake\Utility\Inflector::pluralize(\Cake\Utility\Inflector::classify($this->request->controller));
		}
		$this->RecordAction = $this->_View->helpers()->load('RecordAction');
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
	 * Add another Field object to the class
	 * 
	 * @param string $alias The name to index the object by. Must match a _CrudData storage key
	 * @param string $action The name of the Field configuration strategy to prepare
	 */
	public function addField($alias, $action) {
		$this->_Field[$alias] = $this->setFieldHandler($action);
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
	 * Remove a Field object from the class
	 * 
	 * @param string $alias 
	 */
	public function removeField($alias) {
		if (isset($this->_Field[$alias])) {
			unset($this->_Field[$alias]);
		}
	}
	
	/**
	 * Make the chosen CrudData and its matching Field object the current ones
	 * 
	 * @param string $alias
	 * @return object CrudData object
	 * @throws \BadMethodCallException
	 */
	public function useCrudData($alias) {
		if (isset($this->_CrudData[$alias])) {
			$this->CrudData = $this->_CrudData[$alias];
			$this->useField($alias);
			return $this->CrudData;
		} else {
			$trace = \Cake\Error\Debugger::trace(['args' => TRUE]);
			\Cake\Log\Log::error("The CrudHelper had no $alias data to use.\n$trace");
			throw new \BadMethodCallException("The helper had no $alias data to use.");
		}
	}
	
	/**
	 * Establish the Field to use for output
	 * 
	 * Make the chosen Field object the current one or 
	 * if the requested one doesn't exist, let the current 
	 * one stand. There will always be one, so no worries.
	 * 
	 * @param string $alias
	 */
	public function useField($alias) {
		if (isset($this->_Field[$alias])) {
			$this->Field = $this->_Field[$alias];
		}
	}
	
	/**
	 * The call to get product for you page. Will also do default setup if it's not done yet
	 * 
	 * The $field had better be one of the indexes in CrudData->column() or 
	 * your going to burn to the ground.
	 * 
	 * Also needs to have CrudData set to one of the _CrudData objects. But if it's not 
	 * the object matching the current controller name will be used.
	 * 
	 * And needs a Field strategy to be selected. But if it's not, the one associated 
	 * with the current CrudData object will be used. Or a default.
	 * 
	 * @param string $field the field name/column name
	 * @return mixed probably a string
	 */
	public function output($field) {
		$dot = stristr($field, '.') ? explode('.', $field) : FALSE;
		
		// we can at least have a fallback output strategy
		if (!$this->Field) {
			$this->addField($this->_defaultAlias, $this->request->action);
		}
		if (!$dot && !isset($this->CrudData)) {
			$this->useCrudData($this->_defaultAlias);
		} elseif ($dot) {
			$field = $dot[1];
			$this->useCrudData($dot[0]);
		}
		return $this->Field->output($field);
	}
	
	/**
	 * Put a field output strategy in place
	 * 
	 * There are two base flavors of output strategy for fields, 
	 * 'view' and 'edit'. Each establishes one default output product for 
	 * every field type. Once a strategy is in place (and CrudData is in place 
	 * to provide the columns data) we can send a field name to the output() 
	 * method and the product for that field type will be returned.
	 * 
	 * Custom setups can be created in two ways. 
	 * 
	 * First the output strategies can be decorated. The decorator may add to the 
	 * output by adding DOM tags to every field (see TableCellDecorator), it may 
	 * perform logic and modify some fields, leaving other untouched (see BelongsToManyDecorator), 
	 * or it may perform other logic and interventions like substituting new content 
	 * in place of, or near some fields.
	 * Decorators should all extend FieldDecorator class.
	 * 
	 * Secondly, non-standard field types can be defined and set on the columns property 
	 * of CrudData through the override() method and property. New sub classes of CrudField 
	 * or EditField can be made that add processing for the new type. The type 'image' is a  
	 * possible example. Normally a field with an image name in it would output as a string. 
	 * An 'image' extension for CrudField would render an image tag. The EditField extension 
	 * would render a file type input. 
	 * 
	 * The cake-standard crud patterns are pre-defined. Methods can be added to the FieldSetup 
	 * class for custom set-ups and the name of the method can be passed in as $action. If the 
	 * requested method isn't found, LabelDecorator/CrudFields will be returned. It will 
	 * output <p><span>Field Name: </span>field-value</p>
	 * 
	 * @param string $action name of the output construction process to use
	 */
	public function setFieldHandler($action) {
		switch ($action) {
			// the four cake-standard crud setups
			case 'index':
				$this->Field = new CRUD\Decorator\TableCellDecorator(
					new CRUD\Decorator\BelongsToDecorator(
						new CRUD\CrudFields($this)
					));
				break;
			case 'view':
				$this->Field = new CRUD\CrudFields($this);
				break;
			case 'edit':
			case 'add':
				$this->Field = new CRUD\EditFields($this);
				break;

			// your custom setups or the default result if your's isn't found
			default:
				if (method_exists($this->FieldSetups, $action)) {
					$this->Field = $this->FieldSetups->$action();
				} else {
					$this->Field = new CRUD\Decorator\LabelDecorator(new CRUD\CrudFields($this));
				}
		}
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