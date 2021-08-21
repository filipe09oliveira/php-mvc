<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Model\Entity\Testimony as EntityTestimony;
use App\Utils\View;
use WilliamCosta\DatabaseManager\Pagination;

class Testimony extends Page
{
    /**
     * Método responsável por obter a renderização dos intens de depoimentos para página
     *
     * @param Request $request
     * @return string
     */
    private static function getTestimonyItems($request, &$obPagination)
    {
        /** Depoimentos */
        $itens = '';

        /** Quantidade total de registro */
        $quantidadetotal = EntityTestimony::getTestimonies(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        /** Página atutal */
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        /** Instancia de paginação */
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        /** Resultados da página */
        $results = EntityTestimony::getTestimonies(null, 'id DESC', $obPagination->getLimit());

        /** Renderiza o item */
        while ($obTestimony = $results->fetchObject(EntityTestimony::class)) {
            $itens .= View::render('admin/modules/testimonies/item', [
                'id' => $obTestimony->id,
                'nome' => $obTestimony->nome,
                'mensagem' => $obTestimony->mensagem,
                'data' => date('d/mY H:i:s', strtotime($obTestimony->data))
            ]);
        }

        /** Retorna os depoimentos */
        return $itens;
    }


    /**
     * Método responsável por renderizar a view de listagem de depoimentos
     * @param Request $request
     * @return string
     */
    public static function getTestimonies($request)
    {
        /** Conteúdo da HOME */
        $content = View::render('admin/modules/testimonies/index', [
            'itens' => self::getTestimonyItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request),
        ]);

        /** Retorna a página completa */
        return parent::getPanel('Depoimentos - PHP MVC', $content, 'testimonies');
    }

    /**
     * Método reponsável por retornar o formulário de cadastro de um novo depoimento
     * @param Request $request
     * @return string
     */
    public function getNewTestimony($request)
    {
        /** Conteúdo do form de cadastro de depoimentos */
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Cadastrar depoimento',
            'nome' => '',
            'mensagem' => '',
            'status' => ''
        ]);

        /** Retorna a página completa */
        return parent::getPanel('Cadastrar Depoimentos - PHP MVC', $content, 'testimonies');
    }


    /**
     * Método reponsável por cadastrar um novo depoimento
     * @param Request $request
     * @return string
     */
    public function setNewTestimony($request)
    {
        /** POST VARS */
        $post = $request->getPostVars();

        /** Nova instancia de depoimento */
        $testimony = new EntityTestimony();
        $testimony->nome = $post['nome'] ?? '';
        $testimony->mensagem = $post['mensagem'] ?? '';
        $testimony->cadastrar();

        /** redireciona o usuário */
        $request->getRouter()->redirect('/admin/testimonies/' . $testimony->id . '/edit?status=created');
    }

    /**
     * Método reponsável por restornar mensagem de status
     * @param Request $request
     * @return string
     */
    private static function getStatus($request)
    {
        /** Query Params */
        $queryParams = $request->getQueryParams();
        if (!isset($queryParams['status'])) return '';

        switch ($queryParams['status']) {
            case 'created':
                return Alert::getSuccess('Deposimento criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Deposimento atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Deposimento excluido com sucesso!');
                break;
        }
    }


    /**
     * Método reponsável por retornar o formulário de edição de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function getEditTestimony($request, $id)
    {
        /** Obtém o depoimento do banco de dados */
        $testimony = EntityTestimony::getTestimonyById($id);

        /** Valida a instancia */
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        /** Conteúdo do form de edit de depoimentos */
        $content = View::render('admin/modules/testimonies/form', [
            'title' => 'Editar depoimento',
            'nome' => $testimony->nome,
            'mensagem' => $testimony->mensagem,
            'status' => self::getStatus($request),

        ]);

        /** Retorna a página completa */
        return parent::getPanel('Editar Depoimentos - PHP MVC', $content, 'testimonies');
    }


    /**
     * Método reponsável por salvar a atualização de um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function setEditTestimony($request, $id)
    {
        /** Obtém o depoimento do banco de dados */
        $testimony = EntityTestimony::getTestimonyById($id);

        /** Valida a instancia */
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        /** POST VARS */
        $post = $request->getPostVars();

        /** Atualiza a instância */
        $testimony->nome = $post['nome'] ?? $testimony->nome;
        $testimony->mensagem = $post['mensagem'] ?? $testimony->mensagem;
        $testimony->atualizar();

        /** redireciona o usuário */
        $request->getRouter()->redirect('/admin/testimonies/' . $testimony->id . '/edit?status=updated');
    }


    /**
     * Método reponsável por deletar um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function getDeleteTestimony($request, $id)
    {
        /** Obtém o depoimento do banco de dados */
        $testimony = EntityTestimony::getTestimonyById($id);

        /** Valida a instancia */
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        /** Conteúdo do form de edit de depoimentos */
        $content = View::render('admin/modules/testimonies/delete', [
            'nome' => $testimony->nome,
            'mensagem' => $testimony->mensagem,
        ]);

        /** Retorna a página completa */
        return parent::getPanel('Excluir Depoimentos - PHP MVC', $content, 'testimonies');
    }

    /**
     * Método reponsável por deletar um depoimento
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function setDeleteTestimony($request, $id)
    {
        /** Obtém o depoimento do banco de dados */
        $testimony = EntityTestimony::getTestimonyById($id);

        /** Valida a instancia */
        if (!$testimony instanceof EntityTestimony) {
            $request->getRouter()->redirect('/admin/testimonies');
        }

        /** Exclui o depoimento */
        $testimony->deletar();

        /** redireciona o usuário */
        $request->getRouter()->redirect('/admin/testimonies/' . $testimony->id . '/edit?status=deleted');
    }
}
