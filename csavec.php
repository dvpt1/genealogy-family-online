<?php

if(empty($_POST['username']) || empty($_POST['password'])){
  //echo "No access=".$_POST['username'].":".$_POST['password']."<br>";
  exit;
}

include_once("ccfg.php");
include_once("csub.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
if($user_data == 0) {
  exit;
}

echo $_POST['username']."<br>";
echo $_POST['password']."<br>";
echo $_POST['persona']."<br>";
echo $_POST['birth']."<br>";
echo $_POST['death']."<br>";

//$mainPath = __DIR__ ;//. '/cardfile/';
//$files = glob($mainPath."/cards/*.card");
//print_r($files);

?>