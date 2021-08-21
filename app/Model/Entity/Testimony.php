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
     * Método reponsável por atualizar os dados do banco com a instância atual
     *
     * @return boolean
     */
    public function atualizar()
    {
        /** Atualiza depoimento no banco de dados */
        return (new Database('depoimentos'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'mensagem' => $this->mensagem,
        ]);
    }

    /**
     * Método reponsável por deletar um depoimento do banco de dados
     *
     * @return boolean
     */
    public function deletar()
    {
        /** Exclui o depoimento do banco de dados */
        return (new Database('depoimentos'))->delete('id = ' . $this->id);
    }

    /**
     * Método reponsável por retornar um depoimento com base no seu id
     * @param integer $id
     * @return Testimony
     */
    public function getTestimonyById($id)
    {
        return self::getTestimonies('id = ' . $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar Depoimentos
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return \PDOStatement
     */
    public static function getTestimonies($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('depoimentos'))->select($where, $order, $limit, $fields);
    }
}
