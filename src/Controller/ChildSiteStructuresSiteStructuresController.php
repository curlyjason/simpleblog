<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ChildSiteStructuresSiteStructures Controller
 *
 * @property \App\Model\Table\ChildStructuresStructuresTable $ChildSiteStructuresSiteStructures
 */
class ChildSiteStructuresSiteStructuresController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['SiteStructures', 'ChildSiteStructures']
        ];
        $this->set('childSiteStructuresSiteStructures', $this->paginate($this->ChildSiteStructuresSiteStructures));
        $this->set('_serialize', ['childSiteStructuresSiteStructures']);
    }

    /**
     * View method
     *
     * @param string|null $id Child Site Structures Site Structure id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $childSiteStructuresSiteStructure = $this->ChildSiteStructuresSiteStructures->get($id, [
            'contain' => ['SiteStructures', 'ChildSiteStructures']
        ]);
        $this->set('childSiteStructuresSiteStructure', $childSiteStructuresSiteStructure);
        $this->set('_serialize', ['childSiteStructuresSiteStructure']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $childSiteStructuresSiteStructure = $this->ChildSiteStructuresSiteStructures->newEntity();
        if ($this->request->is('post')) {
            $childSiteStructuresSiteStructure = $this->ChildSiteStructuresSiteStructures->patchEntity($childSiteStructuresSiteStructure, $this->request->data);
            if ($this->ChildSiteStructuresSiteStructures->save($childSiteStructuresSiteStructure)) {
                $this->Flash->success('The child site structures site structure has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The child site structures site structure could not be saved. Please, try again.');
            }
        }
        $siteStructures = $this->ChildSiteStructuresSiteStructures->SiteStructures->find('list', ['limit' => 200]);
        $childSiteStructures = $this->ChildSiteStructuresSiteStructures->ChildSiteStructures->find('list', ['limit' => 200]);
        $this->set(compact('childSiteStructuresSiteStructure', 'siteStructures', 'childSiteStructures'));
        $this->set('_serialize', ['childSiteStructuresSiteStructure']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Child Site Structures Site Structure id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $childSiteStructuresSiteStructure = $this->ChildSiteStructuresSiteStructures->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $childSiteStructuresSiteStructure = $this->ChildSiteStructuresSiteStructures->patchEntity($childSiteStructuresSiteStructure, $this->request->data);
            if ($this->ChildSiteStructuresSiteStructures->save($childSiteStructuresSiteStructure)) {
                $this->Flash->success('The child site structures site structure has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The child site structures site structure could not be saved. Please, try again.');
            }
        }
        $siteStructures = $this->ChildSiteStructuresSiteStructures->SiteStructures->find('list', ['limit' => 200]);
        $childSiteStructures = $this->ChildSiteStructuresSiteStructures->ChildSiteStructures->find('list', ['limit' => 200]);
        $this->set(compact('childSiteStructuresSiteStructure', 'siteStructures', 'childSiteStructures'));
        $this->set('_serialize', ['childSiteStructuresSiteStructure']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Child Site Structures Site Structure id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $childSiteStructuresSiteStructure = $this->ChildSiteStructuresSiteStructures->get($id);
        if ($this->ChildSiteStructuresSiteStructures->delete($childSiteStructuresSiteStructure)) {
            $this->Flash->success('The child site structures site structure has been deleted.');
        } else {
            $this->Flash->error('The child site structures site structure could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
