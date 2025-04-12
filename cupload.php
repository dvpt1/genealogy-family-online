<?php

include_once("cutils.php");
include_once("cvars.php");

//$user = _check_auth($_COOKIE);
//global $userId;
//$userId = $user['id'];

//$user = "admin@dnadata.online";//_check_user($_COOKIE);
$user = array();
$user['id']   = 1;
$userId = $user['id'];

Gedcom_Upload();

function Gedcom_Upload()
{
  global $userId;

echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';

// получаем язык
$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
$acceptLang = ['en', 'ru', 'fr', 'it', 'de', 'es', 'pt']; 
$lang = in_array($lang, $acceptLang) ? $lang : 'en';
if (!empty($_GET['lang'])) $lang = $_GET['lang'];
switch ($lang) {
case 'en':
  include_once("languages/en.php");
  break;
case 'ru':
  include_once("languages/ru.php");
  break;
case 'fr':
  include_once("languages/fr.php");
  break;
case 'it':
  include_once("languages/it.php");
  break;
case 'de':
  include_once("languages/de.php");
  break;
case 'es':
  include_once("languages/es.php");
  break;
case 'pt':
  include_once("languages/pt.php");
  break;
default: 
  include_once("languages/en.php");
  break;
}

//const
global $gedcoms;
global $gedcom;
global $userId;

global $succes01;

global $error01;
global $error02;
global $error03;
global $error04;
global $error05;
global $error06;
global $error07;
global $error08;
global $error09;
global $error10;
global $error11;
global $error12;
global $error13;
global $error14;

echo '<br><br><br><br>=== Upload ==<br>';
echo "<p><b><a href=https://dnadata.online/?lang=".$lang."> <<-- BACK <<-- </a>$userId==</b></p>";

$getfile = '';
if(isset($_COOKIE['myfamilytree_gedcom'])){
  $getfile = 'gedcom/'.$_COOKIE['myfamilytree_gedcom'];
}

if(isset($_POST['load'])){//если нажата 1-ая кнопка but1
  echo "LOAD=$getfile<br>";
}

if(isset($_POST['delete'])){//если нажата 2-ая кнопка but2
  echo "DELETE=$getfile<br>";
  setcookie("myfamilytree_gedcom", "", time() - 60*60*24*32);
  echo $error14."<br>";
  unlink($getfile);
}

// Название <input type="file">
$input_name = 'file';

// Разрешенные расширения файлов.
$allow = array();

// Запрещенные расширения файлов.
$deny = array(
	'phtml', 'php', 'php3', 'php4', 'php5', 'php6', 'php7', 'phps', 'cgi', 'pl', 'asp', 
	'aspx', 'shtml', 'shtm', 'htaccess', 'htpasswd', 'ini', 'log', 'sh', 'js', 'html', 
	'htm', 'css', 'sql', 'spl', 'scgi', 'fcgi'
);

// Директория куда будут загружаться файлы.
$path = __DIR__ . '/gedcom/';
echo 'path='.$path."<br>";

if (isset($_FILES[$input_name])) {
echo '===input_name='.$input_name.'<br>';
	// Проверим директорию для загрузки.
	if (!is_dir($path)) {
		mkdir($path, 0777, true);
	}

	// Преобразуем массив $_FILES в удобный вид для перебора в foreach.
	$files = array();
	$diff = count($_FILES[$input_name]) - count($_FILES[$input_name], COUNT_RECURSIVE);
	if ($diff == 0) {
		$files = array($_FILES[$input_name]);
	} else {
		foreach($_FILES[$input_name] as $k => $l) {
			foreach($l as $i => $v) {
				$files[$i][$k] = $v;
			}
		}		
	}	
	
	foreach ($files as $file) {
		$error = $success = '';

		// Проверим на ошибки загрузки.
		if (!empty($file['error']) || empty($file['tmp_name'])) {
			switch (@$file['error']) {
				case 1:
				case 2: $error = $error01; break;
				case 3: $error = $error02; break;
				case 4: $error = $error03; break;
				case 6: $error = $error04; break;
				case 7: $error = $error05; break;
				case 8: $error = $error06; break;
				case 9: $error = $error07; break;
				case 10: $error = $error08; break;
				case 11: $error = $error09; break;
				case 12: $error = $error10; break;
				default: $error = $error11; break;
			}
		} elseif ($file['tmp_name'] == 'none' || !is_uploaded_file($file['tmp_name'])) {
			$error = $error12;
		} else {
			// Оставляем в имени файла только буквы, цифры и некоторые символы.
			$pattern = "[^a-zа-яё0-9,~!@#%^-_\$\?\(\)\{\}\[\]\.]";
			$getfile = mb_eregi_replace($pattern, '-', $file['name']);
			$getfile = mb_ereg_replace('[-]+', '-', $getfile);
			
			// Т.к. есть проблема с кириллицей в названиях файлов (файлы становятся недоступны).
			// Сделаем их транслит:
			$converter = array(
				'а' => 'a',   'б' => 'b',   'в' => 'v',    'г' => 'g',   'д' => 'd',   'е' => 'e',
				'ё' => 'e',   'ж' => 'zh',  'з' => 'z',    'и' => 'i',   'й' => 'y',   'к' => 'k',
				'л' => 'l',   'м' => 'm',   'н' => 'n',    'о' => 'o',   'п' => 'p',   'р' => 'r',
				'с' => 's',   'т' => 't',   'у' => 'u',    'ф' => 'f',   'х' => 'h',   'ц' => 'c',
				'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch',  'ь' => '',    'ы' => 'y',   'ъ' => '',
				'э' => 'e',   'ю' => 'yu',  'я' => 'ya', 
			
				'А' => 'A',   'Б' => 'B',   'В' => 'V',    'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
				'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z',    'И' => 'I',   'Й' => 'Y',   'К' => 'K',
				'Л' => 'L',   'М' => 'M',   'Н' => 'N',    'О' => 'O',   'П' => 'P',   'Р' => 'R',
				'С' => 'S',   'Т' => 'T',   'У' => 'U',    'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
				'Ч' => 'Ch',  'Ш' => 'Sh',  'Щ' => 'Sch',  'Ь' => '',    'Ы' => 'Y',   'Ъ' => '',
				'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
			);

			$getfile = strtr($getfile, $converter);
			$parts = pathinfo($getfile);

			if (empty($getfile) || empty($parts['extension'])) {
				$error = $error13;
			} elseif (!empty($allow) && !in_array(strtolower($parts['extension']), $allow)) {
				$error = $error13;
			} elseif (!empty($deny) && in_array(strtolower($parts['extension']), $deny)) {
				$error = $error13;
			} else {
				// Чтобы не затереть файл с таким же названием, добавим префикс.
				$i = 0;
				$prefix = '';
				while (is_file($path . $parts['filename'] . $prefix . '.' . $parts['extension'])) {
		  			$prefix = '(' . ++$i . ')';
				}
				$getfile = $parts['filename'] . $prefix . '.' . $parts['extension'];

				// Перемещаем файл в директорию.
				if (move_uploaded_file($file['tmp_name'], $path . $getfile)) {
					// Далее можно сохранить название файла в БД и т.п.
					$success = '«'.$getfile .'» '.$succes01.'<br>';

					//setcookie('name', $getfile);
					setcookie('myfamilytree_gedcom', $getfile);
					$_COOKIE['myfamilytree_gedcom'] = $getfile;
				} else {
					$error = $error12;
				}
			}
		}
		
		// Выводим сообщение о результате загрузки.
		if (!empty($success)) {
echo "==== <b>$userId==$getfile</b> ===<br>";

			$gedcom = '';
			if($userId > 0){
			   $getfile = 'gedcom/'.$getfile;
//echo "==== <b>$userId==$getfile</b> ===<br>";
			   if (file_exists($getfile)) {
				$fp = fopen($getfile, "r");
				$gedcom = fread($fp, filesize($getfile));
				fclose($fp);

                                $currentDateTime = date('Y-m-d H:i:s');
                                /*$_id = _idgedcom_database($userId);
                                if($_id > 0){
					_savegedcom_database($_id,$gedcom,$currentDateTime);
                                }else{
					_addgedcom_database($userId,$gedcom,$currentDateTime);
                                }*/

echo "==== <b>cgedcomimp.php</b> ===<br>";
				include_once("cgedcomimp.php");
			   }
			}

			echo '<p>===Success=' . $success . '==</p>';		
		} else {
			echo '<p>===Error=' . $error . '==</p>';
		}
	}
}

echo "<p><b><a href=https://dnadata.online/?lang=".$lang."> <<-- BACK <<-- </a></b></p>";

}

?>