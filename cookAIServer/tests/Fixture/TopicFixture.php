<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * TopicFixture
 */
class TopicFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public string $table = 'topic';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'progress' => 1,
                'userId' => 1,
            ],
        ];
        parent::init();
    }
}
