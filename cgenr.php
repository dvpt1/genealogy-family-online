<?php

// Константы и типы для постороения древа
$level = -1;
$summary = "";
$html = "";
$family = -1;
$cnt = -1;

// TMens = record
$aPerson = array();
$aFamily = array();
$aLevel = array();
//end;

Genr();

//рисую все генеалогические ветви и фамилии
function Genr()
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

  global $aPerson;
  global $aFamily;
  global $aLevel;

  global $family;
  global $level;
  global $cnt;

  global $ttl_Genr;
  global $nam_Genr;

  //progenitors
  $progenitors = array();
  for ($i = 0; $i < count($persons); $i++) {
    if (empty($persons[$i][$fldFAT]) && empty($persons[$i][$fldMOT])) {
       $progenitors[] = $i;
    }
  }

  $family = 0;
  for ($i = 0; $i < count($progenitors); $i++)
  {
    $family++;
    ParentpChilds($progenitors[$i]);
  }

  if (count($progenitors) > 0)
  {
    // выращивание
    $family = 1;
    $cnt = 0;

    $html = "";
    $html .= "<p>&nbsp;</p>";
    $html .= "<H2>".$persons[0][$fldPER]."</H2>";
    $html .= "<p>&nbsp;</p>";
    $html .= "<table width='100%' border=2>";
    $html .= "<tr><td align='center' valign='top' width='10%'>NN</td>";
    $html .= "<td align='center' valign='top' width='10%'>".$ttl_Genr."</td>";
    $html .= "<td width='80%'>".$nam_Genr."</td></tr>";

    for ($i = 0; $i < count($aPerson); $i++)
    {
        if ($family != $aFamily[$i])
        {
            $ii = $aPerson[$i];
            $html .= "</table>";
            $html .= "<p>&nbsp;</p>";
            $html .= "<H2>".$persons[$ii][$fldPER]."</H2>";
            $html .= "<p>&nbsp;</p>";
            $html .= "<table width='100%' border=2>";
            $html .= "<tr><td align='center' valign='top' width='10%'>NN</td>";
            $html .= "<td align='center' valign='top' width='10%'>".$ttl_Genr."</td>";
            $html .= "<td width='80%'>".$nam_Genr."</td></tr>";

            $family = $aFamily[$i];
            $cnt = 0;
        }

        $cnt++;
        $html .= DrawMenGenr($i);
    }
    $html .= "</table>";

    echo $html;
  }
}

function ParentpChilds($person)
{
//  echo $person."<br>";

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;

  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  global $getdir;

  global $aPerson;
  global $aFamily;
  global $aLevel;

  global $level;
  global $family;
  global $cnt;

  $level++;

  AddInfo($person, $family, $level);

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

  for ($i = 0; $i < count($childrens); $i++)
  {
     ParentpChilds($childrens[$i]);
  }

  $level--;
}

function AddInfo($PersonId, $FamilyId, $LevelId)
{
  global $aPerson;
  global $aFamily;
  global $aLevel;

  $aPerson[] = $PersonId;
  $aFamily[] = $FamilyId;
  $aLevel[] = $LevelId;
}

//рисует иконку, рамку, имя и дату
function DrawMenGenr($Index)
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

  global $aPerson;
  global $aFamily;
  global $aLevel;

  global $cnt;

  $htm = "";

  $I = $aPerson[$Index];
  $F = $aFamily[$Index];
  $L = $aLevel[$Index];

  $person = $persons[$I];

  $htm .= "<tr><td align='center' valign='top' width='10%'>".$cnt."</td>";
  $htm .= "<td align='center' valign='top' width='10%'>".$L."</td>";
  $htm .= "<td width='80%'>";

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

  $htm .= "<b>".$person[$fldPER]."</b><br>";

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
  $htm .= "<br><i>".$dates."</i></font>";

  $htm .= "</td></tr>";

  return $htm;
}


?>