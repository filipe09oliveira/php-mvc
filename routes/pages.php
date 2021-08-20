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


/** rota Depoimentos */
$router->get('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }
]);
$router->post('/depoimentos', [
    function ($request) {
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }
]);


/** rota Depoimentos */
$router->get('/devedores', [
    function ($request) {
        return new Response(200, Pages\Devedor::actionIndex($request));
    }
]);
$router->post('/devedor', [
    function ($request) {
        return new Response(200, Pages\Devedor::actionCreate($request));
    }
]);
