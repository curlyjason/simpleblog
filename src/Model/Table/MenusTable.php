<?php

namespace App\Model\Table;

use App\Model\Entity\Menu;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Bake\Utility\Model\AssociationFilter;

/**
 * Menus Model
 */
class MenusTable extends Table {
	
	protected $_associationFilter;

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		$this->table('blocks');
		$this->displayField('label');
		$this->primaryKey('id');
		$this->belongsToMany('ChildMenus', [
			'through' => 'ChildMenusMenus',
			'foreignKey' => 'menu_id',
			'targetForeignKey' => 'child_menu_id'
		]);
		$this->belongsToMany('ParentMenus', [
			'through' => 'ChildMenusMenus',
			'foreignKey' => 'child_menu_id',
			'targetForeignKey' => 'menu_id'
		]);
		$this->hasMany('MenuSupplements', [
			'foreignKey' => 'child_menu_id',
			'finder' => 'supplements'
		]);
//		debug($this->associations());
	}

	/**
	 * Default validation rules.
	 *
	 * @param \Cake\Validation\Validator $validator Validator instance.
	 * @return \Cake\Validation\Validator
	 */
	public function validationDefault(Validator $validator) {
		$validator
				->add('id', 'valid', ['rule' => 'numeric'])
				->allowEmpty('id', 'create');

		$validator
				->allowEmpty('model');

		$validator
				->allowEmpty('label');

		$validator
				->allowEmpty('controller');

		$validator
				->allowEmpty('action');

		$validator
				->allowEmpty('query');

		$validator
				->allowEmpty('hash');

		return $validator;
	}

	public function findMenus(Query $query, array $options) {
		$query->where([
					'Menus.model' => 'Menus'
				])->contain(['ChildMenus', 'ParentMenus']);
		return $query;
	}
	
//	public function findSupplements(Query $query, array $options) {
//		$query->select('*')->select(['a' => 'a.sequence'])->from('blocks Menus')->join([
//    'a' => [
//        'table' => 'child_menus_menus',
//        'type' => 'LEFT',
//        'conditions' => 'a.child_menu_id = Menus.id'
//    ]
//]);
//		return $query;
//	}
	
    /**
     * Get filtered associations
     * To be mocked...
     *
     * @param \Cake\ORM\Table $table Table
     * @return array associations
     */
    public function filteredAssociations($table)
    {
        if (is_null($this->_associationFilter)) {
            $this->_associationFilter = new AssociationFilter();
        }
        return $this->_associationFilter->filterAssociations($table);
    }

}

