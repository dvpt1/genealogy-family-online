<?php
echo "cimgload.php\n";
echo "access=".$_POST['username'].":".$_POST['password']."\n\n";
//if(empty($_POST['username']) || empty($_POST['password'])) exit;

$fp = fopen("trace.txt", "w"); //creates a file to trace your data
fwrite($fp,"get \n");
fwrite($fp, print_r($_GET, true));
fwrite($fp,"POST \n");
fwrite($fp, print_r($_POST, true));//displays the POST 
fwrite($fp,"FILES \n");
fwrite($fp,print_r($_FILES,true));//display the FILES 
fclose($fp);


$myparam = $_POST["userfile"];
$mytextLabel = $_POST['filename'];
echo "myparam=$myparam\n";
echo "mytextLabel=$mytextLabel\n\n";


$uploadDir = 'foto/'; //you must create this directory
$uploadDir = $uploadDir.basename($_FILES['myfile']['name']); //saves the picture inside that folder
echo "uploadDir=$uploadDir\n";


$file = basename($_FILES['foto']['name']);
//$uploadedFile = $uploadDir.$file;
//move_uploaded_file($_FILES['uploaded']['tmp_name']);
echo "file=$file\n";


if(move_uploaded_file($_FILES['myfile']['tmp_name'],$uploadDir)){
	echo "the file ".basename($_FILES['myfile']['name'])." has been uploaded" ;
}else{
	echo "error";
} 

?>