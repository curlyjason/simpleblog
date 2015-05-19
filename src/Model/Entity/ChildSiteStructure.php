<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SiteStructure Entity.
 */
class SiteStructure extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'model' => true,
    ];
}
