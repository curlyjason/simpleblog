<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Trees Controller
 *
 * @property \App\Model\Table\TreesTable $Trees
 */
class TreesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['ParentTrees']
        ];
        $this->set('trees', $this->paginate($this->Trees));
        $this->set('_serialize', ['trees']);
    }

    /**
     * View method
     *
     * @param string|null $id Tree id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tree = $this->Trees->get($id, [
            'contain' => ['ParentTrees']
        ]);
        $this->set('tree', $tree);
        $this->set('_serialize', ['tree']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tree = $this->Trees->newEntity();
        if ($this->request->is('post')) {
            $tree = $this->Trees->patchEntity($tree, $this->request->data);
            if ($this->Trees->save($tree)) {
                $this->Flash->success('The tree has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The tree could not be saved. Please, try again.');
            }
        }
        $parentTrees = $this->Trees->ParentTrees->find('list', ['limit' => 200]);
        $this->set(compact('tree', 'parentTrees'));
        $this->set('_serialize', ['tree']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Tree id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tree = $this->Trees->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tree = $this->Trees->patchEntity($tree, $this->request->data);
            if ($this->Trees->save($tree)) {
                $this->Flash->success('The tree has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The tree could not be saved. Please, try again.');
            }
        }
        $parentTrees = $this->Trees->ParentTrees->find('list', ['limit' => 200]);
        $this->set(compact('tree', 'parentTrees'));
        $this->set('_serialize', ['tree']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Tree id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tree = $this->Trees->get($id);
        if ($this->Trees->delete($tree)) {
            $this->Flash->success('The tree has been deleted.');
        } else {
            $this->Flash->error('The tree could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
