<?php

require __DIR__ . '/vendor/autoload.php';

use \App\Http\Router;
use App\Utils\View;

/** Definir o seu localhost */
define('URL', 'http://mvc.php.localhost');

/** Definir o valor padrão das variáveis */
View::init([
    'URL' => URL,
]);

/** Inicia a Router */
$router = new Router(URL);

/** Inclue as rotas de páginas */
include __DIR__ . '/routes/pages.php';


/** Impre o response da rota */
$router->run()->sendResponse();
