<?php
namespace App\Controller;

use App\Controller\AppController;

class LoginController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        
        // Allow all origins
        $this->response = $this->response->cors($this->request)
            ->allowOrigin(['*'])
            ->allowMethods(['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'])
            ->allowHeaders(['X-CSRF-Token'])
            ->allowCredentials()
            ->exposeHeaders(['Link'])
            ->maxAge(300)
            ->build();
    }

    public function index()
    {
        if ($this->request->is('post')) {
            $data = $this->request->getData(); // Get POST data
            
            // Assuming you have a User model
            $user = $this->Users->findByEmail($data['email'])->first();

            // Check if user exists and password matches
            if ($user && password_verify($data['password'], $user->password)) {
                // Login successful
                // You can set authentication tokens or session variables here
                $this->set([
                    'message' => 'Login successful',
                    'user' => $user,
                    '_serialize' => ['message', 'user']
                ]);
            } else {
                // Login failed
                $this->response = $this->response->withStatus(401); // Unauthorized status code
                $this->set([
                    'error' => 'Invalid email or password',
                    '_serialize' => ['error']
                ]);
            }
        } else {
            // Return an error for non-POST requests
            $this->response = $this->response->withStatus(405); // Method Not Allowed status code
            $this->set([
                'error' => 'Method not allowed',
                '_serialize' => ['error']
            ]);
        }
    }
}