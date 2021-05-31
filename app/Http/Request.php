<?php

namespace App\Http;

class Request
{
    /**
     * Instancia do router
     *
     * @var Router
     */
    private $router;

    /**
     * Método HTTP da requisição
     *
     * @var string
     */
    private $httpMethod;

    /**
     * URI da página
     *
     * @var string
     */
    private $uri;

    /**
     * Parâmetros da URL ($_GET)
     *
     * @var array
     */
    private $queryParams = [];

    /**
     * Variáveis recebidas no POST da página ($_POST)
     *
     * @var array
     */
    private $postVars = [];

    /**
     * Cabeçalho da requisição 
     *
     * @var array
     */
    private $headers = [];

    public function __construct($router)
    {
        $this->router = $router;
        $this->queryParams = $_GET ?? [];
        $this->postVars = $_POST ?? [];
        $this->headers = getallheaders();
        $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';
        $this->setUri();
    }

    /**
     * Método reponsavel por definir a URI
     *
     */
    private function setUri()
    {
        /** URI completa com GETS */
        $this->uri = $_SERVER['REQUEST_URI'] ?? '';

        /** Remove GETS da URI */
        $xURI = explode('?', $this->uri);
        $this->uri  = $xURI[0];
    }

    /**
     * Método reponsável por retornar instancia de router
     *
     * @return Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Método responsavel por retornar o método HTTP da requisição
     *
     * @return string
     */
    public function getHttpMethod()
    {
        return $this->httpMethod;
    }

    /**
     * Método responsavel por retornar a URI da requisição
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }


    /**
     * Método responsavel por retornar os headers da requisição
     *
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Método responsavel por retornar os parâmetros da URL da requisição
     *
     * @return array
     */
    public function getQueryParams()
    {
        return $this->queryParams;
    }

    /**
     * Método responsavel por retornar os variáves POST da requisição
     *
     * @return array
     */
    public function getPostVars()
    {
        return $this->postVars;
    }
}
