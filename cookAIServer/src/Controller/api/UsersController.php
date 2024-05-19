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
    
        $query = "Genera una evaluación inicial del tema. " . $topic . " con un total de 15 preguntas divididas en 3 secciones de igual tamaño donde la dificultad sea de fácil a intermedio a difícil y específica de qué tema se trata cada pregunta. A su vez asegúrate de agregar una respuesta esperada a cada pregunta. Devuélveme el siguiente formato: 
            Sección Tipo
            1.- Pregunta
            Respuesta esperada
            Así hasta haber generado las 3 secciones de fácil, intermedio, difícil con 5 preguntas cada una.";
    
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
            
            $secciones = preg_split('/\n\nSección/', $GPTResponse, -1, PREG_SPLIT_NO_EMPTY);
            foreach ($secciones as $seccion) {
                $lines = explode("\n", trim($seccion));
                $dificultad_line = trim(array_shift($lines));
    
                // Mapear la dificultad a solo "Fácil", "Intermedio" o "Difícil"
                if (stripos($dificultad_line, 'Fácil') !== false) {
                    $dificultad = 'Fácil';
                } elseif (stripos($dificultad_line, 'Intermedio') !== false) {
                    $dificultad = 'Intermedio';
                } elseif (stripos($dificultad_line, 'Difícil') !== false) {
                    $dificultad = 'Difícil';
                } else {
                    continue; // Saltar secciones que no coincidan con las dificultades esperadas
                }
    
                foreach ($lines as $index => $line) {
                    if (preg_match('/^\d+\.- (.+)$/', $line, $pregunta_match)) {
                        $pregunta = $pregunta_match[1];
                        $respuesta_esperada = trim($lines[$index + 1] ?? '');
                        if (strpos($respuesta_esperada, 'Respuesta esperada: ') === 0) {
                            $respuesta_esperada = substr($respuesta_esperada, 18);
                        }
                        $preguntas[] = [
                            'dificultad' => $dificultad,
                            'pregunta' => $pregunta,
                            'respuesta_esperada' => $respuesta_esperada
                        ];
                
                        // Crear la entidad de pregunta y guardarla en la base de datos
                        $preguntaEntity = $this->fetchTable('Questions')->newEmptyEntity();
                        $preguntaEntity->pregunta = $pregunta;
                        // Asignar el ID del tema a la pregunta
                        $preguntaEntity->topic_id = $topicEntity->id;
                        // Mapear la dificultad a valores numéricos
                        switch ($dificultad) {
                            case 'Fácil':
                                $preguntaEntity->dificultad = 1;
                                break;
                            case 'Intermedio':
                                $preguntaEntity->dificultad = 2;
                                break;
                            case 'Difícil':
                                $preguntaEntity->dificultad = 3;
                                break;
                        }
                        $preguntaEntity->exp_ans = $respuesta_esperada;
                        $preguntaEntity->score = 0;
                        $preguntaEntity->alternative = 0;
                        // Guardar la entidad de pregunta en la base de datos
                        $this->fetchTable('Questions')->save($preguntaEntity);
                    }
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

        $question_ids = $this->request->getData("responses");
        $responses = $this->request->getData("responses");

        foreach ($question_ids as $index => $question_id) {
            // Aquí deberías obtener la pregunta y la respuesta esperada de la entidad de preguntas
            $questionEntity = $this->fetchTable('Questions')->findById($question_id)->first();
    
            if ($questionEntity) {
                // Obtener la respuesta proporcionada por el usuario
                $user_response_key = "response_$question_id";
                $user_response = $responses[$index];
    
                // Construir el resultado para esta pregunta
                $result = [
                    'question_id' => $questionEntity,
                    'question' => $questionEntity->pregunta, // Ajusta el nombre del campo según tu entidad de preguntas
                    'user_response' => $user_response,
                    'expected_response' => $questionEntity->exp_ans // Ajusta el nombre del campo según tu entidad de preguntas
                ];
    
                // Agregar el resultado al arreglo de resultados
                $results[] = $result;
            }
        }
        $data = $results;

        $res = $this->response->withStatus(200);

        return $res->withType('application/json')->withStringBody(json_encode($data));

        
    }
}
