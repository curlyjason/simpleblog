<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ChildMenusMenus Controller
 *
 * @property \App\Model\Table\ChildMenusMenusTable $ChildMenusMenus
 */
class ChildMenusMenusController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Menus', 'ChildMenus']
        ];
        $this->set('childMenusMenus', $this->paginate($this->ChildMenusMenus));
        $this->set('_serialize', ['childMenusMenus']);
    }

    /**
     * View method
     *
     * @param string|null $id Child Menus Menu id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $childMenusMenu = $this->ChildMenusMenus->get($id, [
            'contain' => ['Menus', 'ChildMenus']
        ]);
        $this->set('childMenusMenu', $childMenusMenu);
        $this->set('_serialize', ['childMenusMenu']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $childMenusMenu = $this->ChildMenusMenus->newEntity();
        if ($this->request->is('post')) {
            $childMenusMenu = $this->ChildMenusMenus->patchEntity($childMenusMenu, $this->request->data);
            if ($this->ChildMenusMenus->save($childMenusMenu)) {
                $this->Flash->success('The child menus menu has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The child menus menu could not be saved. Please, try again.');
            }
        }
        $menus = $this->ChildMenusMenus->Menus->find('list', ['limit' => 200]);
        $childMenus = $this->ChildMenusMenus->ChildMenus->find('list', ['limit' => 200]);
        $this->set(compact('childMenusMenu', 'menus', 'childMenus'));
        $this->set('_serialize', ['childMenusMenu']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Child Menus Menu id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $childMenusMenu = $this->ChildMenusMenus->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $childMenusMenu = $this->ChildMenusMenus->patchEntity($childMenusMenu, $this->request->data);
            if ($this->ChildMenusMenus->save($childMenusMenu)) {
                $this->Flash->success('The child menus menu has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The child menus menu could not be saved. Please, try again.');
            }
        }
        $menus = $this->ChildMenusMenus->Menus->find('list', ['limit' => 200]);
        $childMenus = $this->ChildMenusMenus->ChildMenus->find('list', ['limit' => 200]);
        $this->set(compact('childMenusMenu', 'menus', 'childMenus'));
        $this->set('_serialize', ['childMenusMenu']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Child Menus Menu id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $childMenusMenu = $this->ChildMenusMenus->get($id);
        if ($this->ChildMenusMenus->delete($childMenusMenu)) {
            $this->Flash->success('The child menus menu has been deleted.');
        } else {
            $this->Flash->error('The child menus menu could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
