<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Block Entity.
 */
class Block extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'model' => true,
        'label' => true,
        'controller' => true,
        'action' => true,
        'query' => true,
        'hash' => true,
    ];
}
