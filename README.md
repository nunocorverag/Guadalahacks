# Guadalahacks
Proyecto guadalahacks - Hackathon Guadalajara 18-050-2024

CookAI es una página web que utiliza una conexión con chatgpt :robot: para poder ofrecerle al usuario planes de estudio personalizados a un bajo y accesible costo :open_mouth: 

## Para ejecutar Cook AI en Windows:
 - Clonar el repositorio y cambiar a la branch de "developing"
 - Descargar [MAMP](https://www.mamp.info/en/downloads/) :mechanical_arm:	
 - Descargar la última versión de [NodeJS](https://nodejs.org/en/download/prebuilt-installer) :knot:	
 - Descargar [Composer](https://getcomposer.org/download/) :bow:	y asignar la versión más nueva de python incluida en la carpeta de bin de MAMP :eyes:
  

  ![image](https://github.com/nunocorverag/Guadalahacks/assets/146213118/cc55b17a-6ed1-488c-a9e8-1b6271093754)

 - En tu terminal, navegar hasta la carpeta de CookAIClient
      * Una vez ahi, ejecutar `npm install` :point_left:	
  - Nuevamente en la terminal, navegar hasta la carpeta de CookAIServer
      * Dentro de esa carpeta, ejecutar `composer update` :point_left:	
  - Abrir la app de MAMP e iniciar los servidores :nerd_face:	:point_up:
  - Desde MAMP, abrir php my admin y cargar la base de datos
  - Dentro de la carpeta de CookAIClient, en la terminal, ejecutar `ng server` :point_left:
  - Entrar al link del localhost que te aparecerá y estarás dentro de la página web :+1:


## ¿Cómo funciona CookAI?
  Utiliza un sistema en el cual, mediante una API, se conecta a chatgpt :robot: para realizar prompts personalizadas	:speaking_head:	:fire:	:fire:			para facilitar el estudio del usuario. :shushing_face:	:deaf_person:	
