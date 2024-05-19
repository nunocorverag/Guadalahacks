<?php
declare(strict_types=1);

namespace App\Controller\api;
use App\Controller\AppController;

use Cake\Event\Event;
use PDO;

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

    public function sendTopic()
    {
        $user_id = $this->Authentication->getIdentityData("id");
        $topic = $this->request->getData("topic");
        $res = $this->response->withStatus(400);
    
        $query = "Genera una evaluación inicial del tema " . $topic . " con un total de 15 preguntas divididas en 3 secciones de igual tamaño donde la dificultad sea de facil a intermedio a dificil y específica de que tema se trata cada pregunta. No generes las respuestas a la pregunta.";
    
        $data = [];
        $GPTResp = $this->sendRequestToChatGPT($query);
    
        if ($GPTResp[0] == -1) {
            $data["error"] = $GPTResp[1];
            return $res->withType('application/json')->withStringBody(json_encode($data["error"]));
        }
    
        $topicEntity = $this->fetchTable('Topics')->newEmptyEntity();
        $topicEntity->name = $topic;
        $topicEntity->progress = 0;
        $topicEntity->user_id = $user_id;
    
        $result = $this->fetchTable('Topics')->save($topicEntity);
        if ($result) {
            $res = $this->response->withStatus(200);
            $data['info'] = $result;
            
            // Procesar la respuesta de GPT
            $GPTResponse = $GPTResp[1];
            $preguntas = [];
            
            $secciones = explode("\n\nSección", $GPTResponse);
            foreach ($secciones as $seccion) {
                if (strpos($seccion, 'Fácil') !== false) {
                    $dificultad = "Fácil";
                } elseif (strpos($seccion, 'Intermedio') !== false) {
                    $dificultad = "Intermedio";
                } elseif (strpos($seccion, 'Difícil') !== false) {
                    $dificultad = "Difícil";
                } else {
                    continue;
                }
                
                preg_match_all('/\d+\. (.+)/', $seccion, $matches);
                foreach ($matches[1] as $pregunta) {
                    $preguntas[] = [
                        'dificultad' => $dificultad,
                        'pregunta' => $pregunta
                    ];
                }
            }
    
            $data['GPTResponse'] = $preguntas;
        } else {
            $data["error"] = "Error al guardar en la base de datos";
        }
    
        return $res->withType('application/json')->withStringBody(json_encode($data));
    }

    public function getMyTopics()
    {
        $user_id = $this->Authentication->getIdentityData("id");
        $res = $this->response->withStatus(400);
        $data = [];
    
        // Obtener los cursos del usuario autenticado
        $coursesEntity = $this->fetchTable('Topics')
                        ->find('all')
                        ->where(['user_id' => $user_id]);
    
        if($coursesEntity){
            $data = ['courses' => $coursesEntity];
            $res = $this->response->withStatus(200);
        }
    
        return $res->withType('application/json')->withStringBody(json_encode($data));
    }

    public function evaluateQuestions(){
        $user_id = $this->Authentication->getIdentityData("id");
        $res = $this->response->withStatus(400);
        $data = [];

        $responses = $this->request->getData("responses");

    }
}
