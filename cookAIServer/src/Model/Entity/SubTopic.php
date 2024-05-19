<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SubTopic Entity
 *
 * @property int $id
 * @property string $name
 * @property int|null $topic_id
 * @property bool $status
 * @property string $info
 *
 * @property \App\Model\Entity\Topic $topic
 */
class SubTopic extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'name' => true,
        'topic_id' => true,
        'status' => true,
        'info' => true,
        'topic' => true,
    ];
}
