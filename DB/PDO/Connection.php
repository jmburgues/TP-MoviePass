<?php
  namespace DB\PDO;
  
  use \PDO as PDO;
  use PDOException;
  use Controllers\ViewController as ViewController;

  class Connection{
    private $pdo = null;
    private $pdoStatement = null;
    private static $instance = null;

    private function __construct(){
      try{
        $this->pdo = new PDO("mysql:host=".DB_HOST."; dbname=".DB_NAME, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }
      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }

    public static function getInstance(){
      if(self::$instance == null)
        self::$instance = new Connection();
      return self::$instance;
    }

    public function execute($query, $parameters = array(), $queryType = QueryType::Query){
      try{
        $this->Prepare($query);
        $this->BindParameters($parameters, $queryType);
        $this->pdoStatement->execute();
        return $this->pdoStatement->fetchAll();
      }
      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }
      
    public function executeNonQuery($query, $parameters = array(), $queryType = QueryType::Query){
      try{
        $this->Prepare($query);
        $this->BindParameters($parameters, $queryType);
        $this->pdoStatement->execute();
        return $this->pdoStatement->rowCount();
      }
      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }
      
    private function prepare($query){
      try{
        $this->pdoStatement = $this->pdo->prepare($query);
      }
      catch(PDOException $ex)
      {
          $arrayOfErrors [] = $ex->getMessage();
          ViewController::errorView($arrayOfErrors);
      }
    }
      
    private function bindParameters($parameters = array(), $queryType = QueryType::Query){
      $i = 0;
      foreach($parameters as $parameterName => $value){
        $i++;
        if($queryType == QueryType::Query)
          $this->pdoStatement->bindParam(":".$parameterName, $parameters[$parameterName]);
        else
          $this->pdoStatement->bindParam($i, $parameters[$parameterName]);
      }
       }
    
  }
?>