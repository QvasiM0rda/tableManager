<?php
namespace tableManager;
include 'functions' . DIRECTORY_SEPARATOR . 'function.php';
?>

<!doctype html>
<html lang="ru">
<head>
  <title>Управление таблицами</title>
  <style>
    table, tr, th, td {
      padding: 5px;
      border: 1px solid #000;
    }
    table {
      border-collapse: collapse;
    }
    th {
      background-color: #fff;
    }

    #tableName, #tableColumn {
      display: none;
    }
  </style>
</head>
<body>
  <form method="post">
    <fieldset>
      <legend>Список таблиц</legend>
      <?= $tables->showTables(); ?>
      <?php if (!empty($_POST['create_table'])) { ?>
        <br>
        <label for="table_name">Имя таблицы</label>
        <input type="text" name="table_name" id="table_name">
        <br><br>
        <label for="column_count">Количество полей</label>
        <input type="number" name="column_count" id="column_count" value="1">
        <br><br>
        <input type="submit" name="add_table_form" value="Добавить">
        <br>
      <?php } ?>
      <br>
      <input type="submit" name="create_table" value="Создать таблицу">
    </fieldset>
    <?php
      if (!empty($tableDataCreate)) {
        \tableManager\functions\showTable($tableDataCreate);
      }
      if (!empty($tableData)) {
        \tableManager\functions\showTable($tableData);
      }
      if (!empty($tableDataEdit)) {
        \tableManager\functions\showTable($tableDataEdit);
      }
    ?>
  </form>
</body>
</html>