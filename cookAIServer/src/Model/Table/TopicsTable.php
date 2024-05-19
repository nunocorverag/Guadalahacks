<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Topics Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\QuestionsTable&\Cake\ORM\Association\HasMany $Questions
 * @property \App\Model\Table\SubTopicsTable&\Cake\ORM\Association\HasMany $SubTopics
 *
 * @method \App\Model\Entity\Topic newEmptyEntity()
 * @method \App\Model\Entity\Topic newEntity(array $data, array $options = [])
 * @method array<\App\Model\Entity\Topic> newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Topic get(mixed $primaryKey, array|string $finder = 'all', \Psr\SimpleCache\CacheInterface|string|null $cache = null, \Closure|string|null $cacheKey = null, mixed ...$args)
 * @method \App\Model\Entity\Topic findOrCreate($search, ?callable $callback = null, array $options = [])
 * @method \App\Model\Entity\Topic patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method array<\App\Model\Entity\Topic> patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Topic|false save(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method \App\Model\Entity\Topic saveOrFail(\Cake\Datasource\EntityInterface $entity, array $options = [])
 * @method iterable<\App\Model\Entity\Topic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Topic>|false saveMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Topic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Topic> saveManyOrFail(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Topic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Topic>|false deleteMany(iterable $entities, array $options = [])
 * @method iterable<\App\Model\Entity\Topic>|\Cake\Datasource\ResultSetInterface<\App\Model\Entity\Topic> deleteManyOrFail(iterable $entities, array $options = [])
 */
class TopicsTable extends Table
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

        $this->setTable('topics');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Questions', [
            'foreignKey' => 'topic_id',
        ]);
        $this->hasMany('SubTopics', [
            'foreignKey' => 'topic_id',
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
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->numeric('progress')
            ->requirePresence('progress', 'create')
            ->notEmptyString('progress');

        $validator
            ->integer('user_id')
            ->notEmptyString('user_id');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'), ['errorField' => 'user_id']);

        return $rules;
    }
}
