<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SubTopicsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SubTopicsTable Test Case
 */
class SubTopicsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SubTopicsTable
     */
    protected $SubTopics;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.SubTopics',
        'app.Topics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('SubTopics') ? [] : ['className' => SubTopicsTable::class];
        $this->SubTopics = $this->getTableLocator()->get('SubTopics', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->SubTopics);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SubTopicsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SubTopicsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
