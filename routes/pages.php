<?php

use \App\Http\Response;
use \App\Controller\Pages;

/** rota home */
$router->get('/', [
    function () {
        return new Response(200, Pages\Home::getHome());
    }
]);


/** rota sobre */
$router->get('/sobre', [
    function () {
        return new Response(200, Pages\About::getAbout());
    }
]);


/** rota Dinâmica */
$router->get('/pagina/{idPagina}/{acao}', [
    function ($idPagina, $acao) {
        return new Response(200, 'Página ' . $idPagina . ' - ' . $acao);
    }
]);
