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
            $links .= View::render('pages/pagination/link', [
                'page' => $page['page'],
                'link' => $link,
                'active' => $page['current'] ? 'active' : ''
            ]);
        }

        /** Renderiza box de paginação */
        return View::render('pages/pagination/box', [
            'links' => $links
        ]);
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
