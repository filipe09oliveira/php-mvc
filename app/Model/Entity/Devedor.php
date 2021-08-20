<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class Devedor
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
     * cpf/cnpj
     *
     * @var integer
     */
    public $identificacao;


    /**
     * data de nascimento
     *
     * @var date
     */
    public $data_nascimento;

    /**
     * endereço
     *
     * @var integer
     */
    public $endereco_id;

    /**
     * titulo
     *
     * @var string
     */
    public $titulo;

    /**
     * valor
     *
     * @var float
     */
    public $valor;

    /**
     * data de vencimento
     *
     * @var date
     */
    public $data_vencimento;

    /**
     * data atualização
     *
     * @var \DateTime
     */
    public $updated;

    /**
     * Método reponsável por cadastrar a instancia atual no banco de dados
     *
     * @return boolean
     */
    public function save()
    {
        /** Define a data */
        $this->data = date('Y-m-d H:i:s');

        /** Inseri devedor no banco de dados */
        $this->id = (new Database('devedor'))->insert([
            'nome' => $this->nome,
            'identificacao' => $this->identificacao,
            'data_nascimento' => $this->data_nascimento,
            'titulo' => $this->titulo,
            'valor' => $this->valor,
            'data_vencimento' => $this->data_nascimento,
            'updated' => $this->updated,
        ]);

        return true;
    }

    /**
     * Método responsável por retornar Devedores
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return \PDOStatement
     */
    public static function getAllDevedores($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('devedor'))->select($where, $order, $limit, $fields);
    }

}