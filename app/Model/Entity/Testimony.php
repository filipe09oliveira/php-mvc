<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Testimony
{
    /**
     * ID
     *
     * @var integer
     */
    public $id;

    /**
     * NOME
     *
     * @var string
     */
    public $nome;

    /**
     * MENSAGEM
     *
     * @var string
     */
    public $mensagem;


    /**
     * data publicação
     *
     * @var string
     */
    public $data;

    /**
     * Método reponsável por cadastrar a instancia atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar()
    {
        /** Define a data */
        $this->data = date('Y-m-d H:i:s');

        /** Inseri depoimento no banco de dados */
        $this->id = (new Database('depoimentos'))->insert([
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
            'data' => $this->data,
        ]);

        return true;
    }

    /**
     * Método responsável por retornar Depoimentos
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}
