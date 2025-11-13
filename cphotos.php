<?php

//echo "access=".$_POST['username'].":".$_POST['password']."\n";
//if(empty($_POST['username']) || empty($_POST['password'])) exit;

include_once("ccfg.php");
include_once("csub.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
//if($user_data == 0) exit;

  $id_person = $user_data['id'];
//echo "id_person=$id_person<br>\n";

  $dir = __DIR__."/fotos/$id_person/"; // Путь к директории, в которой лежат изображения
//echo "dir=$dir<br>\n";

  $path = "fotos/".$id_person."/";
  if (!file_exists($path)) {
    mkdir($path, 0777, true);
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