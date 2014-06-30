<?php

class conexao extends application\controller\ControllerAbstract {

    public function index(){

        $modelConexao = new \application\model\conexao($this->connection);
        $return = $modelConexao->fetchByClienteId($this->get['cliente_id']);

        return array(
            'dados'=>$return,
            'cliente_id'=>$this->get['cliente_id']
        );

    }

    public function novo(){

        if($this->post){
            $modelConexao = new \application\model\conexao($this->connection);
            $return = $modelConexao->insert($this->post);
            if($return)
                header("location:index.php?pag=conexao&cliente_id={$this->get['cliente_id']}");
        }

        $modelDriver = new \application\model\driver($this->connection);
        $drivers = $modelDriver->fetchAll();


        return array(
            'drivers'=>$drivers,
            'cliente_id'=>$this->get['cliente_id']
        );

    }

    public function editar(){

        $modelConexao = new \application\model\conexao($this->connection);
        if($this->post){
            $return = $modelConexao->update($this->post);
            if($return)
                header("location:index.php?pag=conexao&cliente_id={$this->get['cliente_id']}");
        }

        $data = $modelConexao->fetchById($this->get['id']);

        $modelDriver = new \application\model\driver($this->connection);
        $drivers = $modelDriver->fetchAll();


        return array(
            'drivers'=>$drivers,
            'data'=>$data,
            'cliente_id'=>$this->get['cliente_id']
        );

    }
}