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

    public function getOneTopic()
    {
        $user_id = $this->Authentication->getIdentityData("id");
        $res = $this->response->withStatus(400);
        $data = [];

        $topic_id = $this->request->getParam("topic_id");

    
        // Obtener los cursos del usuario autenticado
        $courseEntity = $this->fetchTable('Topics')->get($topic_id);
    
        if($courseEntity){
            $data = ['course' => $courseEntity];
            $res = $this->response->withStatus(200);
        }
    
        return $res->withType('application/json')->withStringBody(json_encode($data));
    }

    public function getQuestionsTopic()
    {
        $user_id = $this->Authentication->getIdentityData("id");
        $res = $this->response->withStatus(400);
        $data = [];
    
        $topic_id = $this->request->getParam("topic_id");

        // Obtener los cursos del usuario autenticado
        $questionsEntity = $this->fetchTable('Questions')
                        ->find('all')
                        ->where(['topic_id' => $topic_id]);
    
        if($questionsEntity){
            $data = ['questions' => $questionsEntity];
            $res = $this->response->withStatus(200);
        }
    
        return $res->withType('application/json')->withStringBody(json_encode($data));
    }

    public function evaluateQuestions(){
        $user_id = $this->Authentication->getIdentityData("id");
        $res = $this->response->withStatus(400);
        $data = [];
    
        $topic_id = $this->request->getData("topic_id");
        $question_ids = $this->request->getData("question_ids");
        $responses = $this->request->getData("responses");
    
        $results = []; // Inicializa el arreglo de resultados

        $topicEntity = $this->fetchTable('Topics')->get($topic_id);
        $topic = $topicEntity->name;

        $evaluation_message = "Estoy realizando un repaso del tema de " . $topic . " podrias calificar mis respuestas con respecto a la respuesta esperada:\n";
        
        foreach ($question_ids as $index => $question_id) {
            // Aquí deberías obtener la pregunta y la respuesta esperada de la entidad de preguntas
            $questionEntity = $this->fetchTable('Questions')->findById($question_id)->first();
    
            if ($questionEntity) {
                // Obtener la respuesta proporcionada por el usuario
                $user_response = $responses[$index];
                $expected_response = $questionEntity->exp_ans; // Respuesta esperada
    
                // Construir el mensaje de evaluación para esta pregunta
                $evaluation_message_for_question = "$question_id.-" . $questionEntity->pregunta . "\n";
                $evaluation_message_for_question .= "Respuesta mía: $user_response\n";
                $evaluation_message_for_question .= "Respuesta esperada: $expected_response\n\n";
    
                // Agregar el mensaje de evaluación al arreglo de resultados
                $results[] = $evaluation_message_for_question;
            }
        }
    
        // Concatenar el mensaje de evaluación general con los mensajes de evaluación individuales
        $evaluation_message .= implode("\n", $results);

        $evaluation_message .= "Podrías darme la respuesta siguiendo el siguiente formato\n: 
                                ID de pregunta - Score en una escala del 1 al 100\n";

        // // Enviar el mensaje de evaluación al modelo de IA para recibir la respuesta
        $info = $this->sendRequestToChatGPT($evaluation_message);

        if($info[0] != -1){
            // Procesar la respuesta del modelo
            $evaluation_results = [];
            $lines = explode("\n", $info[1]);
            foreach ($lines as $line) {
                // Separar el id de la pregunta y el score
                $parts = explode("-", $line);
                $question_id = trim($parts[0]);
                $score = trim($parts[1]);
                // Agregar al arreglo de resultados
                $evaluation_results[] = ['id' => $question_id, 'score' => $score];
                $questionEntity = $this->fetchTable('Questions')->get($question_id);
                $questionEntity->score = $score;
                
                $result = $this->fetchTable('Questions')->save($questionEntity);
            }
    
            // Aquí puedes hacer lo que necesites con $evaluation_results
            // Por ejemplo, actualizar la puntuación de las preguntas en la base de datos.
        } else {
            $data["error"] = "Fallo al obtener la información de evaluación";
            return $res->withType('application/json')->withStringBody(json_encode($data));
        }

        $questionsEntity =$this->fetchTable('Questions')->find('all')->where(['topic_id' => $topic_id]);

        $queryTemas = "Necesito que me propongas 8 temas relacionados al tema " . $topic . " con las preguntas que necesito reforzar dada la siguiente evaluacion: ";

         // Inicializar el string para las preguntas y puntajes
        $preguntasPuntajesString = '';

        // Obtener las preguntas y sus puntajes
        $evaluation_results = [];
        foreach ($questionsEntity as $index => $questionEntity) {
            // Obtener la pregunta y su puntaje
            $pregunta = $questionEntity->pregunta;
            $score = $questionEntity->score;
            // Concatenar la pregunta y el puntaje al string, incluyendo el número de pregunta
            $preguntasPuntajesString .= "Pregunta #" . ($index + 1) . ": $pregunta # puntaje obtenido: $score\n";
            // Agregar al arreglo de resultados
            $evaluation_results[] = ['index' => $index + 1, 'pregunta' => $pregunta, 'score' => $score];
        }

        // Concatenar las preguntas y puntajes al mensaje de la consulta
        $queryTemas .= $preguntasPuntajesString;

        $queryTemas .= "Solo regresame los temas que necesito repasar y separalos por numeracion - tema\n";

        $infoTemas = $this->sendRequestToChatGPT($queryTemas);


        if($infoTemas[0] != -1){
            $temas = [];
            $temasString = $infoTemas[1];
            $temasLines = explode("\n", $temasString);
            foreach ($temasLines as $line) {
                $parts = explode("- ", $line);
                if (count($parts) == 2) {
                    $numero = trim($parts[0]);
                    $tema = trim($parts[1]);
                    $temas[$numero] = $tema;
                    $queryExplicarTema = "Necesito que me expliques detalladamente este tema " . $tema;

                    echo($queryExplicarTema);
                    $subTemaInfo = $this->sendRequestToChatGPT($queryExplicarTema);

                    if($subTemaInfo[0] != -1){
                        $subTemaEntity = $this->fetchTable("SubTopics")->newEmptyEntity();
                        $subTemaEntity->name = $tema;
                        $subTemaEntity->topic_id = $topic_id; // Asigna el valor correcto de topic_id
                        echo("Topic id");
                        echo($topic_id);
                        $subTemaEntity->status = 0;
                        var_dump($subTemaEntity);
                        $subTemaEntity->info = $subTemaInfo[1];
                        $resultSubTemaEntity = $this->fetchTable('SubTopics')->save($subTemaEntity);
                    }
                    else {
                        $data["error"] = "Fallo al realizar una query para un subtema";
                        return $res->withType('application/json')->withStringBody(json_encode($data));
                    }
                }
            }
        } else {
            $data["error"] = "Fallo al obtener los temas";
            return $res->withType('application/json')->withStringBody(json_encode($data));
        }

        $subTemaEntity = $this->fetchTable("SubTopics")->find('all')->where(['topic_id' => $topic_id]);

        $res = $this->response->withStatus(200);
        return $res->withType('application/json')->withStringBody(json_encode($subTemaEntity));
    }
}
