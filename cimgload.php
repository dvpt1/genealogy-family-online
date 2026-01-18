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
$id = str_replace(array("\r", "\n"), '', $id);

$number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"
$uploaddir = "fotos/$number/";
if (!file_exists($uploaddir)) {
  mkdir($uploaddir, 0777, true);
  //echo "Директория создана успешно!";
} else {
  //echo "Директория уже существует.";
}
//echo "path=$path<br>\n";

//echo "uploaddir = $uploaddir\n";
$file = basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir.$file;
//echo "uploadfile = $uploadfile\n";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "{$uploaddir}{$file}";
}

?>