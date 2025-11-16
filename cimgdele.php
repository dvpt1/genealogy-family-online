<?php
//echo "cimgload.php\n";

$username = $_POST['username']; $username = preg_replace("/\r|\n/", '', $username);
$password = $_POST['password']; $password = preg_replace("/\r|\n/", '', $password);
//echo "access=".$_POST['username'].$_POST['password'].$_POST['id']."\n\n";
if(empty($username) || empty($password)) exit;

include_once("ccfg.php");
include_once("csub.php");

$user_data = _check_database($username, $password);
if($user_data == 0) exit;

$id = $_POST['id'];
$id_person = str_replace(array("\r", "\n"), '', $id);
$dir = __DIR__."/fotos/$id_person/"; // Путь к директории, в которой лежат изображения

//$uploaddir = "fotos/$id_person/";
//echo "uploaddir = $uploaddir\n";
$file = basename($_FILES['userfile']['name']);
$uploadfile = $dir.$file;
echo "uploadfile = $uploadfile\n";

unlink($uploadfile);

?>