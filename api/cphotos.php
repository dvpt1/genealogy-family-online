<?php

//echo "access=".$_POST['username'].$_POST['password'].$_POST['id']."\n";
if(empty($_POST['username']) || empty($_POST['password'])) exit;

include_once("../ccfg.php");
include_once("../csub.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
if($user_data == 0) exit;

  $id = $_POST['id'];
  $id_person = str_replace(array("\r", "\n"), '', $id);
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"

  $p = __DIR__;
  $mainPath = substr($p,0,strlen($p)-4);
  $path = "fotos/$number/";

  $dir = "$mainPath/fotos/$number/"; // Путь к директории, в которой лежат изображения
  if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
    //echo "Директория создана успешно!";
  } else {
    //echo "Директория уже существует.";
  }
//echo "path=$path<br>\n";

  $files = scandir($dir); // Получаем список файлов из этой директории
  $files = excess($files); // Удаляем лишние файлы

  for ($i = 0; $i < count($files); $i++) { 
    if(!empty($id_person)) if(substr($path, -1) != '/') $path .= "/";
    //echo "path=$path file=$files[$i]".substr($path, -1)."<br>";
    //echo "<a href='".$path.$files[$i]."'><img src='".$path.$files[$i]."' width=256 height=256 alt=".$files[$i]." /></a>";
    echo "$path$files[$i]\n";

    //$input = "$path$files[$i]\n";
    //var_dump($input);
    //echo mb_convert_encoding($input, "UTF-8", "windows-1252");
    //$output = iconv('windows-1252', 'UTF-8',$input);
    //echo "$output\n";

  } 


  /* Функция для удаления лишних файлов: сюда, помимо удаления текущей и родительской директории, так же можно добавить файлы, не являющиеся картинкой (проверяя расширение) */
  function excess($files) {
    $result = array();
    for ($i = 0; $i < count($files); $i++) {
      $ext = strtolower(pathinfo($files[$i], PATHINFO_EXTENSION));
      if ($ext == "jpg" || $ext == "jpeg" || $ext == "png" || $ext == "gif") $result[] = $files[$i];
      //if ($files[$i] != "." && $files[$i] != "..") $result[] = $files[$i];
    }
    return $result;
  }

?>