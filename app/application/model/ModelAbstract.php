<?php
/**
 * Created by PhpStorm.
 * User: Le
 * Date: 29/06/14
 * Time: 21:52
 */

namespace application\model;


class ModelAbstract {
    protected $connection;
    protected $entity;
    public function __construct($connection){
        $this->connection = $connection;
    }

    public function fetchAll(){
        $stmt = $this->connection->getInstance()->prepare("SELECT * FROM {$this->entity}");
        $stmt->execute();
        $return = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $stmt->closeCursor();

        return $return;
    }

    public function fetchById($id){
        $stmt = $this->connection->getInstance()->prepare("SELECT * FROM {$this->entity} WHERE id = ?");
        $stmt->execute(array($id));
        $return = $stmt->fetch(\PDO::FETCH_ASSOC);

        $stmt->closeCursor();

        return $return;
    }

}