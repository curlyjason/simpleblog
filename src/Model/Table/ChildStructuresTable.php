<?php
namespace App\Model\Table;

use App\Model\Entity\ChildStructure;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SiteStructures Model
 */
class ChildStructuresTable extends StructuresTable
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
        $this->displayField('label');
        $this->primaryKey('id');
        $this->belongsToMany('Structures', [
            'through' => 'ChildStructuresStructures',
        ]);
    }

}
