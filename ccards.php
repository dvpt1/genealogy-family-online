<?php

$mainPath = __DIR__ ;//. '/cardfile/';
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

// Generate json file
//file_put_contents("data.json", $res);
?>