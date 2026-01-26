<?php

if(empty($_POST['username']) || empty($_POST['password'])){
  //echo "No access=".$_POST['username'].":".$_POST['password']."<br>";
  exit;
}

include_once("../ccfg.php");
include_once("../chtmls.php");
include_once("../cvars.php");
include_once("../cdatabases.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
if($user_data == 0) {
  exit;
}

  global $fldINX;
  global $fldID;

  $inx_person = $_POST['inx'];
  $id_person = $_POST['id'];

  $s = $_POST['persona'];

  if (strpos($s,"\"icon\":\""))
  {
     $i = strpos($s,"\"icon\":\"");
     $s1 = substr($s, 0, $i + 8);
     $s2 = substr($s, $i + 9);
     $s3 = "";
     if (strpos($s2,"\""))
     {
	$i = strpos($s2,"\"");
	$s3 = substr($s2, $i);
	$s2 = substr($s2, 0, $i);
     }
     $s2 = str_replace(" ", "+", $s2);
     $s = $s1.$s2.$s3;
  }

  // Generate json file
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"

  $p = __DIR__;
  $mainPath = substr($p,0,strlen($p)-4);

  $file = "$mainPath/cards/$number.card";
  file_put_contents($file, $s);

////////////////////////////////////////////////////////////
  file_put_contents("../timestamp", $timestamp);
////////////////////////////////////////////////////////////

echo " PERSONA=".$_POST['persona'];

?>