<?php

include_once("cvars.php");
include_once("cdatabases.php");

Forest();

//рисую все генеалогические ветви и фамилии
function Forest()
{
  global $cnt_persons;

  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  global $aPerson;
  global $aFather;
  global $aMother;
  global $aSpouse;
  global $aBougth;
  global $aX1;
  global $aY1;
  global $aX2;
  global $aY2;

  global $fldINX;
  global $fldID;
  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $fldPAREN;

  global $level;
  global $iX2;
  global $iY2;
  global $maxX;
  global $maxY;

echo "<br><br><br><br><br><br>";

  $maxX = -240;
  $maxY = 0;
  $level = 0;
  $ibegin = 0;
  $html = "";
  $serror = "";
  $view_direct = 0;
  
  //заполняю элементы списка
  $cnt_persons = count($persons);
  for ($i = 0; $i < count($persons); $i++)
  {
      $aBougth[] = 0;
      $aX1[] = 0;
      $aY1[] = 0;
  }

  // расчеты
  $progenitors = array();
  $id_person = -1;
  if (!empty($_GET['id'])) $id_person = $_GET['id'];
  if($id_person == -1)
  {
      $progenitors = getProgenitors();
  }else{
      $inx_person = IdToInx($id_person);
      $progenitors[] = $persons[$inx_person];
  }

  // ищу детей
  $level = 0;
  for ($i = 0; $i < count($progenitors); $i++)
  {
      $sex = (int)$progenitors[$i][$fldSEX];
      if ($sex == 1)
      {
          $ibegin = count($aPerson);
          ParentsChilds($progenitors[$i][$fldINX], $progenitors[$i][$fldID], $maxX + 250, 10);
      }
  }
  for ($i = 0; $i < count($progenitors); $i++)
  {
      $sex = (int)$progenitors[$i][$fldSEX];
      if ($sex == 2)
      {
          $ibegin = count($aPerson);
          ParentsChilds($progenitors[$i][$fldINX], $progenitors[$i][$fldID], $maxX + 250, 10);
      }
  }

  // инверсия
  $view_direct = 0;
  if ($view_direct != 0)
  {
      $maxY = $maxY + 10;
      $y1 = 0;
      for ($i = 0; $i < count($persons); $i++)
      {
          if ($aY1[$i] != -1)
          {
              $y1 = maxY - $aY1[$i];
              $aY1[$i] = $y1;
          }
      }
  }else{
      for ($i = 0; $i < count($persons); $i++)
      {
          if ($aY1[$i] != -1)
          {
              $aY1[$i] = $aY1[$i] + 60;
          }
          /*if ($aX1[$i] != -1)
          {
              $aX1[$i] = $aX1[$i] - 200;
          }*/
      }
  }

  // Рисую ФИО
  for ($i = 0; $i < count($persons); $i++)
  {
//echo "=== boxperson ===".$i.">=".$aX1[$i].":".$aY1[$i]."=".$persons[$i][$fldPER]."<br>";
      echo DrawPerson($i, $aX1[$i], $aY1[$i]);
  }

  // Рисую ветки
  for ($i = 0; $i < count($persons); $i++)
  {
      //список отцов
      $ifathers = getFathers($persons[$i][$fldINX]);
      for ($iFat = 0; $iFat < count($ifathers); $iFat++)
      {
          if ($view_direct == 0)
          {
              echo Linkas($ifathers[$iFat][$fldPAREN], $i, true);
          }
          else
          {
              echo Linkas1($ifathers[$iFat][$fldPAREN], $i, true);
          }
      }

      //список матерей
      $imothers = getMothers($persons[$i][$fldINX]);
      for ($iMot = 0; $iMot < count($imothers); $iMot++)
      {
          if ($view_direct == 0)
          {
              echo Linkas($imothers[$iMot][$fldPAREN], $i, false);
          }
          else
          {
              echo Linkas1($imothers[$iMot][$fldPAREN], $i, false);
          }
      }
  }

  echo "<table><tr><td>&nbsp;</td></tr></table>";
  return "";
}


