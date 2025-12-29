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

$uploaddir = "cards/";
//echo "uploaddir = $uploaddir\n";
$file = basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir.$file;
//echo "uploadfile = $uploadfile\n";

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "{$uploaddir}{$file}";
}

?>