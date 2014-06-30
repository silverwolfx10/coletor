<?php
function __autoload($class_name) {
    if(file_exists(getcwd().$class_name . '.php')){
        require_once $class_name . '.php';
    }else{

        $class_name = str_replace("\\", "/", $class_name);

        if(file_exists(getcwd()."/../".$class_name . '.php')){
            require_once $class_name . '.php';
        }
    }

}
