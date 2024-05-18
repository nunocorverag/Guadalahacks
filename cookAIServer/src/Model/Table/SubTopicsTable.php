<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SubTopics Model
 *
 * @property \App\Model\Table\TopicTable&\Cake\ORM\Association\BelongsTo $Topic
 *
 * @method \App\Model\Entity\SubTopic newEmptyEntity()
 * @method \App\Model\Entity\SubTopic newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\SubTopic> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SubTopic get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\SubTopic findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\SubTopic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\SubTopic> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SubTopic|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\SubTopic saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\SubTopic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SubTopic>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SubTopic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SubTopic> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SubTopic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SubTopic>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\SubTopic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\SubTopic> deleteManyOrFail(iterable $entities, array $options = [])
 */
class SubTopicsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array<string, mixed> $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sub_topics');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Topic', [
            'foreignKey' => 'topic_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('topic_id')
            ->notEmptyString('topic_id');

        $validator
            ->boolean('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('info')
            ->requirePresence('info', 'create')
            ->notEmptyString('info');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['topic_id'], 'Topic'), ['errorField' => 'topic_id']);

        return $rules;
    }
}
