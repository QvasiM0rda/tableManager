<?php
namespace tableManager\classes;

class tables extends myPDO
{
  public function showTables()
  {
    $query = 'SHOW TABLES';
    $tablesArray = $this->executeQuery($query);
    foreach ($tablesArray as $tables) {
      $tableName = $tables['Tables_in_kerimov'];
      echo '<a href="?table_name=' . $tableName . '">' . $tableName . '</a> ';
      echo '<a href="?del_table=' . $tableName . '">Удалить</a> <br>';
    }
  }
  
  public function createTable($tableName, $columnCount, $columnArray)
  {
    $query = "CREATE TABLE $tableName (";
    $primaryKey = '';
    for($i=1; $i<=$columnCount; $i++) {
      $name = $columnArray["name_$i"];
      $type = $columnArray["type_$i"] . '(' . $columnArray["length_$i"] . ')';
      $null = !empty($columnArray["null_$i"]) ? 'NULL' : '';
      $default = $columnArray["default_$i"];
      $auto_increment = !empty($columnArray["auto_increment_$i"]) ? 'AUTO_INCREMENT' : '';
      if (!empty($columnArray["primary_key_$i"])) {$primaryKey = $name;}
      $query = $query . <<<QUERY
      `$name` $type $null $auto_increment $default,
QUERY;
    }
    $query = $query . <<<QUERY
    PRIMARY KEY (`$primaryKey`)
) ENGINE=InnoDB, DEFAULT CHARSET=utf8;
QUERY;
    $this->executeQuery($query);
  }

  public function showTableFields($tableName)
  {
    $query = "EXPLAIN $tableName";
    return $this->executeQuery($query);
  }

  public function editField($fieldArray, $tableName)
  {
    $keys = array_keys($fieldArray);
    $fieldOldName = array_shift($keys);
    $filedNewName = array_shift($fieldArray);
    $length = !empty($fieldArray['length']) ? '(' . $fieldArray['length'] . ')' : '';
    $fieldType = $fieldArray['type'] . $length;
    $fieldNull = !empty($fieldArray['null']) ? 'NULL' : '';
    $fieldExtra = !empty($fieldArray['extra']) ? 'AUTO_INCREMENT' : '';

    $query = <<<QUERY
ALTER TABLE $tableName
CHANGE $fieldOldName $filedNewName $fieldType $fieldNull $fieldExtra
QUERY;
    if ($this->executeQuery($query)) {
      return true;
    } else {
      echo $query;
    }
  }

  public function dropTable($tableName)
  {
    $query = "DROP TABLE IF EXISTS $tableName";
    $this->executeQuery($query);
  }

  public function dropField($tableName, $fieldName)
  {
    $query = "ALTER TABLE $tableName DROP COLUMN $fieldName";
    $this->executeQuery($query);
  }
}