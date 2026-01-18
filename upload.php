<?php

$fp = fopen("trace.txt", "w"); //creates a file to trace your data
fwrite($fp,"get \n");
fwrite($fp, print_r($_GET, true));
fwrite($fp,"POST \n");
fwrite($fp, print_r($_POST, true));//displays the POST 
fwrite($fp,"FILES \n");
fwrite($fp,print_r($_FILES,true));//display the FILES 
fclose($fp);


$id = $_POST['id'];
$id = str_replace(array("\r", "\n"), '', $id);

$username = $_POST['username'];
$username = preg_replace("/\r|\n/", '', $username);

$password = $_POST['password'];
$password = preg_replace("/\r|\n/", '', $password);


echo "access=".$username.":".$password.":".$id."\n";

$number = str_pad($id, 6, '0', STR_PAD_LEFT); // "000001"
$uploaddir = "fotos/$number/";
echo "uploaddir = $uploaddir\n";
$file = basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir.$file;

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "transfer successful at:   http://YOURWEBSITE.COM/{$uploaddir}/{$file}";
}

?>