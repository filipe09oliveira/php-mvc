<?php

require __DIR__ . '/includes/app.php';

use App\Http\Request;
use \App\Http\Router;

/** Inicia a Router */
$router = new Router(URL);

/** Inclue as rotas de páginas */
include __DIR__ . '/routes/pages.php';

include __DIR__ . '/functions.php';

/** Impre o response da rota */
$router->run()->sendResponse();
