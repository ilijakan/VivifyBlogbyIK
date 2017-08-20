<?php

class Db {
  private $servername = "127.0.0.1";
  private $username = "root";
  private $password = "vivify";
  private $dbname = "blogik";
  public $conn;
  public $error = "";
  public $log;


  public function __construct(){
    try {
        $this->conn = new PDO("mysql:host={$this->servername};dbname={$this->dbname}", $this->username, $this->password);
        // set the PDO error mode to exception
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e)
    {
        echo $e->getMessage();
    }
  }

  public static function getDBInstance() {
      return new Db();
  }

  public function getPreparedStatement($query) {
    $statement = $this->conn->prepare($query);
    // execute statement
    $statement->execute();
    // set the resulting array to associative
    $statement->setFetchMode(PDO::FETCH_ASSOC);

    return $statement;
  }

  public function fetchAllData($query){
    return $this->getPreparedStatement($query)->fetchAll();
  }

  public function fetchData($query){
    return $this->getPreparedStatement($query)->fetch();
  }

  public function executeQuery($query){
    
    $statement = $this->conn->prepare($query);
    $statement->execute();
    return $this->conn->lastInsertId();
  }

}
