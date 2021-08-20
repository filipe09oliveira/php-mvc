<?php

namespace App\Controller\Pages;

use \App\Utils\View;

class Page
{


    /**
     * Responsável por renderizar o topo da página
     *
     * @return string
     */
    private static function getHeader()
    {
        return View::render('pages/layout/header');
    }

    /**
     * Responsável por renderizar o footer da página
     *
     * @return string
     */
    private static function getFooter()
    {
        return View::render('pages/layout/footer');
    }

    /**
     * Método responsável por retornar o conteúdo (view) da nossa pagina generica
     *
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('pages/layout/index', [
            'title' => $title,
            'header' => self::getHeader(),
            'content' => $content,
            'footer' => self::getFooter(),
        ]);
    }
}
