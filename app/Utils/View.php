<?php

namespace App\Utils;

class View
{

    /** Variáveis padrão da View */
    private static $vars = [];

    /**
     * Método reponsável por definir os dados iniciais da calsse
     *
     * @param array $vars
     */
    public static function init($vars = [])
    {
        self::$vars = $vars;
    }

    /**
     * Método responsável por retornar o conteúdo de uma view
     *
     * @param string $iew
     * @return string
     */
    private static function getContentView($view)
    {
        $file = __DIR__ . '/../../resources/view/' . $view . '.php';

        return file_exists($file) ? file_get_contents($file) : '';
    }

    /**
     * Método responsável por retornar o conteúdo renderizado de uma view
     *
     * @param string $view
     * @param array $vars (string/numeric)
     * @return string
     */
    public static function render($view, $vars = [])
    {
        /** Conteúdo da view */
        $contentView = self::getContentView($view);

        /** Merge de variáveis da view */
        $vars = array_merge(self::$vars, $vars);

        /** Descobrir chaves do array de variáveis */
        $keys = array_keys($vars);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        /** Retorna o conteúdo renderizados */
        return str_replace($keys, array_values($vars), $contentView);
    }
}
