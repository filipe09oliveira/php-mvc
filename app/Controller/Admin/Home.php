<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Home extends Page
{
    /**
     * Método responsável por renderizar a view de home do painel
     * @param Request $request
     * @return string
     */
    public static function getHome($request)
    {
        /** Conteúdo da HOME */
        $content = View::render('admin/modules/home/index', []);

        /** Retorna a página completa */
        return parent::getPanel('Home - PHP MVC', $content, 'home');
    }
}
