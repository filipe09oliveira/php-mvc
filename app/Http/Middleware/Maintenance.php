<?php

namespace App\Http\Middleware;

class Maintenance
{
    /**
     * Método responsável or executar o middleware
     * @param Request $request
     * @param \Closure $next
     * @return Response
     */
    public function handle($request, $next)
    {
        /** Verifica estado de manutenção da página */
        if (getenv('MAINTENANCE') == 'true'){
            throw new \Exception("Página em manutenção. Tente novamente mais tarde.", 200);
        }
        /** Executa o próximo nível do middleware */
        return $next($request);
    }

}