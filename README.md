# Guadalahacks
Proyecto guadalahacks - Hackathon Guadalajara 18-050-2024

CookAI es una página web que utiliza una conexión con chatgpt para poder ofrecerle al usuario planes de estudio personalizados a un bajo y accesible costo.

## Para ejecutar Cook AI en Windows:
 - Descargar [MAMP](https://www.mamp.info/en/downloads/)
 - Descargar la última versión de [NodeJS](https://nodejs.org/en/download/prebuilt-installer)
 - Descargar [Composer](https://getcomposer.org/download/) y asignar la versión más nueva de python incluida en la carpeta de bin de MAMP
  ![image](https://github.com/nunocorverag/Guadalahacks/assets/146213118/cc55b17a-6ed1-488c-a9e8-1b6271093754)

 - En tu terminal, navegar hasta la carpeta de CookAIClient
      * Una vez ahi, ejecutar `npm install`
  - Nuevamente en la terminal, navegar hasta la carpeta de CookAIServer
      * Dentro de esa carpeta, ejecutar `composer update`
  - Abrir la app de MAMP e iniciar los servidores
  - Dentro de la carpeta de CookAIClient, en la terminal, ejecutar `ng server`


## ¿Cómo funciona CookAI?
  Utiliza un sistema en el cual, mediante una API, se conecta a chatgpt para realizar prompts personalizadas para facilitar el estudio del usuario.
