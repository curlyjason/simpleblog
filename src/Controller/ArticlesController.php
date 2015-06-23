<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Lib\Markdown;

/**
 * Articles Controller
 *
 * @property \App\Model\Table\ArticlesTable $Articles
 */
class ArticlesController extends AppController
{
	public $helpers = ['Crud'];

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('articles', $this->paginate($this->Articles));
        $this->set('_serialize', ['articles']);
		$this->articlesIndex();
//		$this->_CrudData->override(['text' => 'leadPlus', 'summary' => 'leadPlus']);
		$this->render('/CRUD/index');
    }

    /**
     * View method
     *
     * @param string|null $id Article id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => ['Images']
        ]);
        $this->set('article', $article);
        $this->set('_serialize', ['article']);
//		$this->render('/CRUD/view');
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $article = $this->Articles->newEntity();
        if ($this->request->is('post')) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success('The article has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The article could not be saved. Please, try again.');
            }
        }
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
		$this->render('/CRUD/add');
    }

    /**
     * Edit method
     *
     * @param string|null $id Article id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $article = $this->Articles->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $article = $this->Articles->patchEntity($article, $this->request->data);
            if ($this->Articles->save($article)) {
                $this->Flash->success('The article has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The article could not be saved. Please, try again.');
            }
        }
        $this->set(compact('article'));
        $this->set('_serialize', ['article']);
		$this->render('/CRUD/edit');
    }

    /**
     * Delete method
     *
     * @param string|null $id Article id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $article = $this->Articles->get($id);
        if ($this->Articles->delete($article)) {
            $this->Flash->success('The article has been deleted.');
        } else {
            $this->Flash->error('The article could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
	
	public function summaries() {
		$this->set('articles', $this->paginate($this->Articles));
		$this->crudData->whitelist(['title']);
		
//		$Menus = \Cake\ORM\TableRegistry::get('Menus');
//		$this->set('navigators', $Menus->find()->all());
//		
//		// ----------------------
//		array_push($this->_crudData, $this->CrudConfig->navigatorIndex());
//		// -----------------------
		$this->RecordActions->add('Navigators.summaries', ['edit']);
		
		$this->set('Markdown', new Markdown());
	}
}
