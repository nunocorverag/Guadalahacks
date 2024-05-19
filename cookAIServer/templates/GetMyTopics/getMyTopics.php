<?php 
        // Example implementation of getMyTopics() logic
        // Assume the user's ID is available in the authentication token
        
        // Retrieve user's ID from authentication token
        $userId = $this->Authentication->getIdentityData('id');

        // Assuming you have a Topics model and a TopicsUsers model to associate users with topics
        $topics = $this->Topics->find()
            ->innerJoinWith('TopicsUsers', function ($q) use ($userId) {
                return $q->where(['TopicsUsers.user_id' => $userId]);
            })
            ->all();

        // Return the topics as JSON response
        $this->set([
            'topics' => $topics,
            '_serialize' => 'topics',
        ]);