<?php
namespace App\Model\Table;

use App\Model\Entity\Block;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Blocks Model
 */
class BlocksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('blocks');
        $this->displayField('id');
        $this->primaryKey('id');
		$this->belongsToMany('ChildBlocks', [
			'through' => 'ChildBlocksBlocks'
		]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
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
	
	public function findBlocks(Query $query, array $options) {
		$query->where([
			'Blocks.model' => 'Blocks'
		]);
		return $query;
	}

}
