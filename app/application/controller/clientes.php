<?php

class clientes extends application\controller\ControllerAbstract {


    public function index(){

        $modelClientes = new \application\model\clientes($this->connection);
        $return = $modelClientes->fetchAll();
        return array('dados'=>$return);

    }
    public function novo(){

        if($this->post){
            $modelClientes = new \application\model\clientes($this->connection);
            $return = $modelClientes->insert($this->post);
            if($return)
                header("location:index.php");
        }

        return array();
    }

    public function editar(){
        $modelClientes = new \application\model\clientes($this->connection);
        if($this->post){
            $return = $modelClientes->update($this->post);
            if($return)
                header("location:index.php");
        }

        $return = $modelClientes->fetchById($this->get['id']);
        return array(
            'data'=>$return,
            'id'=>$this->get['id']
        );
    }
}