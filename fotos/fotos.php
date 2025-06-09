<?php

  $inx_person = -1;
  $id_person = 0;
  $nm_person = "";
  if (isset($_GET['inx'])){
    $inx_person = $_GET['inx'];
    $id_person = $_GET['id'];
    $nm_person = $_GET['name'];

    $dir = __DIR__."/$id_person/"; // Путь к директории, в которой лежат изображения
  }else{
    $dir = __DIR__."/"; // Путь к директории, в которой лежат изображения
  }
//echo "$dir<br>";

  if (!file_exists($id_person)) {
    mkdir($id_person, 0777, true);
    //echo "Директория создана успешно!";
  } else {
    //echo "Директория уже существует.";
  }

  if(isset($_POST['addimage'])) {
    $file = __DIR__ ."/$id_person/".$_FILES['path']['name'];
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
?>
  <a href="../index.php?do=cpersone&inx=<?php echo $inx_person; ?>"><img src="/icons/ic_menu_home.png" align=left></a>
  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  <form name="form1" action="" enctype="multipart/form-data" method="post">
  <input type="file" name="path" title="Фотография" />
  <input type="submit" name="addimage" title="Загрузить" value="+" />
  </form>
<?php
  /* Дальше происходит вывод изображений на страницу сайта (по 4 штуки на одну строку) */
  echo "<table width=100%><tr>";
  for ($i = 0; $i < count($files); $i++) { 
    echo "<td>";
?>
    <form name="form2" action="" enctype="multipart/form-data" method="post">
    <input type="submit" name="delimage" title="Удалить" value="<?php echo $files[$i]; ?>" />
    Удалить<br>
    </form>
<?php
    $path = $id_person;
    if(!empty($id_person)) $path .= "/";
    echo "<a href='".$path.$files[$i]."'><img src='".$path.$files[$i]."' width=256 height=256 alt=".$files[$i]." /></a>";
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