<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tree Entity.
 */
class Tree extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'parent_tree_id' => true,
        'name' => true,
        'parent_tree' => true,
    ];
}
