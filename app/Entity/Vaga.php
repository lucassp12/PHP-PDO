<?php
namespace App\Entity;

use App\Db\Database;
use PDO;


class Vaga
{
    /**
     * Identificador único da vaga
     * @var integer
     */
    public $id;

    /**
     * Título da vaga
     * @var string
     */
    public $titulo;

    /**
     * Descrição da vaga
     * @var string
     */
    public $descricao;

    /**
     * Descrição da vaga
     * @var string(s/n)
     */
    public $ativo;


    /**
     * data da publicação da vaga
     * @var string
     */
    public $data;


    /**
     * cadastra vaga no banco de dados
     * @return integer
     */
    public function cadastrar()
    {
        $this->data = date('Y-m-d H:i:s');

        $obDatabase = new Database('vagas');

        $this->id = $obDatabase->insert([
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);

        return $this->id;


    }

    /**
     * edita vaga no banco de dados
     * @return boolean
     */
    public function editar()
    {
        $this->data = date('Y-m-d H:i:s');

        $obDatabase = new Database('vagas');

        $this->id = $obDatabase->update('id = ' . $this->id, [
            'titulo' => $this->titulo,
            'descricao' => $this->descricao,
            'ativo' => $this->ativo,
            'data' => $this->data
        ]);

        return $this->id;


    }


    /**
     * Excluí a vaga no banco de dados
     * @return boolean
     */
    public function excluir()
    {
        $this->data = date('Y-m-d H:i:s');

        $obDatabase = new Database('vagas');

        $this->id = $obDatabase->delete('id = ' . $this->id);

        return $this->id;


    }

    /**
     * Método responsável por obter as vagas do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @return array 
     */
    public static function getVagas($where = null, $order = null, $limit = null)
    {
        return (new Database('vagas'))->select($where, $order, $limit)
            ->fetchAll(PDO::FETCH_CLASS, self::class);
    }

    /**
     * Método responsável por obter a quantidade de vagas no baqnco de dados
     * @param string $where
     * @return integer 
     */
    public static function getQuantidadeVagas($where = null)
    {
        return (new Database('vagas'))->select($where, null, null, 'COUNT(*) as qtd')
            ->fetchObject()
            ->qtd;
    }






    /**
     * Método responsável por buscar uma vaga com base no seu id
     * @param integer $id
     * @return Vaga
     */
    public static function getVaga($id)
    {
        return (new Database('vagas'))->select('id = ' . $id)->fetchObject(self::class);
    }



}
?>