<?php

/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use Cake\Controller\Controller;
//use App\Model\Table\CrudData;
//use App\Lib\CrudConfig;
use CrudViews\Controller\AppController as BaseController;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends BaseController {

//	public $helpers = ['Crud'];

//	use CrudConfig;

	public function simpleSearch($action) {
		$this->request->action = $action;
		$alias = $this->modelClass;
		$search = ["$alias.{$this->$alias->displayField()} LIKE" => "%{$this->request->data['search']}%"];
		$this->$action($search);
	}
	
	/**
	 * Setup navigation system for all pages
	 * 
	 */
	protected function loadMainNavigation() {
		$Menus = \Cake\ORM\TableRegistry::get('Menus');
		$this->set('navigators', $Menus->find()->all());
		
		//setup Crud Config
		$this->navigatorsIndex();
	}

	/**
	 * Initialization hook method.
	 *
	 * Use this method to add common initialization code like loading components.
	 *
	 * @return void
	 */
	public function initialize() {
		parent::initialize();
		$this->loadComponent('Flash');
	}

	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
//		$current = strtolower($this->request->controller).ucfirst($this->request->action);
////		debug($current);die;
//		if (method_exists($this->CrudConfig, $current)) {
//			$this->crudData = $this->CrudConfig->$current();
//		} else {
//			$this->crudData = $this->CrudConfig->vanilla($this->{$this->modelClass}, $this->request->action);
//		}
//		array_push($this->_crudData, $this->crudData);
		$this->loadMainNavigation();
	}
	
	public function beforeRender(\Cake\Event\Event $event) {
		parent::beforeRender($event);

//		$this->helpers['Crud'] = [
//			'_CrudData' => $this->_CrudData,
//			'actions' => [
//				'_ModelActions' => $this->_ModelActions,
//				'_AssociationActions' => $this->_AssociationActions,
//				'_RecordActions' => $this->_RecordActions
//			]];

	}

	/** CAKE 2 METHOD THAT MIGHT BE USEFUL TO CONVERT TO CAKE 3
	 * ========================================================
	 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	 * ========================================================
	 * 
	 * Converts POST'ed form data to a model conditions array, suitable for use in a Model::find() call.
	 *
	 * @param array $data POST'ed data organized by model and field
	 * @param string|array $op A string containing an SQL comparison operator, or an array matching operators
	 *        to fields
	 * @param string $bool SQL boolean operator: AND, OR, XOR, etc.
	 * @param boolean $exclusive If true, and $op is an array, fields not included in $op will not be
	 *        included in the returned conditions
	 * @return array An array of model conditions
	 * @deprecated Will be removed in 3.0
	 */
//	public function postConditions($data = array(), $op = null, $bool = 'AND', $exclusive = false) {
//		if (!is_array($data) || empty($data)) {
//			if (!empty($this->request->data)) {
//				$data = $this->request->data;
//			} else {
//				return null;
//			}
//		}
//		$cond = array();
//
//		if ($op === null) {
//			$op = '';
//		}
//
//		$arrayOp = is_array($op);
//		foreach ($data as $model => $fields) {
//			foreach ($fields as $field => $value) {
//				$key = $model . '.' . $field;
//				$fieldOp = $op;
//				if ($arrayOp) {
//					if (array_key_exists($key, $op)) {
//						$fieldOp = $op[$key];
//					} elseif (array_key_exists($field, $op)) {
//						$fieldOp = $op[$field];
//					} else {
//						$fieldOp = false;
//					}
//				}
//				if ($exclusive && $fieldOp === false) {
//					continue;
//				}
//				$fieldOp = strtoupper(trim($fieldOp));
//				if ($fieldOp === 'LIKE') {
//					$key = $key . ' LIKE';
//					$value = '%' . $value . '%';
//				} elseif ($fieldOp && $fieldOp !== '=') {
//					$key = $key . ' ' . $fieldOp;
//				}
//				$cond[$key] = $value;
//			}
//		}
//		if ($bool && strtoupper($bool) !== 'AND') {
//			$cond = array($bool => $cond);
//		}
//		return $cond;
//	}
	
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


}
