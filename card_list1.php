<?php

$path = __DIR__ ;//. '/cardfile/';
//echo 'path='.$path."<br>";
//echo "<hr>";

$rootDir = __DIR__; // __DIR__ = C:\xampp\htdocs\CodeWall или любой друг путь к текущему каталогу
$allFiles = array_diff(scandir($rootDir . "/"), [".", ".."]); // с помощью array_diff удалаеям ссылки на текущий и родительский каталоги: ("." , "..")
print_r($allFiles);
echo "<hr>";

//glob("{$dir}*.{ jpg,jpeg,gif,ico,png}", GLOB_BRACE)
$files = glob($path."/*.card");
echo Count($files);
print_r($files);
echo "<hr>";

foreach (glob("*.card") as $filename) {
  echo "$filename size " . filesize($filename) . "\n";

  $json = file_get_contents("$filename");
  echo "<p>$json</p>";
  var_dump(json_decode($json));
}
echo "<hr>";

if (is_dir($path)) {
  if ($dh = opendir($path))
  {
    while (($file = readdir($dh)) !== false) {                
	$ext = pathinfo($file, PATHINFO_EXTENSION);
	if (strtolower($ext) == '.card') {
          clearstatcache();
          if(is_file($path."/".$file )) {    
            echo '';             
            echo $file;
            echo "|";                    
            echo "DATE:" . date ("F d, Y H:i:s", filemtime(utf8_decode($path."/".$file)));
            echo "|";
            echo "<br>";
          }                
        }                
    }            
    closedir($dh);
  }
}

echo "<hr>";

print_r(list_files(__DIR__));

function list_files($path)
{
	if ($path[mb_strlen($path) - 1] != '/') {
		$path .= '/';
	}
 
	$files = array();
	$dh = opendir($path);
	while (false !== ($file = readdir($dh))) {
		if ($file != '.' && $file != '..' && !is_dir($path.$file) && $file[0] != '.') {
			$files[] = $file;
		}
	}
 
	closedir($dh);
	return $files;
}
 
?>