<?php
namespace tableManager\functions;


function autoloadClass($className){
  $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
  $namespace = 'tableManager' . DIRECTORY_SEPARATOR;
  $fileName = str_replace($namespace, '', $className) . '_class.php';
  if (file_exists($fileName)) {
    require $fileName;
  } else {
    echo $fileName . ' - файл не найден';
  }
}

spl_autoload_register('\tableManager\functions\autoloadClass');