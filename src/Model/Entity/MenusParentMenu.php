<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChildMenusMenu Entity.
 */
class MenusParentMenu extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'block_id' => true,
        'child_block_id' => true,
        'search_keys' => true,
        'render_style' => true,
        'filter' => true,
        'query_limit' => true,
        'block' => true,
        'child_block' => true,
    ];
}
