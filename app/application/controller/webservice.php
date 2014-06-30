<?php

class webservice extends application\controller\ControllerAbstract {

    public function index(){
        $this->layout = 'json';
        $stmt = $this->connection->getInstance()->prepare("SELECT * FROM sys_query q INNER JOIN sys_conexao c ON c.id = q.conexao_id INNER JOIN sys_driver d ON d.id = c.driver_id WHERE q.id = ?");
        $stmt->execute(array($this->get['id']));
        $conexaoCliente = $stmt->fetch(PDO::FETCH_ASSOC);


        //pegar conexao do cliente
        $pdoCliente = new \application\config\Conexao($conexaoCliente['driver'], $conexaoCliente['host'], $conexaoCliente['dbname'], $conexaoCliente['user'], $conexaoCliente['password'], $conexaoCliente['porta']);


        //consultar no cliente
        $stmt = $pdoCliente::getInstance()->prepare($this->cleanSqlString($conexaoCliente['query']));

        try{
            if($this->post)
                $stmt->execute($this->post);
            else
                $stmt->execute();

        $get = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }catch (\Exception $e){
            $where = explode("WHERE", $conexaoCliente['query']);

            if(is_array($where))
                 echo $where[1];
            else{
                $where = explode("where", $conexaoCliente['query']);
                if(is_array($where))
                    echo $where[1];


            }

            echo '<br />'.$e->getMessage();
            die;
        }
        $stmt->closeCursor();


        return array(
            'dados'=>json_encode($get, true),
        );

    }

    private function cleanSqlString($string){
        $origens  = array('DELETE', 'UPDATE', 'delete', 'update');
        $destinos = array('', '', '', '');
        return str_replace($origens, $destinos, $string);
    }

} 