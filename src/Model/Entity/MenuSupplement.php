<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChildMenusMenu Entity.
 */
class MenuSupplement extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'sequence' => true,
    ];
}
