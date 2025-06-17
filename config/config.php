<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Definir uma url base
define('BASE_URL','http://localhost/exfemobile/public/');

define('BASE_URL_FOTO', 'https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/uploads/');

//Definir uma api BASE
define('BASE_API','https://agenciatipi02.smpsistema.com.br/devcycle/exfe/public/api/');

//Sistema para carregamento automático das classses geradas
spl_autoload_register(function ($class){

    if (file_exists('../app/controllers/'.$class.'.php')){
        require_once '../app/controllers/'.$class.'.php';
    }
 
    
    if ( file_exists('../rotas/'.$class. '.php')){
        require_once '../rotas/'.$class. '.php';

    }


});