<?php
namespace App\Lib;

use App\Model\Table\CrudData;
use Cake\ORM\TableRegistry;
use App\Lib\ActionPattern;

/**
 * CrudConfigs holds the CrudData configurations for output modules
 * 
 * This is a place to move all the configuration code so it can be called 
 * by name rather than cluttering up all the controllers
 *
 * @author dondrake
 */
trait CrudConfig {
	
// <editor-fold defaultstate="collapsed" desc="Properties">
	//Properties
	protected $_CrudData;
	
	protected $_WorkingCrudData;
	
	protected $_ModelActions;
	
	protected $_AssociationActions;
	
	protected $_RecordActions;
	
	public $blacklist = ['created', 'modified', 'id', 'updated'];
		protected $_defaultModelActionPatterns = [
		'index' => [['new' => 'add']],
		'add' => [['list' => 'index']],
		'view' => [['List' => 'index'], 'edit', ['new' => 'add'], 'delete'],
		'edit' => [['List' => 'index'], ['new' => 'add'], 'delete']
	];
	
	protected $_defaultAssociationActionPatterns = [
		'index' => [['List' => 'index'], ['new' => 'add']],
		'add' => [['List' => 'index'], ['new' => 'add']],
		'view' => [['List' => 'index'], ['new' => 'add']],
		'edit' => [['List' => 'index'], ['new' => 'add']]
	];
		protected $_defaultRecordActionPatterns = [
		'index' => ['view', 'edit', 'delete'],
		'add' => ['cancel', 'save'],
		'edit' => ['cancel', 'save'],
		'view' => []
	];

	// </editor-fold>
		
	//Standard Crud Setups
	public function configIndex($alias) {
		$options = $this->vanillaOptions('index');
		$this->configCrudData()->add($alias, $this->buildCrudData($alias, $options));
		$this->configActionPatterns();
	}
	
	public function configView($alias) {
		$options = $this->vanillaOptions('view');
		$options['blacklist'] = [];
		$this->configCrudData()->add($alias, $this->buildCrudData($alias, $options));
		$this->configActionPatterns();
	}
	
	public function configEdit($alias) {
		$options = $this->vanillaOptions('edit');
		$this->configCrudData()->add($alias, $this->buildCrudData($alias, $options));
		$this->configActionPatterns();
	}
	
	public function configAdd($alias) {
		$options = $this->vanillaOptions('add');
		$this->configCrudData()->add($alias, $this->buildCrudData($alias, $options));
		$this->configActionPatterns();
	}
	
	//Customized Crud Setups
	
	public function articlesIndex() {
		$this->configIndex('Articles');
		
		//modify configurations
		$this->configCrudDataOverrides('Articles', 'override', ['text' => 'leadPlus', 'summary' => 'leadPlus']);
	}
	
	/**
	 * Setup custom Crud Config for navigators
	 * 
	 */
	public function navigatorsIndex() {
		$this->configIndex('Navigators');
		
		//modify configurations
		$this->configCrudDataOverrides('Navigators', 'whitelist', ['name']);
		$this->configCrudDataOverrides('Navigators', 'overrideAction', ['index' => 'liLink']);
		
		//set viewVars
		$this->set('filter_property', 'parent_id');
		$this->set('filter_match', 'id');
	}
	
	/**
	 * Setup custom Crud Config for menus
	 * 
	 */
	public function menusIndex() {
		$this->configIndex('Menus');
		
		//modify configurations
		$this->configCrudDataOverrides('Menus', 'blacklist', ['lft', 'rght']);
		$this->configCrudDataOverrides('Menus', 'override', ['parent_id' => 'input']);
		$this->configCrudDataOverrides('Menus', 'attributes', ['parent_id' => [ 'empty' => 'Choose one', 'label' => FALSE ]]);
	}
	
// <editor-fold defaultstate="collapsed" desc="Decomposed Methods">
	
	/**
	 * Common call point to all Crud Data attribute override methods
	 * 
	 * @param string $alias
	 * @param string $property
	 * @param array $override
	 */
	protected function configCrudDataOverrides($alias, $property, $override = [], $replace = FALSE) {
		if(!$this->_WorkingCrudData || $this->_WorkingCrudData->alias('string') != $alias){
			$this->_WorkingCrudData = $this->_CrudData->load($alias);
//			debug($this->_WorkingCrudData);
		}
//		debug($property);
//		debug($override);
		$this->_WorkingCrudData->$property($override, $replace);
//		debug($this->_WorkingCrudData);
	}
	
	/**
	 * Ensure configCrudData contains collection object and return it
	 * 
	 * @return object the configCrudData collection object
	 */
	protected function configCrudData() {
		if(!$this->_CrudData){
			$this->_CrudData = new Collection();
		}
		return $this->_CrudData;
	}
	
	/**
	 * Setup all three default action patterns
	 * 
	 */
	protected function configActionPatterns() {
		$this->configModelActions();
		$this->configAssociationActions();
		$this->configRecordActions();
	}
	
	/**
	 * Ensure configModelActions contains an ActionPattern object and return it
	 * 
	 * @return object the configModelActions collection object
	 */
	protected function configModelActions() {
		if(!$this->_ModelActions){
			$this->_ModelActions = new ActionPattern(['default' => $this->_defaultModelActionPatterns]);
		}
		return $this->_ModelActions;
	}
	
	/**
	 * Ensure configAssociationActions contains an ActionPattern object and return it
	 * 
	 * @return object the configAssociationActions collection object
	 */
	protected function configAssociationActions() {
		if(!$this->_AssociationActions){
			$this->_AssociationActions = new ActionPattern(['default' => $this->_defaultAssociationActionPatterns]);
		}
		return $this->_AssociationActions;
	}
	
	/**
	 * Ensure configRecordActions contains an ActionPattern object and return it
	 * 
	 * @return object the configRecordActions collection object
	 */
	protected function configRecordActions() {
		if(!$this->_RecordActions){
			$this->_RecordActions = new ActionPattern(['default' => $this->_defaultRecordActionPatterns]);
		}
		return $this->_RecordActions;
	}
		
	public function vanillaOptions($action) {
		return [
			'whitelist' => [],
			'blacklist' => $this->blacklist,
			'override' => [],
			'overrideActions' => [],
			'attributes' => [],
			'strategy' => $action
		];
	}

	/**
	 * Return the $alias named table object
	 * 
	 * @param string $alias the model alias
	 */
	protected function loadModelObject($alias) {
		return TableRegistry::get($alias);
	}


	/**
	 * Instantiate new CrudData object
	 * 
	 * @param string $alias
	 * @param array $options
	 * @return CrudData object
	 */
	public function buildCrudData($alias, $options = []) {
		$table = $this->loadModelObject($alias);
		return new CrudData($table, $options);
	}
// </editor-fold>
}
