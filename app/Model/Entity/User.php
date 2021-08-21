<?php

namespace App\Model\Entity;

use \WilliamCosta\DatabaseManager\Database;

class User
{
    /**
     * ID do usuário
     * @var integer
     */
    public $id;

    /**
     * Nome do usuário
     * @var string
     */
    public $nome;

    /**
     * Email do usuário
     * @var string
     */
    public $email;

    /**
     * Senha do usuário
     * @var string
     */
    public $senha;

    /**
     * Método reponsável por cadastrar a instancia atual no banco de dados
     *
     * @return boolean
     */
    public function cadastrar()
    {
        /** Inseri usuário no banco de dados */
        $this->id = (new Database('user'))->insert([
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha,
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
        /** Atualiza usuário no banco de dados */
        return (new Database('user'))->update('id = ' . $this->id, [
            'nome' => $this->nome,
            'email' => $this->email,
            'senha' => $this->senha
        ]);
    }

    /**
     * Método reponsável por deletar um usuário do banco de dados
     *
     * @return boolean
     */
    public function deletar()
    {
        /** Exclui o usuário do banco de dados */
        return (new Database('user'))->delete('id = ' . $this->id);
    }

    /**
     * Método responsável por retornar um usuário com base em seu e-mail
     * @param string $email
     * @return User
     */
    public static function getUserByEmail($email)
    {
        return (new Database('user'))->select('email ="' . $email . '"')->fetchObject(self::class);
    }

    /**
     * Método reponsável por retornar um usuário com base no seu id
     * @param integer $id
     * @return User
     */
    public function getUserById($id)
    {
        return self::getUsers('id = ' . $id)->fetchObject(self::class);
    }

    /**
     * Método responsável por retornar Usuários
     *
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return \PDOStatement
     */
    public static function getUsers($where = null, $order = null, $limit = null, $fields = '*')
    {
        return (new Database('user'))->select($where, $order, $limit, $fields);
    }
}