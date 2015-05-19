<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChildMenusMenu Entity.
 */
class ChildMenusMenu extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'menu_id' => true,
        'child_menu_id' => true,
        'menu' => true,
        'child_menu' => true,
    ];
}
