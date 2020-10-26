<?php namespace DAO;

use PDO;

class Connection {

    private $pdo = null;
    private $pdoStatement = null;
    private static $instance = null;

    private function __construct(){
        
    }

    public function getInstance(){

    }

    public function execute($query, $parameters = array(), $queryType = QueryType::Query){ // VER QueryType

    }

    public function executeNonQuery($query, $parameters = array(), $queryType = QueryType::Query){
    
    }

    public function prepare($query){

    }

    private function bindParameters($parameters = array(), $queryType = QueryType::Query){
        
    }
}
