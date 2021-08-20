<?php

namespace App\Controller\Admin;

use App\Utils\View;
use App\Model\Entity\User;
use App\Session\Admin\Login as SessionAdminLogin;


class Login extends Page
{

    /**
     * Método responsável por retornar a rendirização da página de login
     * @param Request $request
     * @return string
     */
    public static function getLogin($request, $errorMessage = null)
    {

        /** Conteúdo da página de status */
        $status = !is_null($errorMessage) ? View::render('admin/login/status', [
            'mensagem' => $errorMessage
        ]) : '';

        /** Conteúdo da página de login */
        $content = View::render('admin/login', [
            'status' => $status
        ]);

        /** Retorna á página completa */
        return parent::getPage('Login - PHP MVC', $content);
    }

    /**
     * Método responsável por definir o login do usuário
     * @param Request $request
     */
    public static function setLogin($request)
    {
        /** POST vars */
        $post = $request->getPostVars();
        $email = $post['email'] ?? '';
        $senha = $post['senha'] ?? '';

        /** Buscar o usuário pelo e-mail */
        $user = User::getUserByEmail($email);
        if (!$user instanceof User) {
            return self::getLogin($request, 'E-mail ou senha invalidos');
        }

        /** Verifica a senha do usuário */
        if (!password_verify($senha, $user->senha)) {
            return self::getLogin($request, 'E-mail ou senha invalidos');
        }

        /** Cria sessão de login */
        SessionAdminLogin::login($user);

        /** Redireciona usuário para a HOME do admin */
        $request->getRouter()->redirect('/admin');
    }


    /**
     * Método responsável por deslogar o usuário
     * @param Request $request
     */
    public static function setLogout($request)
    {
        /** Destroy a sessão de login */
        SessionAdminLogin::logout();

        /** Redireciona usuário para a tela de LOGIN */
        $request->getRouter()->redirect('/admin/login');
    }
}
