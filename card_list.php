<?php

include_once("vars.php");

global $page;
global $cellw;
global $cellh;

  // разбивка на страницы
  if(empty($_GET["p"])){$_GET["p"]="1";}// страницы
  $p = $_GET["p"];// страница
  
  $count = count($persons);// считаем файлы
  $total = ceil($count/$page);// считаем страницы

  $scrwidth = $_COOKIE['screen_width'];
  $scrheight = $_COOKIE['screen_height'];

  // проверяем существование переменных $width и $height
  if (isset($_GET['scrwidth']) AND isset($_GET['scrheight'])) {
    // если переменные существуют, то выводим полученные значения на экран
    $scrwidth = $_GET['scrwidth'];
    $scrheight = $_GET['scrheight'];
  }// если переменные не существуют, то выполняем следующее
  else {
   if (empty($scrwidth) AND empty($scrheight)) {
    // PHP сгенерирует код JavaScript, который обработает браузер
    // пользователя и передаст значения обратно PHP-скрипту через протокол HTTP
    echo "<script language='javascript'>\n";
    echo " location.href=\"${_SERVER['SCRIPT_NAME']}?${_SERVER['QUERY_STRING']}"
            . "scrwidth=\" + screen.width + \"&scrheight=\" + screen.height;\n";
    echo "</script>\n";
   }
  }

  $cols = (int)ceil($scrheight/(int)250);// Количество столбцов в будущей таблице с картинками
  if($scrwidth > $scrheight) $cols = (int)round($scrwidth/(int)250);

echo "<br><br>";
//echo "Ширина экрана: ". $scrwidth ."<br />\n";
//echo "Высота экрана: ". $scrheight ."<br />\n";
//echo "Колонок: ". $cols ."<br />\n";
//echo "Страниц: ". $page ."<br />\n";
//=========================================================//

$mainPath = __DIR__ ;//. '/cardfile/';
$files = glob($mainPath."/*.card");
echo "path = ".$mainPath."<br>";
echo "count = ".Count($files)."<br>";
echo "<hr>";

echo "<table>\n"; // Начинаем таблицу
echo "<tr height=".$cellh.">\n"; // Добавляем новую строку
foreach ($files as $fileName) {

  // The JSON file
  //echo "$fileName size " . filesize($filename) . "<br>\n";
  // Read the file into a variable
  $jsonData = file_get_contents("$fileName");
  // Decode the JSON data into a PHP associative array
  $dataPerson = json_decode($jsonData, true);
  //print_r($dataPerson);


  //echo "<hr width=50%>";
  //echo "gender = ".$dataPerson->gender."<br>";
  //echo "lastname = ".$dataPerson['lastname']."<br>";
  //echo "firstname = ".$dataPerson['firstname']."<br>";
  //echo "surname = ".$dataPerson['surname']."<br>";
  //echo "<hr width=50%>";

  //echo "<tr>\n"; // Добавляем новую строку
  // Начинаем столбец
  $name = $dataPerson['lastname']." ".$dataPerson['firstname']." ".$dataPerson['surname'];
  $gender = $dataPerson['gender'];

  if($gender=='1') {echo "<td bgcolor='#00ffff' width=".$cellw.">";}
  else if($gender=='2') {echo "<td bgcolor='#ffc0cb' width=".$cellw.">";}
  else {echo "<td width=".$cellw.">";}

  echo "<a href=card_add.php?inx=".$fileName."&edit=0>";
  if(!empty($dataPerson['icon'])){
	$src = "<img src='data:image/jpeg;base64,".$dataPerson['icon']."' width='250'>";
	echo $src;
  }else{
    $path = '';
    if($gender=='1') {$path = "icons/Avatar64_Man.png";}
    else if($gender=='2') {$path = "icons/Avatar64_Woman.png";}
    else {$path = "icons/Avatar64.png";}
	echo "<img src='$path' alt='$name' title='$name' width='250'>";
  }
  echo "<b>".$name."</b>";
  echo "</a>"; // Закрываем ссылку


  echo "</td>\n"; // Закрываем столбец
  //echo "</tr>\n"; // Закрываем строку
}
echo "</tr>\n"; // Закрываем строку
echo "</table>\n"; // Закрываем таблицу
echo "<hr>";

?>