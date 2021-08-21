<?php

namespace App\Controller\Admin;

use App\Utils\View;

class Page
{

    /**
     * Módulos disponíveis no painel
     * @var array
     */
    private static $modules = [
        'home' => [
            'label' => 'Home',
            'link' => URL.'/admin'
        ],

        'testimonies' => [
            'label' => 'Depoimentos',
            'link' => URL.'/admin/testimonies'
        ],

        'users' => [
            'label' => 'Usuários',
            'link' => URL.'/admin/users'
        ],
    ];

    /**
     * Método reponsável por retornar o conteúdo (view) da estrutura genérica da página do painel
     * @param string $title
     * @param string $content
     * @return string
     */
    public static function getPage($title, $content)
    {
        return View::render('admin/layout/index', [
            'title' => $title,
            'content' => $content
        ]);
    }

    /**
     * Método reponsável por renderizar a view do menu do painel
     * @param string $currentModulo
     * @return string
     */
    private static function getMenu($currentModulo)
    {
        /** Links do menu  */
        $links = '';

        /** Intera os módulos */
        foreach (self::$modules as $hash=>$module) {
            $links .= View::render('admin/menu/link', [
                'label' => $module['label'],
                'link' => $module['link'],
                'current' => $hash == $currentModulo ? 'text-danger' : ''
            ]);
        }

        /** Renderiza a view do painel */
        return View::render('admin/menu/box', [
            'links' => $links,
        ]);
    }

    /**
     * Método reponsável por renderizar a view do painel com conteudos dinâmicos
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */
    public static function getPanel($title, $content, $currentModule)
    {
        /** Renderiza a view do painel */
        $contentPanel = View::render('admin/panel', [
            'menu' => self::getMenu($currentModule),
            'content' => $content
        ]);

        /** Retorna a página renderizada */
        return self::getPage($title, $contentPanel);
    }

    public static function getPagination($request, $obPagination)
    {
        /** Páginas */
        $pages = $obPagination->getPages();

        /** Verifica a quantidade de páginas */
        if (count($pages) <= 1) return '';

        /** Link */
        $link = '';

        /** URL atual (sem GETS) */
        $url = $request->getRouter()->getCurrentUrl();

        /** GET */
        $queryParams = $request->getQueryParams();

        /** Renderiza os links */
        foreach ($pages as $page) {
            /** Altera a página */
            $queryParam['page'] = $page['page'];

            /** LINK */
            $link = $url.'?'.http_build_query($queryParam);

            /** VIEW */
            $links .= View::render('admin/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        /** Renderiza box de paginação */
        return View::render('admin/pagination/box', [
            'links' => $links
        ]);
    }
}