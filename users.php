<?
$dir0 = dirname(__FILE__) .'/'.$_FILES['inputfile']['name'];
move_uploaded_file($_FILES['inputfile']['tmp_name'], $dir0 );
echo $_GET['inputfiles'];
?>