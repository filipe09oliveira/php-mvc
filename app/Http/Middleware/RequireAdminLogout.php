<?php

namespace App\Http\Middleware;

use App\Session\Admin\Login as SessionAdminLogin;

class RequireAdminLogout
{
    /**
     * Método responsável or executar o middleware
     * @param Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        /** Verifica se usuário está logado */
        if (SessionAdminLogin::isLogged()) {
            $request->getRouter()->redirect('/admin');
        }
        return $next($request);
    }
}