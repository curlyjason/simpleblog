<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ChildStructuresStructuresTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ChildSiteStructuresSiteStructuresTable Test Case
 */
class ChildSiteStructuresSiteStructuresTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.child_site_structures_site_structures',
        'app.site_structures',
        'app.child_site_structures'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ChildSiteStructuresSiteStructures') ? [] : ['className' => 'App\Model\Table\ChildSiteStructuresSiteStructuresTable'];
        $this->ChildSiteStructuresSiteStructures = TableRegistry::get('ChildSiteStructuresSiteStructures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ChildSiteStructuresSiteStructures);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
