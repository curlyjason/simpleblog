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
class ChildMenusTable extends MenusTable
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
        $this->displayField('label');
        $this->primaryKey('id');
		$this->belongsToMany('Menus', [
			'through' => 'ChildMenusMenus'
		]);
    }

}
