<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TopicTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TopicTable Test Case
 */
class TopicTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TopicTable
     */
    protected $Topic;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.Topic',
        'app.Question',
        'app.SubTopics',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Topic') ? [] : ['className' => TopicTable::class];
        $this->Topic = $this->getTableLocator()->get('Topic', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Topic);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\TopicTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
