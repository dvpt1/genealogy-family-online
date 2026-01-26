<?php

if(empty($_POST['username']) || empty($_POST['password'])){
  //echo "No access=".$_POST['username'].":".$_POST['password']."<br>";
  exit;
}

include_once("../ccfg.php");
include_once("../chtmls.php");
include_once("../cutils.php");
include_once("../cvars.php");
include_once("../cdatabases.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
if($user_data == 0) {
  exit;
}

  global $fldINX;
  global $fldID;

echo "<br><br>CLEAR ALL<br><br>\n";

  $p = __DIR__;
echo "<br>$p<br>\n";

  $mainPath = substr($p,0,strlen($p)-4);
echo "<br>$maiPath<br>\n";

  $cardsPath = "$mainPath/cards/";
echo "<br>$cardsPath<br>\n";

  $files = glob($cardsPath."*.card");
  foreach ($files as $fileName) {
    if(unlink($fileName)){
      echo "OK $fileName file <br>\n";
    }else{
      echo "ERR $fileName file <br>\n";
    }
  }

  $fotosPath = "$mainPath/fotos/";
echo "<br>$fotosPath<br>\n";

  $folders = glob($fotosPath."*");
  foreach ($folders as $folderName) {
    if(deleteFolder($folderName)){
      echo "OK $folders folder <br>\n";
    }else{
      echo "ERR $folderName folder <br>\n";
    }
  }

////////////////////////////////////////////////////////////
  $timestamp = date('YmdHisu');
  file_put_contents("../timestamp", $timestamp);
////////////////////////////////////////////////////////////


?>