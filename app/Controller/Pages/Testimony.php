<?php

namespace App\Controller\Pages;

use \App\Utils\View;
use \App\Model\Entity\Testimony as EntityTestimony;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * Método responsável por obter a renderização dos intens de depoimentos para página
     *
     * @param Request $request 
     * @return string
     */
    private static function getTestimonyItems($request)
    {
        /** Depoimentos */
        $itens = '';

        /** Quantidade total de registro */
        $quantidadetotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        /** Página atutal */
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        /** Instancia de paginação */
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 1);

        /** Resultados da página */
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        /** Renderiza o item */
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('pages/testimony/item', [
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/mY H:i:s', strtotime($obTestimony->data))
            ]);
        }

        /** Retorna os depoimentos */
        return $itens;
    }

    /**
     * Método responsável por retornar o conteúdo (view) da view de depoimentos
     *
     * @param Request $request 
     * @return string
     */
    public static function getTestimonies($request)
    {

        /** View de depoimentos */
        $content = View::render('pages/testimonies', [
            'itens' => self::getTestimonyItems($request)
        ]);

        /** Retorna a view da página */
        return parent::getPage('HOME > WDEV', $content);
    }

    /**
     * Método reponsável por cadastrar um depoimento
     *
     * @param Request $request
     * @return string
     */
    public static function insertTestimony($request)
    {
        /** Dados do post */
        $postVars = $request->getPostVars();
        /** Insere um depoimento no banco de dados  */
        $obTestimony = new EntityTestimony;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->cadastrar();

        /** Retorna a página de listagem de depoimentos */
        return self::getTestimonies($request);
    }
}
