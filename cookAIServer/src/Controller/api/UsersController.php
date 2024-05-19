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
        $this->loadComponent('Authentication.Authentication');
    }  

    public function sendTheme()
    {
        $user_id = $this->Authentication->getIdentityData("id");
        $topic = $this->request->getData("topic");
        $res = $this->response->withStatus(400);
        $msg = $topic;

        $data = [];
        $GPTResp = [0, "HOLALA"];
        // $GPTResp = $this->sendRequestToChatGPT($msg);

        if ($GPTResp[0] == -1) {
            $data["error"] = $GPTResp[1];
            return $res->withType('application/json')->withStringBody(json_encode($data["error"]));
        }

        $topic = $this->fetchTable('Topics')->newEmptyEntity();
        // Hay que procesar la topic
        $topic->name = "name";
        $topic->progress = 0;
        $topic->user_id = $user_id;

        $newData = $this->fetchTable('Topics')->save($topic);
        if ($newData) {
            $response = $this->response->withStatus(200);
            $data['info'] = $newData;
            $data['GPTResponse'] = $GPTResp[1];
        }

        var_dump($data);

        return $res->withType('application/json')->withStringBody(json_encode($data));
    }
}
