<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ChildBlocksBlocks Controller
 *
 * @property \App\Model\Table\ChildBlocksBlocksTable $ChildBlocksBlocks
 */
class ChildBlocksBlocksController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Blocks', 'ChildBlocks']
        ];
        $this->set('childBlocksBlocks', $this->paginate($this->ChildBlocksBlocks));
        $this->set('_serialize', ['childBlocksBlocks']);
    }

    /**
     * View method
     *
     * @param string|null $id Child Blocks Block id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $childBlocksBlock = $this->ChildBlocksBlocks->get($id, [
            'contain' => ['Blocks', 'ChildBlocks']
        ]);
        $this->set('childBlocksBlock', $childBlocksBlock);
        $this->set('_serialize', ['childBlocksBlock']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $childBlocksBlock = $this->ChildBlocksBlocks->newEntity();
        if ($this->request->is('post')) {
            $childBlocksBlock = $this->ChildBlocksBlocks->patchEntity($childBlocksBlock, $this->request->data);
            if ($this->ChildBlocksBlocks->save($childBlocksBlock)) {
                $this->Flash->success('The child blocks block has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The child blocks block could not be saved. Please, try again.');
            }
        }
        $blocks = $this->ChildBlocksBlocks->Blocks->find('list', ['limit' => 200]);
        $childBlocks = $this->ChildBlocksBlocks->ChildBlocks->find('list', ['limit' => 200]);
        $this->set(compact('childBlocksBlock', 'blocks', 'childBlocks'));
        $this->set('_serialize', ['childBlocksBlock']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Child Blocks Block id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $childBlocksBlock = $this->ChildBlocksBlocks->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $childBlocksBlock = $this->ChildBlocksBlocks->patchEntity($childBlocksBlock, $this->request->data);
            if ($this->ChildBlocksBlocks->save($childBlocksBlock)) {
                $this->Flash->success('The child blocks block has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The child blocks block could not be saved. Please, try again.');
            }
        }
        $blocks = $this->ChildBlocksBlocks->Blocks->find('list', ['limit' => 200]);
        $childBlocks = $this->ChildBlocksBlocks->ChildBlocks->find('list', ['limit' => 200]);
        $this->set(compact('childBlocksBlock', 'blocks', 'childBlocks'));
        $this->set('_serialize', ['childBlocksBlock']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Child Blocks Block id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $childBlocksBlock = $this->ChildBlocksBlocks->get($id);
        if ($this->ChildBlocksBlocks->delete($childBlocksBlock)) {
            $this->Flash->success('The child blocks block has been deleted.');
        } else {
            $this->Flash->error('The child blocks block could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
