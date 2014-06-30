<?php
/**
 * Created by PhpStorm.
 * User: Le
 * Date: 29/06/14
 * Time: 21:52
 */

namespace application\model;


class conexao  extends \application\model\ModelAbstract{

    public function __construct($connection){

        parent::__construct($connection);
        $this->entity = 'sys_conexao';

    }

    public function fetchByClienteId($cliente_id){

        $stmt = $this->connection->getInstance()->prepare("SELECT *, c.id as conexao_id FROM sys_conexao c INNER JOIN sys_driver d ON d.id = c.driver_id WHERE c.cliente_id = ?");
        $stmt->execute(array($cliente_id));
        $return = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $return;
    }

    public function insert($data){
        $stmt = $this->connection
            ->getInstance()
            ->prepare("INSERT INTO sys_conexao (name,cliente_id, driver_id, host, dbname, user, password, porta) VALUES (:name,:cliente_id, :driver_id, :host, :dbname, :user, :password, :porta)");
       $return = $stmt->execute(array(
                ':name'=>$data['name'],
                ':porta'=>$data['porta'],
                ':cliente_id'=>$data['cliente_id'],
                ':driver_id'=>$data['driver_id'],
                ':host'=>$data['host'],
                ':dbname'=>$data['dbname'],
                ':user'=>$data['user'],
                ':password'=>$data['password'],
            )
        );

        $stmt->closeCursor();

        return $return;
    }

    public function update($data){
        $stmt = $this->connection
            ->getInstance()
            ->prepare("UPDATE sys_conexao SET name = :name, cliente_id = :cliente_id, driver_id = :driver_id, host = :host, dbname = :dbname, user = :user, password = :password, porta = :porta WHERE id = :id");
        $return = $stmt->execute(array(
                ':name'=>$data['name'],
                ':porta'=>$data['porta'],
                ':cliente_id'=>$data['cliente_id'],
                ':driver_id'=>$data['driver_id'],
                ':host'=>$data['host'],
                ':dbname'=>$data['dbname'],
                ':user'=>$data['user'],
                ':password'=>$data['password'],
                ':id'=>$data['id']
            )
        );

        $stmt->closeCursor();

        return $return;
    }

} 