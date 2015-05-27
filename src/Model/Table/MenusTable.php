<?php

namespace App\Model\Table;

use App\Model\Entity\Menu;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Menus Model
 */
class MenusTable extends Table {

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
		]);
		return $query;
	}

}
