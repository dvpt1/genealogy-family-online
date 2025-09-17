<?php

include_once("cvars.php");
include_once("cdatabases.php");

// Константы и типы для постороения древа
$level = -1;
$summary = "";
$html = "";

$aHtml = array();

Rings();

//рисую все генеалогические ветви и фамилии
function Rings()
{
//echo "<br><br><br><br><br><br>";

  global $html;
  global $level;

  $html = "";
  ringAllsPerson();
  echo $html;

  return "";
}


//рисую генеалогические круги
function ringAllsPerson()
{
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  //progenitors
  $progenitors = array();
  $id_person = -1;
  if (!empty($_GET['id'])) $id_person = $_GET['id'];
  if($id_person == -1)
  {
    for ($i = 0; $i < count($persons); $i++) {
      if (empty($persons[$i][$fldFAT]) && empty($persons[$i][$fldMOT])) {
         $progenitors[] = $i;
      }
    }
  }else{
      $inx_person = IdToInx($id_person);
      $progenitors[] = $inx_person;
  }

  for ($i = 0; $i < count($progenitors); $i++)
  {
      ringsPerson($progenitors[$i]);
  }
}

//рисую генеалогические круги
function ringsPerson($person)
{
//echo "$person<br>";

  global $html;
  global $level;
  global $aHtml;

  $aHtml = array();

  $level = 0;
  $aHtml[$level] = "<td>".DrawMenRing($person)."</td>";

  ParentsHi($person);

  // рисую
  for ($i = 0; $i < count($aHtml); $i++)
  {
      $html .= "<table style='border: ".(($i + 1) * 2)."px solid green; background: silver; padding: 10px'>";
      $html .= "<tr><td bordercolor=Green bordercolordark=teal align=center valign=center>";
      $html .= "<table><tr><td>".($i + 1).".</td>".$aHtml[$i]."</tr></table>";
  }
  for ($i = 0; $i < count($aHtml); $i++)
  {
      $html .= "</td></tr></table>";
  }
}

function ParentsHi($person)
{
  global $fldPER;
  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  global $aHtml;
  global $level;

  //список детей
  $childrens = array();
  for ($i = 0; $i < count($fathers); $i++) {
    if (strcmp($fathers[$i][1], $person) == 0) {
       $childrens[] = $fathers[$i][0];
    }
  }
  for ($i = 0; $i < count($mothers); $i++) {
    if (strcmp($mothers[$i][1], $person) == 0) {
       $childrens[] = $mothers[$i][0];
    }
  }

  if (count($childrens) == 0) return;

  $level++;

  if (count($aHtml) - 1 < $level) $aHtml[$level] = "";

  for ($i = 0; $i < count($childrens); $i++)
  {
      $father = $childrens[$i];

      $htm = $aHtml[$level];
      $aHtml[$level] = $htm."<td>".DrawMenRing($father)."</td>";

      ParentsHi($father);
  }

  $level--;
}

//рисует иконку, рамку, имя и дату
function DrawMenRing($I)
{
  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $persons;
  global $getdir;

  $person = $persons[$I];

  $htm = "";

  $htm .= "<div class='shadow' style='WIDTH: 235px; HEIGHT: 80px'>";
  if ($person[$fldSEX] == "1")
  {
      $htm .= "<div class='blockm' style='WIDTH: 220px; HEIGHT: 65px'>";
  }
  else
  if ($person[$fldSEX] == "2")
  {
      $htm .= "<div class='blockw' style='WIDTH: 220px; HEIGHT: 65px'>";
  }
  else
  {
      $htm .= "<div class='blockn' style='WIDTH: 220px; HEIGHT: 65px'>";
  }

  //$path = $getdir.$person[$fldPER].".jpg"; // Получаем путь к картинке
  //$htm .= "<img src='$path' alt='$person[$fldPER]' title='$person[$fldPER]' width='48' heigth='48' align=left>"; // Вывод превью картинки

  if(!empty($person[$fldICON])){
    $htm .= "<img src='data:image/jpeg;base64,".$person[$fldICON]."' width='48' heigth='48' align=left>";
  }else{
    $path = '';
    if($person[$fldSEX]=='1') {$path = "icons/Avatar64_Man.png";}
    else if($person[$fldSEX]=='2') {$path = "icons/Avatar64_Woman.png";}
    else {$path = "icons/Avatar64.png";}
    $htm .= "<img src='$path' alt='$name' title='$name' width='48' heigth='48' align=left>";
  }

  $dates = "";
  if (!empty($person[$fldBEG]) && !empty($person[$fldEND]))
  {
      $dates = "(".$person[$fldBEG]."..".$person[$fldEND].")";
  }
  else if (!empty($person[$fldBEG]))
  {
      $dates = "(".$person[$fldBEG].")";
  }
  else if (!empty($person[$fldEND]))
  {
      $dates = "(..".$person[$fldEND].")";
  }

  $htm .= "<font size=-1>".$person[$fldPER];
  $htm .= "<br><i>".$dates."</i></font>";
  $htm .= "</div>";
  $htm .= "</div>";

  return $htm;
}

?>