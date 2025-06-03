<?php

include_once("ccfg.php");
//include_once("csub.php");
include_once("chtmls.php");

$user = _check_user($_COOKIE);

if(!isset($user['id']) || $user['id'] < 1 || empty($user['name'])){
	header("location:clogin.php");
	exit;
}

if (isset($_GET['load']) && isset($_GET['code'])) {
  $name = $_GET['load'];
  $pass = $_GET['code'];

  $user =_check_database($name, $pass);
  if($user['id'] > 0){
    //echo $user['id'];
    $ged = _readgedcom_database($user['id']);
    echo "<pre>".$ged[0][3]."|".$ged[0][2]."</pre>";
  }

  return 0;
}else
if (isset($_GET['save']) && isset($_GET['code']) && isset($_GET['gedcom'])) {
  $name = $_GET['save'];
  $pass = $_GET['code'];

  $user =_check_database($name, $pass);
  if($user['id'] > 0){
    //echo $user['id'];
    $gedc = $_GET['gedcom'];
    $currentDateTime = date('Y-m-d H:i:s');
    _savegedcom_database($user['id'],$gedc,$currentDateTime);
  }

  return 0;
}

//GLOBAL $userId, $userName;
//$userId = $user['id'];
//$userName = $user['name'];
setcookie('myfamilytree_userid', $user['id']);
setcookie('myfamilytree_username', $user['name']);

_begin_html($user);
_index_html($user);
_end_html($user);

?>