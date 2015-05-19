<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ChildSiteStructuresSiteStructure Entity.
 */
class ChildSiteStructuresSiteStructure extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'site_structure_id' => true,
        'child_site_structure_id' => true,
        'search_keys' => true,
        'render_style' => true,
        'filter' => true,
        'query_limit' => true,
        'site_structure' => true,
        'child_site_structure' => true,
    ];
}