function ParentsChilds($PersonInx, $PersonId, $X, $Y)
{
//echo "=== ParentsChilds ===".$PersonInx.":".$PersonId."=".$X.":".$Y."=<br>";

  global $cnt_persons;

  global $fldINX;
  global $fldID;

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;

  global $fldCHILD;
  global $fldPAREN;
  global $fldFATHE;
  global $fldMOTHE;
  global $fldSPOUS1;
  global $fldSPOUS2;

  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  global $level;
  global $iX2;
  global $iY2;
  global $maxX;
  global $maxY;

  $b = false;
  $dX = 0;
  $dY = 0;
  $iCol = 0;

//echo "=== ParentsChilds ===[".$PersonId."]=".$X.":".$Y."=".$persons[$PersonInx][$fldPER]." = $PersonInx<br>";

  $b = AddInfo($PersonInx, $X, $Y, true);
  if (!$b) return $dX;

  $level++;

  //список детей
  $childers1 = getFatherc($PersonInx);
  $childers2 = getMotherc($PersonInx);

//print_r($childers1); echo "=== childers1<br>";
//print_r($childers2); echo "=== childers2<br>";
//echo "=== ParentsChilds count===[".count($childers1)."]=[".count($childers2)."]<br>";

  // если отец или мать
  if (count($childers1) > 0)
  {
    for ($iFat = 0; $iFat < count($childers1); $iFat++)
    {
      $imothers = getMothers($childers1[$iFat][$fldCHILD]);
//print_r($imothers); echo "=== imothers<br>";

      for ($iMot = 0; $iMot < count($imothers); $iMot++)
      {
          $dX = $dX + 250;
          $b = AddInfo($imothers[$iMot][$fldPAREN], $X + $dX, $Y, false);
          if (!$b) break;
      }

      //if (b)
      //{
      $inx = $childers1[$iFat][$fldCHILD];
      $id = $persons[$inx][$fldID];
      $dY = $dY + ParentsChilds($inx, $id, $dY + $X + 50 + 250 * $iCol, $Y + 150);
      $iCol++;
      //}
    }
  }
  else if (count($childers2) > 0)
  {
    for ($iMot = 0; $iMot < count($childers2); $iMot++)
    {
      $ifathers = getFathers($childers2[$iMot][$fldCHILD]);
//print_r($ifathers); echo "=== ifathers<br>";

      /*for ($iFat = 0; $iFat < count($ifathers); $iFat++)
      {
          $dX = $dX + 250;
          $b = AddInfo($ifathers[$iFat][$fldPAREN], $X + $dX, $Y, false);
          if (!$b) break;
      }*/

      if (count($ifathers) == 0)
      {
         $inx = $childers2[$iMot][$fldCHILD];
         $id = $persons[$inx][$fldID];
         $dY = $dY + ParentsChilds($inx, $id, $dY + $X + 50 + 250 * $iCol, $Y + 150);
         $iCol++;
      }
    }
  }

  $level--;

  return $dX;
}

function AddInfo($Inx, $X, $Y, $B)
{
  global $fldPER;
  global $field_name;
  global $field_gender;
  global $field_parent;
  global $field_child;
  global $persons;
  global $aPerson;
  global $aFather;
  global $aMother;
  global $aSpouse;
  global $aBougth;
  global $aX1;
  global $aY1;
  global $aX2;
  global $aY2;
  global $maxX;
  global $maxY;
  global $ibegin;
  global $level;

//echo "=== AddInfo =[".$Inx."]=".$X.":".$Y."=".$persons[$Inx][$fldPER]." $level<br>";

  if ($B){

      for ($i = $ibegin; $i < count($aPerson); $i++)
      {
          if ($aPerson[$i] == $Inx)
          {
              $serror .= $field_name." ".$persons[$Inx][$fldPER]." ??? ";

              $parents = getParentsI($Inx);
//  echo "=== AddInfo parents=".count($parents)."<br>";
              if (count($parents) > 0)
              {
                  $serror .= "{".$field_parent;
                  for ($ii = 0; $ii < count($parents); $ii++)
                  {
                      $parent = $persons[$parents[$ii]];
                      $serror .= " ".$parent[$fldPER]." : ";
                  }
                  $serror .= "}";
              }

              $childrs = getChildrensI($Inx);
//  echo "=== AddInfo childrs=".count($childrs)."<br>";
              if (count($childrs) > 0)
              {
                  $serror .= "{".$field_child;
                  for ($ii = 0; $ii < count($childrs); $ii++)
                  {
                      $childr = $persons[$childrs[$ii]];
                      $serror .= " ".$childr[$fldPER]." : ";
                  }
                  $serror .= "}";
              }

              $serror .= "\r\n";

              return false;
          }
      }
  }

  if (($aX1[$Inx] > 0) && ($aY1[$Inx] > 0)) return false;

  $aPerson[] = $Inx;
  $aX1[$Inx] = $X;
  $aY1[$Inx] = $Y;

  $aBougth[$Inx] = $level + 1;

  if ($maxY < $Y) $maxY = $Y;
  if ($maxX < $X) $maxX = $X;

  return true;
}

