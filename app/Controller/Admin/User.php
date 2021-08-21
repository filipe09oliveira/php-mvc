<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Utils\View;
use App\Model\Entity\User as EntityUser;
use WilliamCosta\DatabaseManager\Pagination;

class User extends Page
{
    /**
     * Método responsável por obter a renderização dos intens de usuários para página
     *
     * @param Request $request
     * @return string
     */
    private static function getUserItems($request, &$obPagination)
    {
        /** Usuários */
        $itens = '';

        /** Quantidade total de registro */
        $quantidadetotal = EntityUser::getUsers(null, null, null, 'COUNT(*) as qtd')->fetchObject()->qtd;

        /** Página atutal */
        $queryParams = $request->getQueryParams();
        $paginaAtual = $queryParams['page'] ?? 1;

        /** Instancia de paginação */
        $obPagination = new Pagination($quantidadetotal, $paginaAtual, 10);

        /** Resultados da página */
        $results = EntityUser::getUsers(null, 'id DESC', $obPagination->getLimit());

        /** Renderiza o item */
        while ($user = $results->fetchObject(EntityUser::class)) {
            $itens .= View::render('admin/modules/users/item', [
                'id' => $user->id,
                'nome' => $user->nome,
                'email' => $user->email,
            ]);
        }

        /** Retorna os usuários */
        return $itens;
    }


    /**
     * Método responsável por renderizar a view de listagem de usuários
     * @param Request $request
     * @return string
     */
    public static function getUsers($request)
    {
        /** Conteúdo da HOME */
        $content = View::render('admin/modules/users/index', [
            'itens' => self::getUserItems($request, $obPagination),
            'pagination' => parent::getPagination($request, $obPagination),
            'status' => self::getStatus($request),
        ]);

        /** Retorna a página completa */
        return parent::getPanel('Usuarios - PHP MVC', $content, 'users');
    }

    /**
     * Método reponsável por retornar o formulário de cadastro de um novo usuários
     * @param Request $request
     * @return string
     */
    public function getNewUser($request)
    {
        /** Conteúdo do form de cadastro de usuários */
        $content = View::render('admin/modules/users/form', [
            'title' => 'Cadastrar usuário',
            'nome' => '',
            'email' => '',
            'status' => ''
        ]);

        /** Retorna a página completa */
        return parent::getPanel('Cadastrar Usuários - PHP MVC', $content, 'users');
    }


    /**
     * Método reponsável por cadastrar um novo usuário
     * @param Request $request
     * @return string
     */
    public function setNewUser($request)
    {
        /** POST VARS */
        $post = $request->getPostVars();

        $email = $post['email'] ?? '';
        $nome = $post['nome'] ?? '';
        $senha = $post['senha'] ?? '';

        /** Valido o e-mail de usuário */
        $userByEmail = EntityUser::getUserByEmail($email);
        if ($userByEmail instanceof EntityUser) {
            /** redireciona o usuário */
            $request->getRouter()->redirect('/admin/users/new?status=duplicated');
        }

        /** Nova instancia de usuários */
        $user = new EntityUser();
        $user->nome = $nome;
        $user->email = $email;
        $user->senha = password_hash($senha, PASSWORD_DEFAULT);
        $user->cadastrar();

        /** redireciona o usuário */
        $request->getRouter()->redirect('/admin/users/' . $user->id . '/edit?status=created');
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
                return Alert::getSuccess('Usuário criado com sucesso!');
                break;
            case 'updated':
                return Alert::getSuccess('Usuário atualizado com sucesso!');
                break;
            case 'deleted':
                return Alert::getSuccess('Usuário excluido com sucesso!');
                break;
            case 'duplicated':
                return Alert::getError('E-mail já está em uso!');
                break;
        }
    }


    /**
     * Método reponsável por retornar o formulário de edição de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function getEditUser($request, $id)
    {
        /** Obtém o usuário do banco de dados */
        $user = EntityUser::getUserById($id);

        /** Valida a instancia */
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        /** Conteúdo do form de edit de usuários */
        $content = View::render('admin/modules/users/form', [
            'title' => 'Editar usuário',
            'nome' => $user->nome,
            'email' => $user->email,
            'status' => self::getStatus($request),

        ]);

        /** Retorna a página completa */
        return parent::getPanel('Editar Usuários - PHP MVC', $content, 'users');
    }


    /**
     * Método reponsável por salvar a atualização de um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function setEditUser($request, $id)
    {
        /** Obtém o usuário do banco de dados */
        $user = EntityUser::getUserById($id);

        /** Valida a instancia */
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        /** POST VARS */
        $post = $request->getPostVars();
        $nome  = $post['nome'] ?? '';
        $email  = $post['email'] ?? '';
        $senha  = $post['senha'] ?? '';

        /** Valida o e-mail do usuário */
        $userByEmail = EntityUser::getUserByEmail($email);
        if ($userByEmail instanceof EntityUser && $userByEmail->id != $id) {
            $request->getRouter()->redirect('/admin/users/'.$id.'/edit?status=duplicated');
        }

        /** Atualiza a instância */
        $user->nome = $nome;
        $user->email = $email;
        $user->senha = password_hash($senha, PASSWORD_DEFAULT);
        $user->atualizar();

        /** redireciona o usuário */
        $request->getRouter()->redirect('/admin/users/' . $user->id . '/edit?status=updated');
    }


    /**
     * Método reponsável por deletar um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function getDeleteUser($request, $id)
    {
        /** Obtém o usuário do banco de dados */
        $user = EntityUser::getUserById($id);

        /** Valida a instancia */
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        /** Conteúdo do form de edit de usuários */
        $content = View::render('admin/modules/users/delete', [
            'nome' => $user->nome,
            'email' => $user->email,
        ]);

        /** Retorna a página completa */
        return parent::getPanel('Excluir Usuário - PHP MVC', $content, 'users');
    }

    /**
     * Método reponsável por deletar um usuário
     * @param Request $request
     * @param integer $id
     * @return string
     */
    public function setDeleteUser($request, $id)
    {
        /** Obtém o usuário do banco de dados */
        $user = EntityUser::getUserById($id);

        /** Valida a instancia */
        if (!$user instanceof EntityUser) {
            $request->getRouter()->redirect('/admin/users');
        }

        /** Exclui o usuário */
        $user->deletar();

        /** redireciona o usuário */
        $request->getRouter()->redirect('/admin/users/' . $user->id . '/edit?status=deleted');
    }
}
