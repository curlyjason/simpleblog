<?php
namespace App\View\Helper;

use Cake\View\Helper;
use App\View\Helper\CRUD\ToolPackage;
use App\Lib\Collection;
use Cake\Utility\Inflector;
use App\Lib\NameConventions;

class CrudHelper extends Helper
{
	
	public $helpers = ['Html', 'Form'];

	protected $_defaultModelActionPatterns = [
		'index' => [['new' => 'add']],
		'add' => [['list' => 'index']],
		'view' => [['new' => 'add'], ['List' => 'index']],
		'edit' => [['new' => 'add'], ['List' => 'index']]
	];
	
	protected $_defaultAssociationActionPatterns = [
		'index' => [['new' => 'add'], ['List' => 'index']],
		'add' => [['new' => 'add'], ['List' => 'index']],
		'view' => [['new' => 'add'], ['List' => 'index']],
		'edit' => [['new' => 'add'], ['List' => 'index']]
	];

	protected $_defaultRecordActionPatterns = [
//		'index' => ['edit', 'view', 'delete', ['Move up' => 'example']],
		'index' => ['edit', 'view', 'delete'],
		'add' => ['cancel', 'save'],
		'edit' => ['cancel', 'save', 'delete'],
		'view' => ['edit', 'delete']
	];
	
	protected $_ModelActions;
	protected $_AssociationActions;
	protected $_RecordActions;

	public $ModelActions;
	public $AssociationActions;
	public $RecordActions;

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
	
	public $ToolParser;


	/**
	 * Get the tool list for the requested context
	 * 
	 * @param string $grouping 3 groups, 'model', 'associated', 'record'
	 * @param string $alias
	 * @param string $view 
	 * @return ToolPackage
	 */
	public function useActionPattern($grouping, $alias, $view) {
		$alias = ucfirst($alias);
		
		switch (strtolower($grouping)) {
			case 'model':
				$target = 'ModelActions';
				$property = "_$target";
				break;
			case 'association':
				$target = 'AssociationActions';
				$property = "_$target";
				break;
			case 'record':
				$target = 'RecordActions';
				$property = "_$target";
				break;
			default:
				return []; // !!!!!**** This should throw some error. Must be one of the three to be valid
				break;
		}
		$this->$target = $this->$property->load("$alias.$view");
		
		// If we found no actions, check for defaults for this view
		if (empty($this->$target->content)) {
			$tryDefault = $this->$property->load("default.$view");
			If (!empty($tryDefault->content)) {
				$this->$target = $tryDefault;
			}
		}
		return $this->$target;
	}
	
	/**
	 * Make the helper, possibly configuring with CrudData objects
	 * 
	 * @param \Cake\View\View $View
	 * @param array $config An array of CrudData objects
	 */
	public function __construct(\Cake\View\View $View, array $config = array()) {
		parent::__construct($View, $config);
		
		$this->_defaultAlias = new NameConventions(Inflector::pluralize(Inflector::classify($this->request->controller)));
		$this->_CrudData = new Collection();
		$this->_Field = new Collection();
//		debug($config);
//		die;
		$configCrudData = isset($config['crudData']) ? $config['crudData'] : [];
		$configActions =  isset($config['actions']) ? $config['actions'] : [];
		
		foreach ($configCrudData as $crudData) {
			$this->_CrudData->add($crudData->alias()->name, $crudData);
		}
		$this->useCrudData($this->alias('string'));
		
		$this->RecordAction = $this->_View->helpers()->load('RecordAction');
		$this->ModelAction = $this->_View->helpers()->load('ModelAction');
		$this->FieldSetups = new CRUD\FieldSetups;
		$this->setDefaultAssociatedActions();
		
		//set actions supplied by config
		foreach ($configActions as $grouping => $action) {
			//set default values to unset parameters
			$actionData = isset($action['data']) ? $action['data'] : FALSE;
			$actionReplace = isset($action['replace']) ? $action['replace'] : FALSE;
			$this->addActionPattern($grouping, $action['path'], $actionData, $actionReplace);
		}
//		debug($this->_ModelActions);
//		$this->_ModelActions->add('default', ['index'=>['submit']], TRUE);
//		$this->_ModelActions->add('default.edit', ['remove'], TRUE);
//		$this->_ModelActions->add(['Menus'=> ['index'=>['some', 'thing', ['different' => 'now']]]]);
//		$this->_ModelActions->add('Menus.index', ['foo', 'blah', ['hut' => 'cabin']], TRUE);
//		$this->_AssociationActions->add(['Users'=> ['tester'=>['some', 'thing', ['different' => 'now']]]]);
//		debug($this->_ModelActions);
//		debug($this->_AssociationActions);
//		debug($this->_ModelActions->load('Users'));
//		die;
	}
	