//рисует иконку, рамку, имя и дату
function DrawPerson($I, $X, $Y)
{
  if ($X == 0) return;
  $Y = $Y + 5;

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $persons;
  $person = $persons[$I];

//echo "=== DrawPerson =".$I."=".$X.":".$Y."=".$persons[$I][$fldPER]."<br>";

  $htm = "";

  $htm .= "<div class='shadow' style='POSITION: absolute; LEFT: ".$X."px; TOP: ".$Y."px; WIDTH: 225px; HEIGHT: 75px'>";
  if ($person[$fldSEX] == "1")
  {
      $htm .= "<div class='blockm' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 220px; HEIGHT: 73px'>";
  }
  else if ($person[$fldSEX] == "2")
  {
      $htm .= "<div class='blockw' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 220px; HEIGHT: 73px'>";
  }
  else
  {
      $htm .= "<div class='blockn' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 220px; HEIGHT: 73px'>";
  }

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
  $htm .= "</div></div>";

  return $htm;
}

//связываю родителя с ребенком
function Linkas($iParent, $iChild, $fm)
{
  global $aBougth;
  global $aX1;
  global $aY1;

  if ($aX1[$iParent] == 0) return;
  if ($aX1[$iChild] == 0) return;

  $slf = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAoUlEQVQ4y6VUwQ2DMAw8Iz/5dwAWYAM2YARm6EodoRswCAPw58njeGAklBJqB0uWzrHOiXx2hCQiJoACWIEdeEm1weU4UwfpZXBOc3pDagxO2cokfxxke5lIXJPbOoOjpw9qpN7ib6j1IAfPE69cEBX6ZBUeWAXgXUoWkhBgsPgTJp+kinU9MyRdqQLuKZM7pf7Nt3hkts2ai8i5fZYnP8kGli/Uxlzf6aUAAAAASUVORK5CYII=";
  $srf = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAkklEQVQ4y2Nk+P//PwMEsP5nYPjDQAJgRNLMwMDAwMvAwMDwn4HhCzmaYUACashLcjTDgArUkLvYpf///08ENsAmTMhmZOAAdcVBYp2NDfhDDdlEjmYYiKdEMwMTAwWAEs0FLOT4FRpgi1jICWVSE4k9NmEGclPX////GVjIT9cMODVLEMpR2DSTlJ+RNZNckgAAQiW090LLfVwAAAAASUVORK5CYII=";
  $slm = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAy0lEQVQ4y51UywrCQAycaasgeBA89Buk3UNBEIr0/z/BHxGEbRsPWaWrW9sYWJJ9zAaSmVBEYDKSgOsAoDCAcg2qDsAIAFzMzGoboqu6fHhdzWdmuwtPWvXSfz5Jg1nvAbmETP3c/zGYzUGD7AzAL5VBwTwddbtpwrlfVUNBXQJ0FtAk81gDuccflllanQA/bsBQ6DKSTUQAujJsna1gU4bFVfc2cNTvYbHX89xewbLfwnjz+96muM1VelZlfamKq4dBpOdstIETk+QJPc4/99t6KdIAAAAASUVORK5CYII=";
  $srm = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAA60lEQVQ4y52UwWrCQBCGv0k2pwr1NYp6CPQgXtpHr7YED4WCwaqP4EFQKBRM4vQwuoqGJusPy4Ys38zO/LsryuAFAPIJqkqAovNn7xWRGJG4LSznzADVCfwAQOf7ANj/djY/ZBYk+23Y9qW0tLEbwW6E9DsB8ElxaSMaImkXSbuXq65lbwqonq2ipy/b3GLjApwpbEpSCzLIQ+CrIId+xN1y3JG5OjLlMgROjgbl1rDV2rUHC9/lEKsSiD/R2fa26sbaZIrOfupbVn/kHTz+e65rYH+r3tFs32yW1yGC77Fl06qd017zt9CX5A9yv0qOfEX5MgAAAABJRU5ErkJggg==";
  $sl = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAUCAYAAABSx2cSAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAHWlUWHRDb21tZW50AAAAAABDcmVhdGVkIHdpdGggR0lNUGQuZQcAAABUSURBVDjLvdQ7DgAgCANQ6v3vjINhgUj4aSeX10RFQdkwsSxRhXGsUBxfoI8d5OMAtDiILE7CgwtIsqiRFkZ1vwMHVrzj4SFJljx+VU4B/v0kqmAD2Nwj83govDEAAAAASUVORK5CYII=";
  $sr = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAUCAYAAABSx2cSAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAZ0lEQVQ4y82UwQ7AIAhDXwn//8vutMRlY6Gc7M2YZwuiYrG4JYSheKz2gxpSCTRSRLnTSKFW1CJFtIorDOQ2aU8RuNrMfGe75rNgoZiCADm9Ji/2x5TldDT/4fGran4KOYHeziYIcAHLKxI05jBcLAAAAABJRU5ErkJggg==";
  
  if ($fm)
  {
      $sl = $slf;
      $sr = $srf;
  }
  else
  {
      $sl = $slm;
      $sr = $srm;
  }

  $aX1c = $aX1[$iChild];
  $aY1c = $aY1[$iChild];
  $aX1p = $aX1[$iParent];
  $aY1p = $aY1[$iParent];
  $aB1c = $aBougth[$iChild];
  $aB1p = $aBougth[$iParent];

//echo "=== Links =$iChild==$iParent == [$aX1c]=[$aY1c] == [$aX1p]=[$aY1p] == [$aB1c]=[$aB1b]<br>";

  $htm = "";

  //$htm .= "=== $iParent =11= $aBougth[$iParent]:$aX1[$iParent]:$aY1[$iParent]<br>";
  //$htm .= "=== $iChild =21= $aBougth[$iChild]:$aX1[$iChild]:$aY1[$iChild]<br>";
  //return $htm;

  // если
  if ($aX1p > $aX1c)
  {

      if ($aY1p > $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px; TOP: ".($aY1c + 90 + $aB1c * 3)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1p - $aX1c + 2)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1c + 90 + $aB1c * 3)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1p - $aY1c - 90 - $aB1c * 3)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sl."' style='POSITION: absolute; LEFT: ".($aX1c + 100 + (($aX1p - $aX1c) / 2))."px; TOP: ".($aY1c + 90 + $aB1c * 3 - 9)."px'></div>";

      }
      else if ($aY1p < $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c - $aB1c * 3)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px; TOP: ".($aY1c - $aB1c * 3)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1p - $aX1c + 2)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p - 90 - $aB1c * 3)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sl."' style='POSITION: absolute; LEFT: ".($aX1c + 100 + (($aX1p - $aX1c) / 2))."px; TOP: ".($aY1c - $aB1c * 3 - 9)."px'></div>";

      }
      else
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3 + 2)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px; TOP: ".($aY1c + 90 + $aB1c * 3 + 2)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1p - $aX1c + 2)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3 + 2)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sl."' style='POSITION: absolute; LEFT: ".($aX1c + 100 + (($aX1p - $aX1c) / 2))."px; TOP: ".($aY1c + 90 + $aB1c * 3 - 9)."px'></div>";

      }

  }
  else
  {

      if ($aY1p > $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1p - $aY1c + $aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px; TOP: ".($aY1p + 90 + $aB1c * 3 + 3)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1c - $aX1p)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sr."' style='POSITION: absolute; LEFT: ".($aX1p + 100 + (($aX1c - $aX1p) / 2))."px; TOP: ".($aY1p + 90 + $aB1c * 3 - 9)."px'></div>";

      }
      else if ($aY1p < $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c - $aB1c * 3)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3 + 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px; TOP: ".($aY1c - $aB1c * 3)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1c - $aX1p)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p - $aB1c * 3 - 90)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sr."' style='POSITION: absolute; LEFT: ".($aX1p + 100 + (($aX1c - $aX1p) / 2))."px; TOP: ".($aY1c - $aB1c * 3 - 9)."px'></div>";

      }
      else
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p + $aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px; TOP: ".($aY1p + 90 + $aB1c * 3)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1c - $aX1p)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p + $aB1c * 3)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sr."' style='POSITION: absolute; LEFT: ".($aX1p + 100 + (($aX1c - $aX1p) / 2))."px; TOP: ".($aY1c + 90 + $aB1c * 3 - 9)."px'></div>";

      }

  }

  $l = $aBougth.[$iParent] + 1;
  $aBougth[$iParent] = $l;

  $l = $aBougth.[$iChild] + 1;
  $aBougth[$iChild] = $l;

  return $htm;
}


