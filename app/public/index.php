<?php


ini_set('display_errors',1);

ini_set('memory_limit','1024M');

require_once("../autoloader.php");

//$pdo = new \application\config\Conexao('mysql', 'localhost', 'coletor', 'root', '');
$pdo = new \application\config\Conexao('mysql', 'localhost', 'coletor', 'root', 'b85c@bak%');

$controller = (isset($_GET['pag']))? $_GET['pag'] : 'clientes';
$action = (isset($_GET['action']))? $_GET['action'] : false;

require_once("../application/controller/{$controller}.php");

$class = new $controller($action, $pdo, $_GET, $_POST);

