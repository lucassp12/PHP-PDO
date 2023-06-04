<?php

namespace App\Db;

use \PDO;
use \PDOException;

class Database
{

    /**
     * Host de conexão com o banco de dados
     * @var string
     */
    const HOST = 'localhost';

    /**
     * Nome do banco de dados
     * @var string
     */
    const NAME = 'vagas';

    /**
     * Usuário do banco
     * @var string
     */
    const USER = 'root';

    /**
     * Senha de acesso ao banco de dados
     * @var string
     */
    const PASS = '';

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */
    private $connection;

    /**
     * Define a tabela e instancia e conexão
     * @param string $table
     */
    public function __construct($table = null)
    {
        $this->table = $table;
        $this->setConnection();
    }

    /**
     * Método responsável por criar uma conexão com o banco de dados
     */
    private function setConnection()
    {
        try {
            $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por executar queries dentro do banco de dados
     * @param  string $query
     * @param  array  $params
     * @return \PDOStatement
     */
    public function execute($query, $params = [])
    {
        try {
            $statement = $this->connection->prepare($query);
            $statement->execute($params);
            return $statement;
        } catch (PDOException $e) {
            die('ERROR: ' . $e->getMessage());
        }
    }

    /**
     * Método responsável por inserir dados no banco
     * @param array
     * @return integer
     */
    public function insert($values)
    {

        //DADOS da query
        $fields = array_keys($values);
        $binds = array_pad([], count($fields), '?');

        //Monta a Query
        $query = 'INSERT INTO ' . $this->table . '(' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';


        //Executa a Query
        $this->execute($query, array_values($values));

        //Retorna o id inserido
        return $this->connection->lastInsertId();
    }


    /**
     * Método responsável por inserir dados no banco
     * @param string
     * @param array
     * @return boolean
     */
    public function update($where, $values)
    {
        //DADOS DA QUERY
        $fields = array_keys($values);

        //MONTA A QUERY
        $query = 'UPDATE ' . $this->table . ' SET ' . implode('=?,', $fields) . '=? WHERE ' . $where;

        //EXECUTAR A QUERY
        $this->execute($query, array_values($values));

        //RETORNA SUCESSO
        return true;
    }


    /**
     * Método responsável por deletar dados no banco
     * @param string
     * @return boolean
     */
    public function delete($where)
    {

        //MONTA A QUERY
        $query = 'DELETE FROM ' . $this->table . ' WHERE ' . $where;
        //EXECUTAR A QUERY
        $this->execute($query);

        //RETORNA SUCESSO
        return true;
    }


    /**
     * Método responsável por executar uma consulta no banco
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return \PDOStatement
     */
    public function select($where = null, $order = null, $limit = null, $fields = '*')
    {
        //Dados da query


        $where = strlen($where) ? 'WHERE ' . $where : '';
        $order = strlen($order) ? 'ORDER BY ' . $order : '';
        $limit = strlen($limit) ? 'LIMIT ' . $limit : '';


        $query = 'SELECT ' . $fields . ' FROM ' . $this->table . ' ' . $where . ' ' . $order . ' ' . $limit;

        return $this->execute($query);
    }

}

?>