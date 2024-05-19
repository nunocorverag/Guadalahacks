<?php
declare(strict_types=1);

namespace App\Controller\api;
use App\Controller\AppController;

use Firebase\JWT\JWT;
use Authentication\PasswordHasher\DefaultPasswordHasher;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class AccessController extends AppController
{
    public function initialize(): void
    {
        $this->autoRender=false;
       
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->Authentication->allowUnauthenticated(['test','login','register']);
		$this->fetchTable('Users');

    }  

    public function login()
    {
        $result = $this->Authentication->getResult();
        $user=[];
        $res=[];
        if( $result->isValid() )
        {
            $user = $result->getData();
            $privateKey = file_get_contents(CONFIG .'/jwt.key');
            $payload = [
                'sub' => $user->id,
                'exp' => time()+86400
            ];
            $user = [
                'token' => JWT::encode($payload,$privateKey,'RS256'),
                'userEnt' => $user
            ];
            $res = $this->response->withStatus(200);
        }else{
            $user = [
              'message' => 'invalid user'
            ];
            $res = $this->response->withStatus(401);
        }

        $this->set('user',$user);
        $this->viewBuilder()->setOption('serialize','user');

        return $res->withType('application/json')->withStringBody(json_encode($user));

    }

    public function register(){
        $response = $this->response->withStatus(400);
        $data = ['error' => 'Error al crear la cuenta'];

        $email = $this->request->getData("email");
        $username = $this->request->getData("username");
        $password = $this->request->getData("password");

        $user = $this->fetchTable('Users')->newEmptyEntity();

        $hasher = new DefaultPasswordHasher();
        $hashedPassword = $hasher->hash($password);
     
        $user->email = $email;
        $user->username = $username;
        $user->password = $hashedPassword;
        $newData = $this->fetchTable('Users')->save($user);

        if ($newData) {
            $response = $this->response->withStatus(200);
            $data['info'] = $newData;
        }

        $response = $response->withType('application/json')->withStringBody(json_encode($data));

        return $response;
    }
}
