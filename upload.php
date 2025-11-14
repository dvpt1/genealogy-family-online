<?php

$fp = fopen("trace.txt", "w"); //creates a file to trace your data
fwrite($fp,"get \n");
fwrite($fp, print_r($_GET, true));
fwrite($fp,"POST \n");
fwrite($fp, print_r($_POST, true));//displays the POST 
fwrite($fp,"FILES \n");
fwrite($fp,print_r($_FILES,true));//display the FILES 
fclose($fp);


$id = basename($_FILES['id']['name']);
echo "access=".$_POST['username'].":".$_POST['password'].":".$id."\n";

$uploaddir = 'foto/';
$file = basename($_FILES['userfile']['name']);
$uploadfile = $uploaddir.$file;

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
        echo "transfer successful at:   http://YOURWEBSITE.COM/{$uploaddir}/{$file}";
}

?>