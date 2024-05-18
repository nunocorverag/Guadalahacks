<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        $this->autoRender=false;
       
        parent::initialize();
    }  

    public function sendTheme()
    {
        $msg = $this->request->getData("msg");

        $res = $this->response->withStatus(400);

        $data = $this->sendRequestToChatGPT($msg);

        if($data == -1){
            return $res->withType('application/json')->withStringBody(json_encode("Error al conectar con ChatGPT"));
        }

        $res = $this->response->withStatus(200);

        return $res->withType('application/json')->withStringBody(json_encode($data));
    }
}
