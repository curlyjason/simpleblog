<?php
namespace App\Model\Table;

use App\Model\Entity\ChildBlocksBlock;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ChildBlocksBlocks Model
 */
class ChildBlocksBlocksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('child_blocks_blocks');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
        $this->belongsTo('Blocks', [
            'foreignKey' => 'block_id'
        ]);
        $this->belongsTo('ChildBlocks', [
            'foreignKey' => 'child_block_id'
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
            ->allowEmpty('search_keys');
            
        $validator
            ->allowEmpty('render_style');
            
        $validator
            ->allowEmpty('filter');
            
        $validator
            ->add('query_limit', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('query_limit');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['block_id'], 'Blocks'));
        $rules->add($rules->existsIn(['child_block_id'], 'ChildBlocks'));
        return $rules;
    }
}
