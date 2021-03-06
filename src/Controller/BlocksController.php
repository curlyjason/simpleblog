<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Model\Table\CrudData;

/**
 * Blocks Controller
 *
 * @property \App\Model\Table\BlocksTable $Blocks
 */
class BlocksController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('blocks', $this->paginate($this->Blocks->find('blocks')));
        $this->set('_serialize', ['blocks']);
		
		$this->crudData->override(['field' => 'change']);
		$this->crudData->attributes(['field' => ['class' => 'y'],'some' => ['class' => 'y']]);
		$this->crudData->blacklist(['query', 'hash']);
		$this->render('/CRUD/index');
    }

    /**
     * View method
     *
     * @param string|null $id Block id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $block = $this->Blocks->get($id, [
            'contain' => ['ChildBlocks']
        ]);
        $this->set('block', $block);
        $this->set('_serialize', ['block']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $block = $this->Blocks->newEntity();
        if ($this->request->is('post')) {
            $block = $this->Blocks->patchEntity($block, $this->request->data);
            if ($this->Blocks->save($block)) {
                $this->Flash->success('The block has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The block could not be saved. Please, try again.');
            }
        }
        $this->set(compact('block'));
        $this->set('_serialize', ['block']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Block id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $block = $this->Blocks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $block = $this->Blocks->patchEntity($block, $this->request->data);
            if ($this->Blocks->save($block)) {
                $this->Flash->success('The block has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The block could not be saved. Please, try again.');
            }
        }
        $this->set(compact('block'));
//        $this->set('_serialize', ['block']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Block id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $block = $this->Blocks->get($id);
        if ($this->Blocks->delete($block)) {
            $this->Flash->success('The block has been deleted.');
        } else {
            $this->Flash->error('The block could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
