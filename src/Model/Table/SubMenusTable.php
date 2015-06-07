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
class SubMenusTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
//        $this->table('blocks');
//        $this->displayField('label');
//        $this->primaryKey('id');
//		$this->belongsTo('Menus', [
//			'primaryKey' => 'parent_id',
//			'foreignKey' => 'id'
//		]);
    }

}
