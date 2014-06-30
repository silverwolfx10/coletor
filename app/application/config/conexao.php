<?php
namespace application\config;
class Conexao {
    public static $instance;

    public function __construct($driver = 'mysql', $host = 'localhost', $dbname, $user = 'root', $password = '', $port='3306') {
        try {

            self::$instance = new \PDO(
                "{$driver}:host={$host}; dbname={$dbname}; port={$port}",
                $user,
                $password,
                array(
                    \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
                )
            );

            self::$instance->setAttribute(
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION
            );
            self::$instance->setAttribute(
                \PDO::ATTR_ORACLE_NULLS,
                \PDO::NULL_EMPTY_STRING
            );
        }
        catch (\PDOException $err) {
            echo "Problema na conexao com servidor";
            $err->getMessage() . "<br/>";
//            file_put_contents('PDOErrors.txt',$err, FILE_APPEND);  // write some details to an error-log outside public_html
            die();  //  terminate connection
        }
    }
    public static function getInstance() {
        return self::$instance;
    }
}

