<?php
/**
 * Created by PhpStorm.
 * User: Le
 * Date: 29/06/14
 * Time: 21:52
 */

namespace application\model;


class query  extends \application\model\ModelAbstract{

    public function __construct($connection){

        parent::__construct($connection);
        $this->entity = 'sys_query';

    }

    public function fetchByClienteId($cliente_id){
        $stmt = $this->connection->getInstance()->prepare("SELECT * FROM sys_query q WHERE q.cliente_id = ?");
        $stmt->execute(array($cliente_id));
        $return = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $return;
    }

    public function insert($data){
        $stmt = $this->connection
            ->getInstance()
            ->prepare("INSERT INTO sys_query (cliente_id, conexao_id, name, query) VALUES (:cliente_id, :conexao_id, :name, :query)");
        $return = $stmt->execute(array(
                ':name'=>$data['name'],
                ':cliente_id'=>$data['cliente_id'],
                ':conexao_id'=>$data['conexao_id'],
                ':query'=>$data['query'],
            )
        );

        $stmt->closeCursor();

        return $return;
    }

    public function update($data){
        $stmt = $this->connection
            ->getInstance()
            ->prepare("UPDATE sys_query SET name = :name, cliente_id = :cliente_id, conexao_id = :conexao_id, query = :query WHERE id = :id");
        $return = $stmt->execute(array(
                ':name'=>$data['name'],
                ':cliente_id'=>$data['cliente_id'],
                ':conexao_id'=>$data['conexao_id'],
                ':query'=>$data['query'],
                ':id'=>$data['id']
            )
        );

        $stmt->closeCursor();

        return $return;
    }

} 