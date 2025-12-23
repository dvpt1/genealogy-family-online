<?php

if(empty($_POST['username']) || empty($_POST['password'])){
  //echo "No access=".$_POST['username'].":".$_POST['password']."<br>";
  exit;
}

include_once("ccfg.php");
include_once("chtmls.php");
include_once("cvars.php");
include_once("cdatabases.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
if($user_data == 0) {
  exit;
}

  global $fldINX;
  global $fldID;

  $inx_person = $_POST['inx'];
  $id_person = $_POST['id'];

  // Generate json file
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"
  $file = __DIR__ ."/cards/$number.card";
  file_put_contents($file, $_POST['persona']);

////////////////////////////////////////////////////////////
  file_put_contents("timestamp", $timestamp);
////////////////////////////////////////////////////////////

echo " PERSONA=".$_POST['persona'];

?>