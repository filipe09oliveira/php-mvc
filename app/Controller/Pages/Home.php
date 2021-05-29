<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use \App\Utils\View;

class Home extends Page
{
    /**
     * Método responsável por retornar o conteúdo (view) da nossa home
     *
     * @return string
     */
    public static function getHome()
    {

        $organization = new Organization;

        /** View da Home */
        $content = View::render('pages/home', [
            'name' => $organization->name,
        ]);

        /** Retorna a view da página */
        return parent::getPage('HOME > WDEV', $content);
    }
}
