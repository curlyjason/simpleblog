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
use App\Model\Table\CrudData;
use App\View\Helper\CRUD\ActionPattern;
use App\Lib\CrudConfig;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	public $crudData;
	public $_crudData = [];
	public $ModelActions;
	public $AssociationActions;
	public $RecordActions;

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
//		'index' => ['edit', 'view', 'delete', ['Move up' => 'example']],
		'index' => ['view', 'edit', 'delete'],
		'add' => ['cancel', 'save'],
		'edit' => ['cancel', 'save'],
		'view' => []
	];
	
	public function simpleSearch($action) {
		$this->request->action = $action;
		$alias = $this->modelClass;
		$search = ["$alias.{$this->$alias->displayField()} LIKE" => "%{$this->request->data['search']}%"];
		$this->$action($search);
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
		$this->CrudConfig = new CrudConfig($this);
	}

	public function beforeFilter(\Cake\Event\Event $event) {
		parent::beforeFilter($event);
		$this->crudData = $this->CrudConfig->vanilla($this->{$this->modelClass}, $this->request->action);
		array_push($this->_crudData, $this->crudData);
		$this->setDefaultActionPatterns();
	}
	
	/**
	 * Set the default action patterns to cover all cake-standard crud settings
	 */
	protected function setDefaultActionPatterns() {
		$this->ModelActions = new ActionPattern(['default' => $this->_defaultModelActionPatterns]) ;
		$this->AssociationActions = new ActionPattern(['default' => $this->_defaultAssociationActionPatterns]);
		$this->RecordActions = new ActionPattern(['default' => $this->_defaultRecordActionPatterns]);
	}
		

	public function beforeRender(\Cake\Event\Event $event) {
		parent::beforeRender($event);

		$this->helpers['Crud'] = [
			'crudData' => $this->_crudData,
			'actions' => [
				'ModelActions' => $this->ModelActions,
				'AssociationActions' => $this->AssociationActions,
				'RecordActions' => $this->RecordActions
			]];

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

}
