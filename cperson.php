<?php

include_once("cdatabases.php");

Person();

//рисует иконку, рамку, имя и дату
function Person()
{
  global $lang;

  global $fldINX;
  global $fldID;

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldPLB;
  global $fldPLD;
  global $fldPLL;
  global $fldPLT;
  global $fldMAPB;
  global $fldMAPD;
  global $fldMAPL;
  global $fldMAPT;
  global $fldOCCU;
  global $fldNATI;
  global $fldEDUC;
  global $fldRELI;
  global $fldICON;
  global $fldNOTE;
  global $fldCHAN;

  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $fldSPOUS1;
  global $fldSPOUS2;
  global $fldWEDDIN;
  global $fldPLACEW;
  global $fldMAPSW;

  global $fldTIMESTAMP;
  global $fldAVTOR;
  global $fldDATETIME;
  global $fldAVTORUP;
  global $fldDATETIMEUP;

  global $field_name;
  global $field_gender;
  global $field_father;
  global $field_mother;
  global $field_birth;
  global $field_death;
  global $field_placeb;
  global $field_placed;
  global $field_placet;
  global $field_foto;
  global $field_note;
  global $field_child;
  global $field_son;
  global $field_daughter;
  global $field_brother;
  global $field_sister;
  global $field_spouse;
  global $field_husband;
  global $field_wife;
  global $field_wedding;
  global $field_placew;
  global $field_placel;
  global $field_occu;
  global $field_nati;
  global $field_educ;
  global $field_reli;
  global $field_call;
  global $field_email;

  global $peoples;
  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;
  global $cnt_persons;
  global $inx_person;

  global $getdir;

  $id_person = $_GET['id'];
  $inx_person = IdToInx($id_person);

  $person = $persons[$inx_person];
  $gender = $person[$fldSEX];

  $htm = "";

  $htm .= "<div class='shadow' style='POSITION: absolute; LEFT: 10px; TOP: 60px; WIDTH: 975px; HEIGHT: 965px'>";
  if ($gender == "1")
  {
      $htm .= "<div class='blockm' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 960px; HEIGHT: 950px'>";
  }
  else if ($gender == "2")
  {
      $htm .= "<div class='blockw' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 960px; HEIGHT: 950px'>";
  }
  else
  {
      $htm .= "<div class='blockn' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 960px; HEIGHT: 950px'>";
  }

  $avtora = "";
  if($inx_person > -1){
    $people = $peoples[$inx_person];

    $avtora = $people[$fldAVTOR];
  }
  $htm .= "<center><b><i>$avtora</i></b></center>";
  //??$htm .= "<a href=\"cfotos.php?id=$id_person&name=$persona\"><img src=\"icons/mn_menu_foto.png\" width=48 height=48 align=right></a>";

  //$path = $getdir.$person[$fldPER].".jpg"; // Получаем путь к картинке
  //$htm .= "<p><img src='$path' alt='$person[$fldPER]' title='$person[$fldPER]' width='64' heigth='64' align=left></p>"; // Вывод превью картинки

  if(!empty($person[$fldICON])){
    $htm .= "<img src='data:image/jpeg;base64,".$person[$fldICON]."' width='64' heigth='64' align=left>";
  }else{
    $path = '';
    if($gender=='1') {$path = "icons/Avatar64_Man.png";}
    else if($gender=='2') {$path = "icons/Avatar64_Woman.png";}
    else {$path = "icons/Avatar64.png";}
    $htm .= "<img src='$path' alt='$name' title='$name' width='64' heigth='64' align=left>";
  }

  //$htm .= "inx=".$inx_person."<br>";
  $htm .= "<h1>".$person[$fldPER]."</h1><br>";

  if (!empty($person[$fldBEG]))
  {
      $htm .= "<p><i>".$field_birth."</i> <b>".$person[$fldBEG]."</b></p>";
  }
  
  if (!empty($person[$fldPLB]))
  {
      $htm .= "<p><i>".$field_placeb."</i> <b>".$person[$fldPLB]."</b></p>";
  }
  
  if (!empty($person[$fldEND]))
  {
      $htm .= "<p><i>".$field_death."</i> <b>".$person[$fldEND]."</b></p>";
  }

  if (!empty($person[$fldPLD]))
  {
      $htm .= "<p><i>".$field_placed."</i> <b>".$person[$fldPLD]."</b></p>";
  }

  if (!empty($person[$fldPLL]))
  {
      $htm .= "<p><i>".$field_placel."</i> <b>".$person[$fldPLL]."</b></p>";
  }

  if (!empty($person[$fldPLT]))
  {
      $htm .= "<p><i>".$field_placet."</i> <b>".$person[$fldPLT]."</b></p>";
  }

  //список отцов
  if (!empty($person[$fldFAT]))
  {
      for ($i = 0; $i < count($fathers); $i++) {
        if ($fathers[$i][0] == $inx_person) {
          $ii = $fathers[$i][1];
          $htm .= "<p><i>".$field_father."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
        }
      }
  }

  if (!empty($person[$fldMOT]))
  {
      for ($i = 0; $i < count($mothers); $i++) {
        if ($mothers[$i][0] == $inx_person) {
          $ii = $mothers[$i][1];
          $htm .= "<p><i>".$field_mother."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
        }
      }
  }

  // spouses
  for ($i = 0; $i < count($spouses); $i++) {
    if ($spouses[$i][$fldSPOUS1] == $inx_person) {
       $ii = $spouses[$i][$fldSPOUS2];
       $htm .= "<p><i>".$field_spouse."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
       $htm .= "<p><i>".$field_wedding."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$spouses[$i][$fldWEDDIN]."</a>"."</b></p>";
       $htm .= "<p><i>".$field_placew."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$spouses[$i][$fldPLACEW]."</a>"."</b></p>";
    }
  }
  for ($i = 0; $i < count($spouses); $i++) {
    if ($spouses[$i][$fldSPOUS2] == $inx_person) {
       $ii = $spouses[$i][$fldSPOUS1];
       $htm .= "<p><i>".$field_spouse."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
       $htm .= "<p><i>".$field_wedding."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$spouses[$i][$fldWEDDIN]."</a>"."</b></p>";
       $htm .= "<p><i>".$field_placew."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$spouses[$i][$fldPLACEW]."</a>"."</b></p>";
    }
  }

  //список детей
  if($person[$fldSEX] == "1")
  {
    for ($i = 0; $i < count($fathers); $i++) {
      if ($fathers[$i][1] == $inx_person) {
         $ii = $fathers[$i][0];
         $htm .= "<p><i>".$field_child."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
      }
    }
  }else if($person[$fldSEX] == "2")
  {
    for ($i = 0; $i < count($mothers); $i++) {
      if ($mothers[$i][1] == $inx_person) {
         $ii = $mothers[$i][0];
         $htm .= "<p><i>".$field_child."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
      }
    }
  }else{
    for ($i = 0; $i < count($fathers); $i++) {
      if ($fathers[$i][1] == $inx_person) {
         $ii = $fathers[$i][0];
         $htm .= "<p><i>".$field_child."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
      }
    }
    for ($i = 0; $i < count($mothers); $i++) {
      if ($mothers[$i][1] == $inx_person) {
         $ii = $mothers[$i][0];
         $htm .= "<p><i>".$field_child."</i> <b>"."<a href=?lang=".$lang."&do=person&inx=".$ii.">".$persons[$ii][$fldPER]."</a>"."</b></p>";
      }
    }
  }

  if (!empty($person[$fldOCCU]))
  {
      $htm .= "<p><i>".$field_occu."</i> <b>".$person[$fldOCCU]."</b></p>";
  }
  if (!empty($person[$fldNATI]))
  {
      $htm .= "<p><i>".$field_nati."</i> <b>".$person[$fldNATI]."</b></p>";
  }
  if (!empty($person[$fldEDUC]))
  {
      $htm .= "<p><i>".$field_educ."</i> <b>".$person[$fldEDUC]."</b></p>";
  }
  if (!empty($person[$fldRELI]))
  {
      $htm .= "<p><i>".$field_reli."</i> <b>".$person[$fldRELI]."</b></p>";
  }

  if (!empty($person[$fldNOTE]))
  {
      $htm .= "<p><i>".$field_note."</i> <b>".$person[$fldNOTE]."</b></p>";
  }


  $htm .= "</div></div>";

  echo $htm;

  return $htm;
}

?>
