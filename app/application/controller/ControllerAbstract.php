<?php
namespace application\controller;

class ControllerAbstract {

    protected  $connection;
    public  $data;
    public $get;
    public $post;
    public $layout;
    public function __construct($action = false, $connection, $get, $post){
        $this->connection = $connection;

        $this->get = $get;
        $this->post = $post;

        $action = (!$action)?'index':$action;
        $controller = \get_class($this);

        $this->data = $this->$action();

        extract($this->data, EXTR_PREFIX_SAME, "wddx");

        if($this->layout == 'json')
            require_once("../application/view/layout/json.phtml");
        else
            require_once("../application/view/layout/layout.phtml");


    }
} 