//связываю родителя с ребенком
function Linkas1($iParent, $iChild, $fm)
{
  global $aBougth;
  global $aX1;
  global $aY1;

  if ($aX1[$iParent] == 0) return;
  if ($aX1[$iChild] == 0) return;

  $slf = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAoUlEQVQ4y6VUwQ2DMAw8Iz/5dwAWYAM2YARm6EodoRswCAPw58njeGAklBJqB0uWzrHOiXx2hCQiJoACWIEdeEm1weU4UwfpZXBOc3pDagxO2cokfxxke5lIXJPbOoOjpw9qpN7ib6j1IAfPE69cEBX6ZBUeWAXgXUoWkhBgsPgTJp+kinU9MyRdqQLuKZM7pf7Nt3hkts2ai8i5fZYnP8kGli/Uxlzf6aUAAAAASUVORK5CYII=";
  $srf = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAkklEQVQ4y2Nk+P//PwMEsP5nYPjDQAJgRNLMwMDAwMvAwMDwn4HhCzmaYUACashLcjTDgArUkLvYpf///08ENsAmTMhmZOAAdcVBYp2NDfhDDdlEjmYYiKdEMwMTAwWAEs0FLOT4FRpgi1jICWVSE4k9NmEGclPX////GVjIT9cMODVLEMpR2DSTlJ+RNZNckgAAQiW090LLfVwAAAAASUVORK5CYII=";
  $slm = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAy0lEQVQ4y51UywrCQAycaasgeBA89Buk3UNBEIr0/z/BHxGEbRsPWaWrW9sYWJJ9zAaSmVBEYDKSgOsAoDCAcg2qDsAIAFzMzGoboqu6fHhdzWdmuwtPWvXSfz5Jg1nvAbmETP3c/zGYzUGD7AzAL5VBwTwddbtpwrlfVUNBXQJ0FtAk81gDuccflllanQA/bsBQ6DKSTUQAujJsna1gU4bFVfc2cNTvYbHX89xewbLfwnjz+96muM1VelZlfamKq4dBpOdstIETk+QJPc4/99t6KdIAAAAASUVORK5CYII=";
  $srm = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAATCAYAAABPwleqAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAA60lEQVQ4y52UwWrCQBCGv0k2pwr1NYp6CPQgXtpHr7YED4WCwaqP4EFQKBRM4vQwuoqGJusPy4Ys38zO/LsryuAFAPIJqkqAovNn7xWRGJG4LSznzADVCfwAQOf7ANj/djY/ZBYk+23Y9qW0tLEbwW6E9DsB8ElxaSMaImkXSbuXq65lbwqonq2ipy/b3GLjApwpbEpSCzLIQ+CrIId+xN1y3JG5OjLlMgROjgbl1rDV2rUHC9/lEKsSiD/R2fa26sbaZIrOfupbVn/kHTz+e65rYH+r3tFs32yW1yGC77Fl06qd017zt9CX5A9yv0qOfEX5MgAAAABJRU5ErkJggg==";
  $sl = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAUCAYAAABSx2cSAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAHWlUWHRDb21tZW50AAAAAABDcmVhdGVkIHdpdGggR0lNUGQuZQcAAABUSURBVDjLvdQ7DgAgCANQ6v3vjINhgUj4aSeX10RFQdkwsSxRhXGsUBxfoI8d5OMAtDiILE7CgwtIsqiRFkZ1vwMHVrzj4SFJljx+VU4B/v0kqmAD2Nwj83govDEAAAAASUVORK5CYII=";
  $sr = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA8AAAAUCAYAAABSx2cSAAAABmJLR0QA/wD/AP+gvaeTAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAZ0lEQVQ4y82UwQ7AIAhDXwn//8vutMRlY6Gc7M2YZwuiYrG4JYSheKz2gxpSCTRSRLnTSKFW1CJFtIorDOQ2aU8RuNrMfGe75rNgoZiCADm9Ji/2x5TldDT/4fGran4KOYHeziYIcAHLKxI05jBcLAAAAABJRU5ErkJggg==";

  if ($fm)
  {
      $sl = $slf;
      $sr = $srf;
  }
  else
  {
      $sl = $slm;
      $sr = $srm;
  }

  $aX1c = $aX1[$iChild];
  $aY1c = $aY1[$iChild];
  $aX1p = $aX1[$iParent];
  $aY1p = $aY1[$iParent];
  $aB1c = $aBougth[$iChild];
  $aB1b = $aBougth[$iParent];

  $htm = "";
  //$htm .= "=== $iParent =12= $aBougth[$iParent]:$aX1[$iParent]:$aY1[$iParent]<br>";
  //$htm .= "=== $iChild =22= $aBougth[$iChild]:$aX1[$iChild]:$aY1[$iChild]<br>";
  //return $htm;

  // если
  if ($aX1p > $aX1c)
  {

      if ($aY1p > $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 90 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px; TOP: ".($aY1c + 90 + $aB1c * 3 + 1)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1p - $aX1c)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1c + 90 + $aB1c * 3 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1p - $aY1c - 90 - $aB1c * 3)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sl."' style='POSITION: absolute; LEFT: ".($aX1c + 100 + (($aX1p - $aX1c) / 2))."px; TOP: ".($aY1c + 90 + $aB1c * 3 - 8)."px'></div>";

      }
      else if ($aY1p < $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c - $aB1c * 3 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px; TOP: ".($aY1c - $aB1c * 3 + 1)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1p - $aX1c)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p - 90 - $aB1c * 3)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sl."' style='POSITION: absolute; LEFT: ".($aX1c + 100 + (($aX1p - $aX1c) / 2))."px; TOP: ".($aY1c - $aB1c * 3 - 8)."px'></div>";

      }
      else
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3 + 2)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px; TOP: ".($aY1c - $aB1c * 3 + 1)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1p - $aX1c)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p - $aB1c * 3 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3 + 2)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sl."' style='POSITION: absolute; LEFT: ".($aX1c + 100 + (($aX1p - $aX1c) / 2))."px; TOP: ".($aY1c - $aB1c * 3 - 8)."px'></div>";

      }

  }
  else
  {

      if ($aY1p > $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 90 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px; TOP: ".($aY1c + 90 + $aB1c * 3 + 1)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1c - $aX1p)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1c + 90 + $aB1c * 3 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1p - $aY1c - $aB1c * 3 - 90)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sr."' style='POSITION: absolute; LEFT: ".($aX1p + 100 + (($aX1c - $aX1p) / 2))."px; TOP: ".($aY1c + 90 + $aB1c * 3 - 8)."px'></div>";

      }
      else if ($aY1p < $aY1c)
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c - $aB1c * 3 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aB1c * 3)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px; TOP: ".($aY1c - $aB1c * 3 + 1)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1c - $aX1p)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p - $aB1c * 3 - 90)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sr."' style='POSITION: absolute; LEFT: ".($aX1p + 100 + (($aX1c - $aX1p) / 2))."px; TOP: ".($aY1c - $aB1c * 3 - 8)."px'></div>";

      }
      else
      {

          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1c + 100)."px;TOP:".($aY1c + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p + $aB1c * 3 + 1)."px'><tr><td></td></tr></table>";
          //горизонтально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px; TOP: ".($aY1p + 90 + $aB1c * 3 + 1)."px; BORDER-TOP:1pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
          $htm .= ($aX1c - $aX1p)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
          //вертикально
          $htm .= "<table bordercolor=#00FF00 style='POSITION: absolute; LEFT: ";
          $htm .= ($aX1p + 100)."px;TOP:".($aY1p + 90 + 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:1pt solid;WIDTH:0px;HEIGHT:";
          $htm .= ($aY1c - $aY1p + $aB1c * 3)."px'><tr><td></td></tr></table>";

          $htm .= "<img src='".$sr."' style='POSITION: absolute; LEFT: ".($aX1p + 100 + (($aX1c - $aX1p) / 2))."px; TOP: ".($aY1c + 90 + $aB1c * 3 - 8)."px'></div>";

      }

  }

  $l = $aBougth.[$iParent] + 1;
  $aBougth[$iParent] = $l;

  $l = $aBougth.[$iChild] + 1;
  $aBougth[$iChild] = $l;

  return $htm;
}



?>