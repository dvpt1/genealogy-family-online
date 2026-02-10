<?php

include_once("ccfg.php");
include_once("csub.php");
include_once("chtmls.php");

$user = _check_auth($_COOKIE);
$users = _check_datauserid($user['id']);
//echo $users['id'].":".$users['acces'];

GLOBAL $field_foto;
GLOBAL $ic_menu_delete;
GLOBAL $ic_menu_load;

  $inx_person = -1;
  $id_person = 0;
  $nm_person = "";
  if (isset($_GET['id'])){
    $id_person = $_GET['id'];
    $nm_person = $_GET['name'];
    $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"

    $dir = __DIR__."/fotos/$number/"; // Путь к директории, в которой лежат изображения
  }else{
    $dir = __DIR__."/fotos/"; // Путь к директории, в которой лежат изображения
  }

  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"
  $path = "fotos/".$number;
  if (!file_exists($path)) {
    mkdir($path, 0777, true);
    //echo "Директория создана успешно!";
  } else {
    //echo "Директория уже существует.";
  }

  if(isset($_POST['addimage'])) {
    $file = $dir.$_FILES['path']['name'];
    move_uploaded_file($_FILES['path']['tmp_name'], $file);
    if(isset($_FILES['path']['name'])==true)
    {
      $type = pathinfo($file, PATHINFO_EXTENSION);
      $data = file_get_contents($file);
    }
  }

  if(isset($_POST['delimage'])) {
    unlink($dir.$_POST['delimage']);
  }

  $files = scandir($dir); // Получаем список файлов из этой директории
  $files = excess($files); // Удаляем лишние файлы

  echo "<a href=\"index.php?do=cpersone&id=$id_person\"><img src=\"/icons/ic_menu_home.png\" align=left></a>";

  if($users['id'] > 0 && $users['acces'] < 2){
?>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <form name="form1" action="" enctype="multipart/form-data" method="post">
  <input type="file" name="path" title="<?php echo $field_foto ?>" />
  <input type="submit" name="addimage" title="<?php echo $ic_menu_load ?>" value="+" />
  </form>
<?php
  }
  /* Дальше происходит вывод изображений на страницу сайта (по 4 штуки на одну строку) */
  echo "<table width=100%><tr>";
  for ($i = 0; $i < count($files); $i++) { 
    echo "<td>";
    if(!empty($id_person)) if(substr($path, -1) != '/') $path .= "/";
    echo "<a href='".$path.$files[$i]."'><img src='".$path.$files[$i]."' width=256 height=256 alt=".$files[$i]." /></a>";
    if($users['id'] > 0 && $users['acces'] < 2){
?>
    <form name="form2" action="" enctype="multipart/form-data" method="post">
    <input type="submit" name="delimage" title="<?php echo $ic_menu_delete ?>" value="<?php echo $files[$i]; ?>" /><?php echo $ic_menu_delete ?><br>
    </form>
<?php
    }
    echo "</td>";
    if (($i + 1) % 4 == 0) echo "</tr><tr>";
  } 
  echo "</tr></table";

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