	/**
	 * Add an action to the current action pattern set
	 * 
	 * @param string $grouping
	 * @param mixed $path (can be a dot notation string or array)
	 * @param mixed $data (can be array or boolean)
	 * @param boolean $replace
	 * @return type
	 */
	public function addActionPattern($grouping, $path, $data = FALSE, $replace = FALSE) {
		
		switch (strtolower($grouping)) {
			case 'model':
				$target = '_ModelActions';
				break;
			case 'association':
				$target = '_AssociationActions';
				break;
			case 'record':
				$target = '_RecordActions';
				break;
			default:
				return []; // !!!!!**** This should throw some error. Must be one of the three to be valid
				break;
		}
		$this->$target->add($path, $data, $replace);
	}
	
	public function alias($type = 'object') {
		if ($type === 'string') {
			return $this->_defaultAlias->name;
		} else {
			return $this->_defaultAlias;
		}
	}
	
	/**
	 * Set the default action patterns to cover all cake-standard crud settings
	 */
	protected function setDefaultAssociatedActions() {
		$this->_ModelActions = new CRUD\ActionPattern(['default' => $this->_defaultModelActionPatterns]) ;
		$this->_AssociationActions = new CRUD\ActionPattern(['default' => $this->_defaultAssociationActionPatterns]);
		$this->_RecordActions = new CRUD\ActionPattern(['default' => $this->_defaultRecordActionPatterns]);
	}
		
	/**
	 * Make the chosen CrudData and its matching Field object the current ones
	 * 
	 * @param string $alias
	 * @return object CrudData object
	 * @throws \BadMethodCallException
	 */
	public function useCrudData($alias) {
		if ($this->_CrudData->has($alias)) {
			$this->CrudData = $this->_CrudData->load($alias);
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
		if ($this->_Field->has($alias)) {
			$this->Field = $this->_Field->load($alias);
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
//			debug('setting Field');
//			debug($this->_Field);
//			debug($this->alias('string'));
			$this->_Field->add($this->alias('string'), $this->createFieldHandler($this->request->action));
//			debug($this->_Field);
			$this->Field = $this->_Field->load($this->alias('string'));
		}
//		debug($this->Field);
//		debug('did field get set?');die;
		if (!$dot && !isset($this->CrudData)) {
			$this->useCrudData($this->alias('string'));
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
	public function createFieldHandler($action) {
		//WARNING, HACK AHEAD!!!
		//This was put in place because there is no chosen CrudData at this point
		//and we need it to execute the overrideAction
		//Need to find a smoother way to setup the CrudData, instead of having it all setup
		//in $this->output()
		if(!isset($this->CrudData)){
			$this->useCrudData($this->alias('string'));
		}
		//END HACK
		if ($this->CrudData->overrideAction($action)) {
			$action = $this->CrudData->overrideAction($action);
		}
		switch ($action) {
			// the four cake-standard crud setups
			case 'index':
				return new CRUD\Decorator\TableCellDecorator(
					new CRUD\Decorator\BelongsToDecorator(
						new CRUD\CrudFields($this)
					));
				break;
			case 'view':
				return new CRUD\CrudFields($this);
				break;
			case 'edit':
			case 'add':
				return new CRUD\EditFields($this);
				break;

			// your custom setups or the default result if your's isn't found
			default:
				if (method_exists($this->FieldSetups, $action)) {
					return $this->FieldSetups->$action($this);
				} else {
					return new CRUD\Decorator\LabelDecorator(new CRUD\CrudFields($this));
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