<?php

namespace App\Controller;

use App\Controller\AppController;
use \App\Model\Table\CrudData;

/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController {

	public $helpers = ['Crud'];
	protected $_associations = NULL;

	/**
	 * Index method
	 *
	 * @return void
	 */
	public function index() {
		$this->set('menus', $this->paginate($this->Menus
								->find('threaded')
								->order(['lft' => 'ASC'])
		));
		$this->set('_serialize', ['menus']);

		$crud_data = new CrudData($this->Menus, ['whitelist' => ['id', 'label', 'controller', 'action']]);
		$this->helpers['Crud'][] = $crud_data;
		$this->set(compact('crud_data'));
		$this->render('/CRUD/index');
	}

	/**
	 * View method
	 *
	 * @param string|null $id Menu id.
	 * @return void
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function view($id = null) {
		$menu = $this->Menus->get($id, [
			'contain' => ['ChildMenus', 'ParentMenus', 'MenuSupplements']
		]);
		$this->set('menu', $menu);
		$this->set('_serialize', ['menu']);
	}

	/**
	 * Add method
	 *
	 * @return void Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$menu = $this->Menus->newEntity();
		if ($this->request->is('post')) {
			$menu = $this->Menus->patchEntity($menu, $this->request->data);
			if ($this->Menus->save($menu)) {
				$this->Flash->success('The menu has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The menu could not be saved. Please, try again.');
			}
		}
		$childMenus = $this->Menus->ChildMenus->find('list', ['limit' => 200]);
		$parentMenus = $this->Menus->ParentMenus->find('list', ['limit' => 200]);
		$this->set(compact('menu', 'childMenus', 'parentMenus'));
		$this->set('_serialize', ['menu']);
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id Menu id.
	 * @return void Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function edit($id = null) {
		$menu = $this->Menus->get($id, [
			'contain' => ['ChildMenus', 'ParentMenus']
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$menu = $this->Menus->patchEntity($menu, $this->request->data);
			if ($this->Menus->save($menu)) {
				$this->Flash->success('The menu has been saved.');
				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error('The menu could not be saved. Please, try again.');
			}
		}
		$childMenus = $this->Menus->ChildMenus->find('list', ['limit' => 200]);
		$parentMenus = $this->Menus->ParentMenus->find('list', ['limit' => 200]);
		$this->set(compact('menu', 'childMenus', 'parentMenus'));
		$this->set('_serialize', ['menu']);
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id Menu id.
	 * @return void Redirects to index.
	 * @throws \Cake\Network\Exception\NotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post', 'delete']);
		$menu = $this->Menus->get($id);
		if ($this->Menus->delete($menu)) {
			$this->Flash->success('The menu has been deleted.');
		} else {
			$this->Flash->error('The menu could not be deleted. Please, try again.');
		}
		return $this->redirect(['action' => 'index']);
	}

	public function move_up($id = null) {
		$this->request->allowMethod(['post', 'put']);
		$menu = $this->Menus->get($id);
		if ($this->Menus->moveUp($menu)) {
			$this->Flash->success('The menu has been moved Up.');
		} else {
			$this->Flash->error('The menu could not be moved up. Please, try again.');
		}
		return $this->redirect($this->referer(['action' => 'index']));
	}

	public function move_down($id = null) {
		$this->request->allowMethod(['post', 'put']);
		$menu = $this->Menus->get($id);
		if ($this->Menus->moveDown($menu)) {
			$this->Flash->success('The menu has been moved down.');
		} else {
			$this->Flash->error('The menu could not be moved down. Please, try again.');
		}
		return $this->redirect($this->referer(['action' => 'index']));
	}

}
