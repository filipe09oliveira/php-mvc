<?php

namespace App\Controller\Pages;

use App\Model\Entity\Organization;
use \App\Utils\View;

class About extends Page
{
    /**
     * Método responsável por retornar o conteúdo (view) da nossa págin de sobre
     *
     * @return string
     */
    public static function getAbout()
    {

        $obOrganization = new Organization;

        /** View da Home */
        $content = View::render('pages/about', [
            'name' => $obOrganization->name,
            'description' => $obOrganization->description,
            'site' => $obOrganization->site
        ]);

        /** Retorna a view da página */
        return parent::getPage('SOBRE > PHP MVC', $content);
    }
}
