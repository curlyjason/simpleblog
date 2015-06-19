<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Addresses Controller
 *
 * @property \App\Model\Table\AddressesTable $Addresses
 */
class AddressesController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Users']
        ];
        $this->set('addresses', $this->paginate($this->Addresses));
        $this->set('_serialize', ['addresses']);
		$this->crudData->override(['many_words' => 'leadPlus']);
		$this->render('/CRUD/index');
    }

    /**
     * View method
     *
     * @param string|null $id Address id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $address = $this->Addresses->get($id, [
            'contain' => ['Users', 'Organizations']
        ]);
        $this->set('address', $address);
        $this->set('_serialize', ['address']);
		$this->crudData->blacklist(FALSE);
//		$this->crudData->blacklist(['many_words']);
		$this->render('/CRUD/view');
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $address = $this->Addresses->newEntity();
        if ($this->request->is('post')) {
            $address = $this->Addresses->patchEntity($address, $this->request->data);
            if ($this->Addresses->save($address)) {
                $this->Flash->success('The address has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The address could not be saved. Please, try again.');
            }
        }
        $users = $this->Addresses->Users->find('list', ['limit' => 200]);
        $organizations = $this->Addresses->Organizations->find('list', ['limit' => 200]);
        $this->set(compact('address', 'users', 'organizations'));
        $this->set('_serialize', ['address']);
		$this->render('/CRUD/add');
    }

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $address = $this->Addresses->get($id, [
            'contain' => ['Organizations']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $address = $this->Addresses->patchEntity($address, $this->request->data);
            if ($this->Addresses->save($address)) {
                $this->Flash->success('The address has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The address could not be saved. Please, try again.');
            }
        }
        $users = $this->Addresses->Users->find('list', ['limit' => 200]);
        $organizations = $this->Addresses->Organizations->find('list', ['limit' => 200]);
        $this->set(compact('address', 'users', 'organizations'));
        $this->set('_serialize', ['address']);
		$this->render('/CRUD/edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id Address id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $address = $this->Addresses->get($id);
        if ($this->Addresses->delete($address)) {
            $this->Flash->success('The address has been deleted.');
        } else {
            $this->Flash->error('The address could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
