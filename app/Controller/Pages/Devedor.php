<?php

namespace App\Controller\Pages;

use App\Http\Request;
use \App\Utils\View;
use \App\Model\Entity\Devedor as EntityDevedor;
use WilliamCosta\DatabaseManager\Pagination;

class DevedorController extends Page
{
    /**
     * Método responsável por obter a renderização dos intens de devedores para página
     *
     * @param Request $request 
     * @return string
     */
    private static function actionGetAllDevedores($request)
    {
        /** Devedores */
        $content = '';

        /** Resultados da página */
        $results = EntityDevedor::getAllDevedores(null, 'id DESC');

        /** Renderiza o item */
        while ($devedor = $results->fetchObject(EntityDevedor::class)) {
            $content .= View::render('pages/devedor/index', [
                'nome' => $devedor->nome,
                'identificacao' => $devedor->identificacao,
                'data_nascimento' => date('d/m/Y', strtotime($devedor->data_nascimento)),
                'titulo' => $devedor->titulo,
                'valor' => $devedor->valor,
                'data_vencimento' => date('d/m/Y', strtotime($devedor->data_vencimento)),
            ]);
        }

        /** Retorna os Devedores */
        return $content;
    }

    /**
     * Método responsável por retornar o conteúdo (view) da view de devedores
     *
     * @param Request $request 
     * @return string
     */
    public static function actionIndex($request)
    {

        /** View de devedores */
        $content = View::render('pages/devedors', [
            'itens' => self::actionGetAllDevedores($request)
        ]);

        /** Retorna a view da página */
        return parent::getPage('Devedores', $content);
    }

    /**
     * Método reponsável por cadastrar um depoimento
     *
     * @param Request $request
     * @return string
     */
    public static function actionCreate($request)
    {
        /** Dados do post */
        $postVars = $request->getPostVars();
        /** Insere um depoimento no banco de dados  */
        $obTestimony = new EntityDevedor;
        $obTestimony->nome = $postVars['nome'];
        $obTestimony->mensagem = $postVars['mensagem'];
        $obTestimony->save();

        /** Retorna a página de listagem de devedores */
        return self::actionIndex($request);
    }
}
