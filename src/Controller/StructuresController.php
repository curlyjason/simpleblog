<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Structures Controller
 *
 * @property \App\Model\Table\StructuresTable $Structures
 */
class StructuresController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('siteStructures', $this->paginate($this->Structures));
        $this->set('_serialize', ['siteStructures']);
    }

    /**
     * View method
     *
     * @param string|null $id Site Structure id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $siteStructure = $this->Structures->get($id, [
            'contain' => ['ChildStructures']
        ]);
        $this->set('siteStructure', $siteStructure);
        $this->set('_serialize', ['siteStructure']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $siteStructure = $this->Structures->newEntity();
        if ($this->request->is('post')) {
            $siteStructure = $this->Structures->patchEntity($siteStructure, $this->request->data);
            if ($this->Structures->save($siteStructure)) {
                $this->Flash->success('The site structure has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The site structure could not be saved. Please, try again.');
            }
        }
        $this->set(compact('siteStructure'));
        $this->set('_serialize', ['siteStructure']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Site Structure id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $siteStructure = $this->Structures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $siteStructure = $this->Structures->patchEntity($siteStructure, $this->request->data);
            if ($this->Structures->save($siteStructure)) {
                $this->Flash->success('The site structure has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The site structure could not be saved. Please, try again.');
            }
        }
        $this->set(compact('siteStructure'));
        $this->set('_serialize', ['siteStructure']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Site Structure id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $siteStructure = $this->Structures->get($id);
        if ($this->Structures->delete($siteStructure)) {
            $this->Flash->success('The site structure has been deleted.');
        } else {
            $this->Flash->error('The site structure could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
