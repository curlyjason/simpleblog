<?php
namespace App\Model\Table;

use App\Model\Entity\SiteStructure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SiteStructures Model
 */
class SiteStructuresTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('site_structures');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsToMany('ChildSiteStructures', [
            'through' => 'ChildSiteStructuresSiteStructures',
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
            ->add('model', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('model');

        return $validator;
    }
}
