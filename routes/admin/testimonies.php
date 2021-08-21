<?php
use \App\Http\Response;
use \App\Controller\Admin;

/** ROTA DE LISTAGEM DE DEPOIMENTOS */
$router->get('/admin/testimonies', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);

/** ROTA DE CADASTRO DE DEPOIMENTO */
$router->get('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::getNewTestimony($request));
    }
]);

/** ROTA DE CADASTRO DE DEPOIMENTO (POST) */
$router->post('/admin/testimonies/new', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request) {
        return new Response(200, Admin\Testimony::setNewTestimony($request));
    }
]);

/** ROTA DE EDIÇÃO DE UM DEPOIMENTO */
$router->get('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\Testimony::getEditTestimony($request, $id));
    }
]);

/** ROTA DE EDIÇÃO DE UM DEPOIMENTO (POST)*/
$router->post('/admin/testimonies/{id}/edit', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\Testimony::setEditTestimony($request, $id));
    }
]);

/** ROTA DE EXLUSÃO DE UM DEPOIMENTO */
$router->get('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\Testimony::getDeleteTestimony($request, $id));
    }
]);

/** ROTA DE EXLUSÃO DE UM DEPOIMENTO */
$router->post('/admin/testimonies/{id}/delete', [
    'middlewares' => [
        'required-admin-login'
    ],
    function ($request, $id) {
        return new Response(200, Admin\Testimony::setDeleteTestimony($request, $id));
    }
]);