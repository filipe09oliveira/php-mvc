<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;
use \App\Http\Middleware\Queue as MiddlewareQueue;

class Router
{
    /**
     * URL completa do projeto (raiz)
     *
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Índece de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instancia de Request
     *
     * @var Request
     */
    private $request;

    /**
     * Método responsável por iniciar a classe
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->request = new Request($this);
        $this->url = $url;
        $this->setPrefix();
    }

    /**
     * Método responsável por definir o prefixo das rotas
     *
     * @return void
     */
    private function setPrefix()
    {
        /** Informações da URL atual */
        $parseUrl = parse_url($this->url);

        /** Define o prefixo */
        $this->prefix = $parseUrl['path'] ?? '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     *
     * @param string $method
     * @param string $route
     * @param array $params
     */
    private function addRoute($method, $route, $params = [])
    {
        /** Validação dos parâmetros */
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
                continue;
            }
        }

        /** middlewares da rota */
        $params['middlewares'] = $params['middlewares'] ?? [];

        /** Variáveis da rota */
        $params['variables'] = [];

        /** Padrão de validação das variáveis das rotas */
        $patternVariable = '/{(.*?)}/';
        if (preg_match_all($patternVariable, $route, $matches)) {
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }

        /** Padrão de validação da URL */
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        /** Adiciona a rota dentro da calsse */
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Método responsável por definir um rota de GET
     *
     * @param string $route
     * @param array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por definir um rota de POST
     *
     * @param string $route
     * @param array $params
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsável por definir um rota de PUT
     *
     * @param string $route
     * @param array $params
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsável por definir um rota de DELETE
     *
     * @param string $route
     * @param array $params
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    /**
     * Método responsável por retornar a URI desconsiderando o prefixo
     *
     * @return string
     */
    public function getUri()
    {
        /** URI da request */
        $uri = $this->request->getUri();

        /** Fatia a URI com o prefixo */
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        /** Retorna a URI sem prefixo */
        return end($xUri);
    }

    /**
     * Método responsável por retornar os dados da rota atual
     *
     * @return array
     */
    private function getRoute()
    {
        /** URI */
        $uri = $this->getUri();

        /** Method */
        $httpMethod = $this->request->getHttpMethod();

        /** Valida as rotas */
        foreach ($this->routes as $petternRoute => $methods) {
            /** Verifica se a URI bate o padrão */
            if (preg_match($petternRoute, $uri, $matches)) {
                /** Verificar método */
                if (isset($methods[$httpMethod])) {
                    /** Remove a primeira posição */
                    unset($matches[0]);
                    /** Variáveis processadas */
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    /** Retorno dos parâmetros da rota */
                    return $methods[$httpMethod];
                }

                /** Método não premitido */
                throw new Exception("Método não permitido", 405);
            }
        }
        /** URL não encontrada */
        throw new Exception("URL não encontrada", 404);
    }

    /**
     * Método responsável por executar a rota atual
     *
     * @return Response
     */
    public function run()
    {
        try {
            /** Obtém rota atual */
            $route = $this->getRoute();

            /** Verifica o controlador */
            if (!isset($route['controller'])) {
                throw new Exception("A URL não pode ser processada", 500);
            }

            /** Argumentos da função */
            $args = [];

            /** Reflection */
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter) {
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }

            /** Retornar a execução da fila de middlewares */
            return (new MiddlewareQueue($route['middlewares'], $route['controller'], $args))->next($this->request);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }

    /**
     * Método responsável por retornar a URL atual
     * @return string
     */
    public function getCurrentUrl()
    {
        return $this->url . $this->getUri();
    }

    /**
     * Método responsável por redirecionar a URL
     * @param string $route
     */
    public function redirect($route)
    {
        /** URL */
        $url = $this->url.$route;

        /** Executa o redirect */
        header('location: '. $url);
        exit;

    }
}
