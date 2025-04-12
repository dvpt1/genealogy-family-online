<?php

include_once("vars.php");

global $page;
global $cellw;
global $cellh;

//=========================================================//

$mainPath = __DIR__ ;//. '/cardfile/';

// The JSON file
$fileName = $_GET['inx'];
echo "inx_person: ". $fileName ."<br />\n";

  // Read the file into a variable
  $jsonData = file_get_contents("$fileName");
  // Decode the JSON data into a PHP associative array
  $dataPerson = json_decode($jsonData, true);
  //print_r($dataPerson);

  // Начинаем столбец
  $gender = $dataPerson['gender'];
  if($gender=='1') {echo "<td bgcolor='#00ffff' width=".$cellw.">";}
  else if($gender=='2') {echo "<td bgcolor='#ffc0cb' width=".$cellw.">";}
  else {echo "<td width=".$cellw.">";}

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
  $name = $dataPerson['lastname'].$dataPerson['firstname'].$dataPerson['surname'];
  echo "<b>".$name."</b>";

echo "<hr>";

?>