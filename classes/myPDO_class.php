<?php
namespace tableManager\classes;

class myPDO
{
  protected $pdo;
  
  public function __construct(\PDO $pdo)
  {
    $this->pdo = $pdo;
  }
  
  public function executeQuery($query)
  {
    $execute = $this->pdo->prepare($query);
    $execute->execute();
    return $execute;
  }
}