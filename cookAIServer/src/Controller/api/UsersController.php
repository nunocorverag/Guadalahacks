<?php
declare(strict_types=1);

namespace App\Controller\api;
use App\Controller\AppController;

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
        $topic = $this->request->getData("topic");

        $res = $this->response->withStatus(400);

        $msg = $topic;

        $data = $this->sendRequestToChatGPT($msg);

        if ($data[0] == -1) {
            $data["error"] = $data[1];
            return $res->withType('application/json')->withStringBody(json_encode($data["error"]));
        }

        $res = $this->response->withStatus(200);

        $data["info"] = $data[1];
        return $res->withType('application/json')->withStringBody(json_encode($data["info"]));
    }
}
