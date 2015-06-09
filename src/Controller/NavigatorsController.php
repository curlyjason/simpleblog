<?php

namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\CrudData;

/**
 * Navigators Controller
 *
 * @property \App\Model\Table\NavigatorsTable $Navigators
 */
class NavigatorsController extends AppController {

	public $helpers = ['Crud'];

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index($search = FALSE) {
		$navigators = $this->Navigators->find();
		if ($search) {
			$navigators->where($search);
		}
		$navigators->contain(['ParentNavigators', 'SubNavigators'])
			->order(['Navigators.lft' => 'ASC']);
		
		$this->set('navigators', $this->paginate($navigators));
		$this->set('parents', $this->Navigators->find('list'));
		$this->set('_serialize', ['navigators']);

		// verify and document config options. 
		// Look into cakes array merge tools (used for class setup) and co-opt if possible
		$this->crudData->whitelist(['name']);
		$this->crudData->overrideAction('index', 'liLink');
//		$this->crudData->whitelist(['type', 'name', 'controller', 'action', 'parent_id']);
//		$this->crudData->override(['parent_id' => 'input']);
//		$this->crudData->attributes(['parent_id' => [ 'empty' => 'Choose one', 'label' => FALSE ]]);
		
//		$this->RecordActions->add('default.index', [['Move Up' => 'move_up'], ['Move Down' => 'move_down']]);
//		$this->ModelActions->add('default.index', ['search']);
		$this->RecordActions->add('default.index', [], TRUE);
		$this->ModelActions->add('default.index', [], TRUE);
		$this->AssociationActions->add('default.index', [], TRUE);

//		$this->render('/CRUD/index');
	}
}
