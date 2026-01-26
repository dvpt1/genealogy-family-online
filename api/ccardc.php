<?php

if(empty($_POST['username']) || empty($_POST['password'])){
  //echo "No access=".$_POST['username'].":".$_POST['password']."<br>";
  exit;
}

include_once("../ccfg.php");
include_once("../csub.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
if($user_data == 0) {
  exit;
}

$p = __DIR__;
$mainPath = substr($p,0,strlen($p)-4);
$files = glob($mainPath."/cards/*.card");

$persons = [];
$response = array();
foreach ($files as $fileName) {

  $jsonData = file_get_contents("$fileName");
  $dataPerson = json_decode($jsonData, true);

  $persons[] = array_merge($dataPerson);
}

// Create new JSON with array
$response["success"] = 1;
$response["data"] = $persons;

$res = json_encode($response, JSON_UNESCAPED_UNICODE);
print_r($res);

?>