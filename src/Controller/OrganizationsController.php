<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Organizations Controller
 *
 * @property \App\Model\Table\OrganizationsTable $Organizations
 */
class OrganizationsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('organizations', $this->paginate($this->Organizations));
        $this->set('_serialize', ['organizations']);
		$this->crudData->override(['explanation' => 'leadPlus']);
		$this->render('/CRUD/index');
    }

    /**
     * View method
     *
     * @param string|null $id Organization id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $organization = $this->Organizations->get($id, [
            'contain' => ['Addresses']
        ]);
        $this->set('organization', $organization);
        $this->set('_serialize', ['organization']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $organization = $this->Organizations->newEntity();
        if ($this->request->is('post')) {
            $organization = $this->Organizations->patchEntity($organization, $this->request->data);
            if ($this->Organizations->save($organization)) {
                $this->Flash->success('The organization has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The organization could not be saved. Please, try again.');
            }
        }
        $addresses = $this->Organizations->Addresses->find('list', ['limit' => 200]);
        $this->set(compact('organization', 'addresses'));
        $this->set('_serialize', ['organization']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Organization id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $organization = $this->Organizations->get($id, [
            'contain' => ['Addresses']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $organization = $this->Organizations->patchEntity($organization, $this->request->data);
            if ($this->Organizations->save($organization)) {
                $this->Flash->success('The organization has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The organization could not be saved. Please, try again.');
            }
        }
        $addresses = $this->Organizations->Addresses->find('list', ['limit' => 200]);
        $this->set(compact('organization', 'addresses'));
        $this->set('_serialize', ['organization']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Organization id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $organization = $this->Organizations->get($id);
        if ($this->Organizations->delete($organization)) {
            $this->Flash->success('The organization has been deleted.');
        } else {
            $this->Flash->error('The organization could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
