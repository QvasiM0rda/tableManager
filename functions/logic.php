<?php
namespace tableManager\functions;
use tableManager\classes\tables;

$pdo = new \PDO('mysql:host=localhost;dbname=kerimov;charset=utf8', 'kerimov', 'neto0990');
$tables = new tables($pdo);

//Вывод полей таблицы
if (!empty($_GET['table_name'])) {
  $tableName = $_GET['table_name'];
  $arrayFields = $tables->showTableFields($tableName);
  $tableData = showTableFields($arrayFields, $tableName);
  
  //Форма для редактирования выбраного поля
  if (!empty($_GET['edit'])) {
    $fieldName = $_GET['edit'];
    $arrayFields = $tables->showTableFields($tableName);
    $tableDataEdit = editField($arrayFields, $fieldName);
  }
  
  //Удаление выбраного поля
  if (!empty($_GET['del_field'])) {
    $tables->dropField($tableName, $_GET['del_field']);
    header('Location: index.php?table_name=' . $_GET['table_name']);  }
}

//Редактирование выбраного поля
if (!empty($_POST['save'])) {
  $tables->editField($_POST, $_GET['table_name']);
  header('Location: index.php?table_name=' . $_GET['table_name']);
}

//Вывод формы для создания таблицы
if (!empty($_POST['add_table_form'])) {
  $tableName = $_POST['table_name'];
  $columnCount = $_POST['column_count'];
  $tableDataCreate = createTable($columnCount, $tableName);
}

if (!empty($_POST['add_table'])) {
  $tableName = $_POST['tableName'];
  $columnCount = $_POST['tableColumn'];
  $tables->createTable($tableName, $columnCount, $_POST);
  //header('Location: index.php');
}

//Удаление таблицы
if (!empty($_GET['del_table'])) {
  $tables->dropTable($_GET['del_table']);
  header('Location: index.php?table_name=' . $_GET['table_name']);
}