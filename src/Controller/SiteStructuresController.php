<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * SiteStructures Controller
 *
 * @property \App\Model\Table\SiteStructuresTable $SiteStructures
 */
class SiteStructuresController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('siteStructures', $this->paginate($this->SiteStructures));
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
        $siteStructure = $this->SiteStructures->get($id, [
            'contain' => ['ChildSiteStructures']
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
        $siteStructure = $this->SiteStructures->newEntity();
        if ($this->request->is('post')) {
            $siteStructure = $this->SiteStructures->patchEntity($siteStructure, $this->request->data);
            if ($this->SiteStructures->save($siteStructure)) {
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
        $siteStructure = $this->SiteStructures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $siteStructure = $this->SiteStructures->patchEntity($siteStructure, $this->request->data);
            if ($this->SiteStructures->save($siteStructure)) {
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
        $siteStructure = $this->SiteStructures->get($id);
        if ($this->SiteStructures->delete($siteStructure)) {
            $this->Flash->success('The site structure has been deleted.');
        } else {
            $this->Flash->error('The site structure could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
