<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;
use \DateTime;
use Cake\Controller\Controller;
use Cake\Utility\Hash;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Flash');
    }

    public function sendRequestToChatGPT($msg)
    {
        $apiKey = 'sk-proj-m5aAaGDOB652EqOHuj6FT3BlbkFJFKtC6gAaFs4xFg9KIFUi'; // Reemplaza con tu clave de API de ChatGPT
        $model = 'gpt-3.5-turbo'; // Modelo de lenguaje de ChatGPT
        $url = 'https://api.openai.com/v1/chat/completions';
        $responseData = "";
        // $res = $this->response->withStatus(400);
        
        $data = [
            'model' => $model,
            'messages' => [
                ['role' => 'user', 'content' => $msg]
            ],            
            'max_tokens' => 2000,
            'temperature' => 0.7,
            'stop' => ['\n'],
        ];

        $headers = [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            // Si la solicitud cURL falla, registra el error
            $error = curl_error($ch);
            error_log('cURL error: ' . $error); // Registra el error en el registro de errores del servidor
            $responseData = "Error en la solicitud cURL: " . $error;
            return [-1, $responseData];
        } else {
            // Si la solicitud cURL tiene éxito, procesa la respuesta
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $responseData = json_decode($response, true);

            // if ($httpCode !== 200) {
            //     // Si la API devuelve un código de estado diferente a 200, registra el código de estado y la respuesta
            //     error_log('Respuesta de la API con código de estado ' . $httpCode . ': ' . json_encode($responseData)); // Registra la respuesta en el registro de errores del servidor
            //     $responseData = "La API devolvió un código de estado " . $httpCode;
            // }

            if (isset($responseData['error'])) {
                $responseData = 'Error: ' . $responseData['error']['message'];
                return [-1, $responseData];
            } else {
                // $res = $this->response->withStatus(200);
                $responseData = $responseData['choices'][0]['message']['content'] ?? 'No response content';
            }
        }
        
        curl_close($ch);

        return [0, $responseData];
        // return $res->withType('application/json')->withStringBody(json_encode($responseData));
    }
}