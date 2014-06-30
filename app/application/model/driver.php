<?php
/**
 * Created by PhpStorm.
 * User: Le
 * Date: 29/06/14
 * Time: 21:51
 */

namespace application\model;


class driver extends \application\model\ModelAbstract{

    public function __construct($connection){
        parent::__construct($connection);
        $this->entity = 'sys_driver';
    }

//    public function insert($data){
//        $stmt = $this->connection
//            ->getInstance()
//            ->prepare("INSERT INTO sys_clientes (nome,login, senha) VALUES (:nome,:login, :senha)");
//        $return = $stmt->execute(array(
//                ':nome'=>$data['nome'],
//                ':login'=>$data['login'],
//                ':senha'=>$data['senha']
//            )
//        );
//
//        $stmt->closeCursor();
//        return $return;
//    }
//
//    public function update($data){
//        $stmt = $this->connection
//            ->getInstance()
//            ->prepare("UPDATE sys_clientes SET nome = :nome, login = :login, senha = :senha WHERE id = :id");
//
//        $return = $stmt->execute(array(
//                ':nome'=>$data['nome'],
//                ':login'=>$data['login'],
//                ':senha'=>$data['senha'],
//                ':id'=>$data['id']
//            )
//        );
//
//        $stmt->closeCursor();
//
//        return $return;
//    }

} 