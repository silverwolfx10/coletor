<?php

class query extends application\controller\ControllerAbstract {

    public function index(){

        $modelQuery = new \application\model\query($this->connection);
        $return = $modelQuery->fetchByClienteId($this->get['cliente_id']);


        return array(
            'dados'=>$return,
            'cliente_id'=>$this->get['cliente_id']
        );

    }

    public function novo(){

        if($this->post){
            $modelQuery = new \application\model\query($this->connection);
            $return = $modelQuery->insert($this->post);
            if($return)
                header("location:index.php?pag=query&cliente_id={$this->get['cliente_id']}");
        }

        $modelConexao = new \application\model\conexao($this->connection);
        $conexoes = $modelConexao->fetchByClienteId($this->get['cliente_id']);

        return array(
            'conexoes'=>$conexoes,
            'cliente_id'=>$this->get['cliente_id']
        );

    }

    public function editar(){
        $modelQuery = new \application\model\query($this->connection);
        if($this->post){
            $return = $modelQuery->update($this->post);
            if($return)
                header("location:index.php?pag=query&cliente_id={$this->get['cliente_id']}");
        }

        $modelConexao = new \application\model\conexao($this->connection);
        $conexoes = $modelConexao->fetchByClienteId($this->get['cliente_id']);

        $data = $modelQuery->fetchById($this->get['id']);
        return array(
            'conexoes'=>$conexoes,
            'data'=>$data,
            'cliente_id'=>$this->get['cliente_id']
        );

    }




} 