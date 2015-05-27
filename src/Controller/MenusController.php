<?php
namespace App\Controller;

use App\Controller\AppController;
use \App\Model\Table\CrudData;
/**
 * Menus Controller
 *
 * @property \App\Model\Table\MenusTable $Menus
 */
class MenusController extends AppController
{
	
	protected $_associations = NULL;

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('menus', $this->paginate($this->Menus->find('menus')));
        $this->set('_serialize', ['menus']);

		$crud_data = new CrudData($this->Menus, ['whitelist' => ['id', 'label', 'controller', 'action']]);
//		$foreignKeys = $this->>Menus->filteredAssociations($this->Menus);
		$this->set(compact('crud_data'));
		debug($crud_data->foreignKeys());
		debug($crud_data->filteredAssociations());
		debug($crud_data->columns());
		die;
//		debug($this->Menus->find('supplements')->execute());
		$this->render('/CRUD/index');
    }

    /**
     * View method
     *
     * @param string|null $id Menu id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $menu = $this->Menus->get($id, [
//            'contain' => ['ChildMenusMenus' => ['ChildMenus']]
            'contain' => ['ChildMenus']
        ]);
        $this->set('menu', $menu);
        $this->set('_serialize', ['menu']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
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
		$this->Menus->whitelist = ['label', 'controller', 'action'];
		$foreignKeys = $this->Menus->foreignKeys();
		$this->_belongsToManyOptions();
		$associations = $this->_associations;
		$columns = $this->Menus->columns();
		$this->set(compact('foreignKeys', 'columns', 'associations'));
        $this->set(compact('menu'));
		$this->render('/CRUD/add');
    }
	
	protected function _belongsToManyOptions(){
		$this->_associations = $this->Menus->filteredAssociations($this->Menus);
		foreach (array_keys($this->_associations['BelongsToMany']) as $alias) {
			${$this->_associations['BelongsToMany'][$alias]['variable']} = $this->Menus->$alias->find('list');
			$this->set($this->_associations['BelongsToMany'][$alias]['variable'], ${$this->_associations['BelongsToMany'][$alias]['variable']});
		}
	}

    /**
     * Edit method
     *
     * @param string|null $id Menu id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $menu = $this->Menus->get($id, [
            'contain' => []
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
		$this->Menus->whitelist = ['label', 'controller', 'action'];
		$foreignKeys = $this->Menus->foreignKeys();
		$this->_belongsToManyOptions();
		$associations = $this->_associations;
		$columns = $this->Menus->columns();
		$this->set(compact('foreignKeys', 'columns', 'associations'));
        $this->set(compact('menu'));
//        $this->set(compact('menu'));
        $this->set('_serialize', ['menu']);
		$this->render('/CRUD/add');
    }

    /**
     * Delete method
     *
     * @param string|null $id Menu id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $menu = $this->Menus->get($id);
        if ($this->Menus->delete($menu)) {
            $this->Flash->success('The menu has been deleted.');
        } else {
            $this->Flash->error('The menu could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
