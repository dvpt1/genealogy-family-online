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

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;

  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  if(count((array)$persons) == 0){
	include_once("cimport.php");
  }

  $inx_person = $_POST['inx'];
  $id_person = $_POST['id'];

  // delete persone
  unset($persons[$inx_person]);
  ///////////////////////////////////////////////////// delete
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"

  $p = __DIR__;
  $mainPath = substr($p,0,strlen($p)-4);

  $file = "$mainPath/cards/$number.card";
  unlink($file);

////////////////////////////////////////////////////////////
  $timestamp = date('YmdHisu');
  file_put_contents("../timestamp", $timestamp);
////////////////////////////////////////////////////////////

echo "PERSONA ID=".$_POST['id'];

?>