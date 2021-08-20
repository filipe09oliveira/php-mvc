<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Page{

    /**
     * Método reponsável por retornar o conteúdo (view) da estrutura genérica da página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content) {
        return View::render('admin/layout/index', [
            'title' => $title,
            'content' => $content
        ]);
    }
}