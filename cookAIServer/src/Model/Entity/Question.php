<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Question Entity
 *
 * @property int $id
 * @property string $pregunta
 * @property int $dificultad
 * @property int $topic_id
 * @property string $exp_ans
 * @property int $score
 * @property bool $alternative
 *
 * @property \App\Model\Entity\Topic $topic
 */
class Question extends Entity
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
        'pregunta' => true,
        'dificultad' => true,
        'topic_id' => true,
        'exp_ans' => true,
        'score' => true,
        'alternative' => true,
        'topic' => true,
    ];
}
