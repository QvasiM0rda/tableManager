<?php
namespace tableManager\functions;
include 'autoload.php';
include 'logic.php';
error_reporting(E_ALL);

//______________________________________________________________________________________________________________________
//Вывод таблицы
function showTable($tableData) {
  $legend = array_shift($tableData);
  $button = '';
  if ($legend === 'Изменение поля') {
    $button = '<input type="submit" name="save" value="Сохранить">';
  }
  if ($legend === 'Добавление таблицы') {
    $button = '<input type="submit" name="add_table" value="Добавить">';
  }
  echo <<<STRING
<fieldset>
  <legend>$legend</legend>
  <table>
    <tr>
      <th>Имя поля</th>
      <th>Тип поля</th>
      <th>NULL</th>
      <th>Значение по умолчанию</th>
      <th>Дополнительно</th>
      <th>Ключ</th>
      <th></th>
    </tr>
STRING;
  foreach ($tableData as $td) {
    echo $td;
  }
  echo <<<STRING
  </table>
  <br>
  $button
</fieldset>
STRING;
}


//______________________________________________________________________________________________________________________
//Функция для вывода полей таблицы
function showTableFields($arrayFields, $tableName){
  $tableData['legend'] = 'Поля таблицы';
  foreach ($arrayFields as $field) {
    $fieldName = $field['Field'];
    $fieldType = $field['Type'];
    $fieldNull = $field['Null'];
    $fieldPK = $field['Key'];
    $fieldDefault = $field['Default'];
    $fieldExtra = $field['Extra'];
    $fieldDel = '<a href="?table_name=' . $tableName .'&del_field=' . $fieldName . '">Удалить</a> ';
    $fieldEdit = '<a href="?table_name=' . $tableName .'&edit=' . $fieldName . '">Изменить</a> ';
    
    $tableData[] = <<<STRING
    <tr>
      <td>$fieldName</td>
      <td>$fieldType</td>
      <td>$fieldNull</td>
      <td>$fieldDefault</td>
      <td>$fieldExtra</td>
      <td>$fieldPK</td>
      <td>$fieldEdit $fieldDel</td>
    </tr>

STRING;
  }
  return $tableData;
}

//______________________________________________________________________________________________________________________
//Функция для вывода формы редактирования поля
function editField($arrayFields, $fieldName) {
  $tableData['legend'] = 'Изменение поля';
  foreach ($arrayFields as $field) {
    if($fieldName === $field['Field']) {
      $fieldTypeArray = explode('(', $field['Type']);
      $fieldType = $fieldTypeArray[0];
      $fieldLength = str_replace(')', '', $fieldTypeArray[1]);
      $fieldNull = $field['Null'] === 'YES' ? ' checked' : '';
      $fieldDefault = $field['Default'];
      $fieldExtra = $field['Extra'];
      $fieldPK = $field['Key'];
      $tableData[] = <<<STRING
    <tr>
      <td><input type="text" name="$fieldName" value="$fieldName"></td>
      <td>
        <select name="type">
          <option selected value="$fieldType">$fieldType</option>
          <option value="int">int</option>
          <option value="varchar">varchar</option>
          <option value="text">text</option>
          <option value="datetime">datetime</option>
        </select>
        <input type="text" name="length" value="$fieldLength">
      </td>
      <td><input type="checkbox" name="null" $fieldNull></td>
      <td>$fieldDefault</td>
      <td>$fieldExtra</td>
      <td>$fieldPK</td>
    </tr>

STRING;
    }
  }
  return $tableData;
}

//______________________________________________________________________________________________________________________
//Функция для вывода формы добавления таблицы
function createTable($columnCount, $tableName) {
  $tableData['legend'] = 'Добавление таблицы';
  for ($i=1; $i<=$columnCount; $i++) {
    $tableData[] = <<<STRING
<tr>
  <td>
    <input type="text" name="name_$i">
  </td>
  <td>
    <select name="type_$i">
      <option value="int">int</option>
      <option value="varchar">varchar</option>
      <option value="datetime">datetime</option>
      <option value="text">text</option>
    </select>
    <input type="number" name="length_$i">
  </td>
  <td>
    <input type="checkbox" name="null_$i">
  </td>
  <td>
    <input type="text" name="default_$i">
  </td>
  <td>
    <input type="checkbox" name="auto_increment_$i">
  </td>
  <td>
    <input type="radio" name="primary_key_$i">
  </td>
  <td>
    <input type="text" name="tableName" id="tableName" value="$tableName">
    <input type="text" name="tableColumn" id="tableColumn" value="$columnCount">
  </td>
</tr>
STRING;
  }
  return $tableData;
}