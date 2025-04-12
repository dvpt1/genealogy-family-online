<?php

include_once("vars.php");

  global $page;
  global $cellw;
  global $cellh;

  global $edtt, $lgnmail, $pwdold, $pwdnew1, $pwdnew2, $pwdizm, $fio, $country, $post, $city, $adres, $phone, $www, $note, $registr, $save, $delete, $questdel; 

  global $field_name;
  global $field_gender;
  global $field_father;
  global $field_mother;
  global $field_birth;
  global $field_death;
  global $field_placeb;
  global $field_placed;
  global $field_placet;


  $msg = $GLOBALS["msg"];
  if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";

// получаем язык
if (!empty($_GET['lang'])) {
  $lang = $_GET['lang'];
  setcookie('myfamilytree_lang', $lang);
  $_COOKIE['myfamilytree_lang'] = $lang;
}else{
 if(isset($_COOKIE['myfamilytree_lang'])){   //echo 'Куки успешно установлены!<br>';
  $lang = $_COOKIE['myfamilytree_lang'];
 }else{   //echo 'Куки НЕ установлены!<br>';
  $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
  $acceptLang = ['en', 'ru', 'fr', 'it', 'de', 'es', 'pt']; 
  $lang = in_array($lang, $acceptLang) ? $lang : 'en';
  setcookie('myfamilytree_lang', $lang);
  $_COOKIE['myfamilytree_lang'] = $lang;
 }
}
//echo "<br><br><br><br>LANG=".$lang."<br>";

//$url = $_SERVER['REQUEST_URI'];
//echo "<br><br><br><br><br>".$url."<br>";

  switch ($lang) {
  case 'en': include_once("languages/en.php"); break;
  case 'ru': include_once("languages/ru.php"); break;
  case 'fr': include_once("languages/fr.php"); break;
  case 'it': include_once("languages/it.php"); break;
  case 'de': include_once("languages/de.php"); break;
  case 'es': include_once("languages/es.php"); break;
  case 'pt': include_once("languages/pt.php"); break;
  default:   include_once("languages/en.php"); break;
  }

  $fileName = "";
  if (isset($_GET['inx']))
  {
    $fileName = $_GET['inx'];
  }
  
  // Read the file into a variable
  $jsonData = file_get_contents("$fileName");
  // Decode the JSON data into a PHP associative array
  $dataPerson = json_decode($jsonData, true);
  //print_r($dataPerson);
  
  $lastname = $dataPerson['lastname'];
  $firstname = $dataPerson['firstname'];
  $surname = $dataPerson['surname'];
  $gender = $dataPerson['gender'];

?>


 <form name="editperson" action="index.php?do=persone&inx=<?php echo $inx_person; ?>&edit=1" method="post">

 <table width="100%" align="left" border="0" cellpadding="2">

 <tr style="outline: thin solid"><td width=25%><?php echo $field_name; ?></td>
  <td width=75%><input type="text" name="persona" size="60" value="<?php echo $lastname; ?>"></td>
 </tr>

 <tr style="outline: thin solid"><td width=25%><?php echo $field_name; ?></td>
  <td width=75%><input type="text" name="persona" size="60" value="<?php echo $firstname; ?>"></td>
 </tr>

 <tr style="outline: thin solid"><td width=25%><?php echo $field_name; ?></td>
  <td width=75%><input type="text" name="persona" size="60" value="<?php echo $surname; ?>"></td>
 </tr>

 <tr><td><?php echo $field_birth; ?></td>
  <td><input type="text" name="birth" size="25" value="<?php echo $birtha; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placeb; ?></td>
  <td><input type="text" name="placeb" size="60" value="<?php echo $placeba; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placel; ?></td>
  <td><input type="text" name="placel" size="60" value="<?php echo $placela; ?>"></td>
 </tr>

 <tr><td><?php echo $field_death; ?></td>
  <td><input type="text" name="death" size="25" value="<?php echo $deatha; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placed; ?></td>
  <td><input type="text" name="placed" size="60" value="<?php echo $placeda; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placet; ?></td>
  <td><input type="text" name="placet" size="60" value="<?php echo $placeta; ?>"></td>
 </tr>

 <tr><td><?php echo $field_occu; ?></td>
  <td><input type="text" name="occu" size="60" value="<?php echo $occua; ?>"></td>
 </tr>

 <tr><td><?php echo $field_nati; ?></td>
  <td><input type="text" name="nati" size="60" value="<?php echo $natia; ?>"></td>
 </tr>

 <tr><td><?php echo $field_educ; ?></td>
  <td><input type="text" name="educ" size="60" value="<?php echo $educa; ?>"></td>
 </tr>

 <tr><td><?php echo $field_reli; ?></td>
  <td><input type="text" name="reli" size="60" value="<?php echo $relia; ?>"></td>
 </tr>

 <tr><td><?php echo $field_note; ?></td>
  <td><textarea name="notes" rows="5" cols="80"><?php echo $notesa; ?></textarea></td>
 </tr>

 <tr><td colspan="2" align="center">
  <input type="submit" name="saveperson" value="<?php echo $save; ?>">
  </td>
 </tr>

 </table>

 </form>

<?  
?>