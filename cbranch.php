<?php

Branch();

//рисую все генеалогические ветви и фамилии
function Branch()
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
  global $aX1;
  global $aY1;
  global $aX2;
  global $aY2;

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $level;
  global $iX2;
  global $iY2;
  global $maxX;
  global $maxY;

echo "<br><br><br><br><br><br>";

  $maxX = -240;

  $progenitors = array();
  for ($i = 0; $i < count($persons); $i++) {
      if (empty($persons[$i][$fldFAT]) && empty($persons[$i][$fldMOT])) {
         $progenitors[] = $i;
      }
  }

  for ($i = 0; $i < count($progenitors); $i++)
  {
      $iX2 = $maxX + 242;
      $iY2 = 50;

      ParentsChilds($progenitors[$i], $maxX + 251, $iY2, $maxX + 261, -45);
  }

  // выращивание
  $maxY = $maxY + 10;
  for ($i = 0; $i < count($aPerson); $i++)
  {
      $html = DrawMenHTML($i);
      echo $html;
  }

  return "";
}


function ParentsChilds($person, $X1, $Y1, $X2, $Y2)
{
//echo "=== ParentsChilds =".$X1.":".$Y1." ; ".$person."<br>";
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

  $level++;

  $gender = $persons[$person][$fldSEX];

  $dX = $X2;
  $dY = $Y1;
  $sNam = "";// контрольная сумма
  $sPar = "";// контрольная сумма
  $one = false;

  $iCol = 0;
  $Col = iY2;

  if ($maxX < $X1) $maxX = $X1;
  if ($maxY < $Y1) $maxY = $Y1;

  AddInfoBranch($person, -1, -1, -1, $X1, $Y1, $X2, $Y2);

  if ($gender == '1')//отец
  {
      //список детей
      $childrens = array();
      for ($i = 0; $i < count($fathers); $i++) {
        if (strcmp($fathers[$i][1], $person) == 0) {
           $childrens[$i][$fldCHILD] = $fathers[$i][0];
           $childrens[$i][$fldMOTHE] = $persons[$fathers[$i][0]][$fldMOT];//ok." ; ".$persons[$persons[$fathers[$i][0]][$fldMOT]][$fldPER];
        }
      }
      array_sort_by_column($childrens, 1);

      //список супругов
      $marrieds = array();
      for ($i = 0; $i < count($spouses); $i++) {
        if ($spouses[$i][$fldSPOUS1] == $person){
          $b = true;
          for ($n = 0; $n < count($marrieds); $n++) {
             if($marrieds[$n] == $spouses[$i][$fldSPOUS2]) {
               $b = false;
               break;
             }
          }

          if($b) $marrieds[] = $spouses[$i][$fldSPOUS2];
        }else
        if ($spouses[$i][$fldSPOUS2] == $person) {
          $b = true;
          for ($n = 0; $n < count($marrieds); $n++) {
             if($marrieds[$n] == $spouses[$i][$fldSPOUS1]) {
               $b = false;
               break;
             }
          }

          if($b) $marrieds[] = $spouses[$i][$fldSPOUS1];
        }
      }

      // ищу всех детей мужской линии
      $iCol = $iY2 + 85;
      for ($i = 0; $i < count($childrens); $i++)
      {
          $femess = array();
          $nf = 0;
          for ($ii = 0; $ii < count($mothers); $ii++) {
              if (strcmp($mothers[$ii][0], $childrens[$i][$fldCHILD]) == 0) {
                 $femes[$nf] = $mothers[$ii][1];
                 $nf++;
              }
          }

          $sNam = "";
          for ($n = 0; $n < count($femes); $n++) $sNam .= $femes[$n];

          if (strcmp($sNam, $sPar) <> 0)
          {
              $iX2 = $dX + 232;
              for ($j = 0; $j < count($femes); $j++)// мать
              {
                  for ($n = count($marrieds); $n >= 0; $n--)
                  {
                      // есть ли такая жена в списке
                      if ($marrieds[$n] == $femes[$j])
                      {
                          unset($marrieds[$n]);// если есть, удаляю его из списка
                          //break;
                      }
                  }

                  if ($one)
                  {
                      $iY2 = $dY;
                      $iCol = $iY2 + 85;
                      $dX = $maxX;
                  }
                  else
                  {
                      $dY = $iY2;
                  }

                  $dX = $dX + 242;
                  AddInfoBranch($femes[$j], -1, 0, -1, $iX2, $iY2, $dX, $iY2);
                  $iX2 = $dX + 242;
              }

              $sPar = $sNam;
          }

          $one = true;
          $iY2 = $iY2 + 95;
          if ($Col > $iY2) $iY2 = $Col;
          ParentsChilds($childrens[$i][$fldCHILD], $dX + 15, $iY2, $dX + 25, $dY);
          if ($Col < $iY2) $Col = $iY2;
      }
      if ($maxX < $dX) $maxX = $dX;

      // рисую жен и мужей без детей
      if (count($marrieds) > 0)
      {
          if (!$one)
          {
             $X1 = $X1 + 242;
          }

          for ($n = 0; $n < count($marrieds); $n++)
          {
             if(strlen($marrieds[$n]) > 0){
              $dX = $dX + 242;
              AddInfoBranch($marrieds[$n], -1, -1, 0, $dX - 10, $dY, $dX, $Y1);
              if ($maxX < $dX) $maxX = $dX;
              $iX2 = $dX + 218;
             }
          }
      }

  }
  else// ищу всех детей женской линии
  if ($gender == '2')//мать
  {
      //список детей
      $childrens = array();
      for ($i = 0; $i < count($mothers); $i++) {
        if (strcmp($mothers[$i][1], $person) == 0) {
           //$childrens[] = $mothers[$i][0];
           $childrens[$i][$fldCHILD] = $mothers[$i][0];
           $childrens[$i][$fldFATHE] = $persons[$mothers[$i][0]][$fldFAT];//ok." ; ".$persons[$persons[$fathers[$i][0]][$fldMOT]][$fldPER];
        }
      }
      array_sort_by_column($childrens, 1);

      //список супругов
      $marrieds = array();
      for ($i = 0; $i < count($spouses); $i++) {
        if ($spouses[$i][$fldSPOUS1] == $person){
          $b = true;
          for ($n = 0; $n < count($marrieds); $n++) {
             if($marrieds[$n] == $spouses[$i][$fldSPOUS2]) {
               $b = false;
               break;
             }
          }

          if($b) $marrieds[] = $spouses[$i][$fldSPOUS2];
        }else
        if ($spouses[$i][$fldSPOUS2] == $person) {
          $b = true;
          for ($n = 0; $n < count($marrieds); $n++) {
             if($marrieds[$n] == $spouses[$i][$fldSPOUS1]) {
               $b = false;
               break;
             }
          }

          if($b) $marrieds[] = $spouses[$i][$fldSPOUS1];
        }
      }

      // ищу всех детей женской линии
      for ($i = 0; $i < count($childrens); $i++)
      {
          $mans = array();
          for ($ii = 0; $ii < count($fathers); $ii++) {
              if (strcmp($fathers[$ii][0], $childrens[$i][$fldCHILD]) == 0) {
                 $mans[] = $fathers[$ii][1];
              }
          }

          $sNam = "";
          for ($n = 0; $n < count($mans); $n++) $sNam .= $mans[$n];

          if (strcmp($sNam, $sPar) <> 0)
          {
              $iX2 = $dX + 232;
              for ($j = 0; $j < count($mans); $j++)// отец
              {
                  for ($n = count($marrieds); $n >= 0; $n--)
                  {
                      // есть ли такой муж в списке
                      if ($marrieds[$n] == $mans[$j])
                      {
                          unset($marrieds[$n]);// если есть, удаляю его из списка
                          //break;
                      }
                  }

                  if ($one)
                  {
                      $iY2 = $dY;
                      $iCol = $iY2 + 85;
                      $dX = $maxX;
                  }
                  else
                  {
                      $dY = $iY2;
                  }

                  $dX = $dX + 242;
                  AddInfoBranch($mans[$j], -1, 0, -1, $iX2, $iY2, $dX, $Y1);
                  $iX2 = $dX + 242;
              }

              $sPar = $sNam;
          }

          $one = true;
          $iY2 = $iY2 + 95;
          if ($Col > $iY2) $iY2 = $Col;
          ParentsChilds($childrens[$i][$fldCHILD], $dX + 15, $iY2, $dX + 25, $dY);
          if ($Col < $iY2) $Col = $iY2;
      }
      if ($maxX < $dX) $maxX = $dX;

      // рисую жен и мужей без детей
      if (count($marrieds) > 0)
      {
          if (!$one)
          {
             $X1 = $X1 + 242;
          }

          for ($n = 0; $n < count($marrieds); $n++)
          {
             if(strlen($marrieds[$n]) > 0){
              $dX = $dX + 242;
              AddInfoBranch($marrieds[$n], -1, -1, 0, $dX - 10, $dY, $dX, $Y1);
              if ($maxX < $dX) $maxX = $dX;
              $iX2 = $dX + 218;
             }
          }
      }

  }

  $level--;

  return "";
}

function AddInfoBranch($PersonId, $FatherId, $MotherId, $SpouseId, $X1, $Y1, $X2, $Y2)
{
  global $aPerson;
  global $aFather;
  global $aMother;
  global $aSpouse;
  global $aX1;
  global $aY1;
  global $aX2;
  global $aY2;

//global $persons;
//global $fldPER;
//$person = $persons[$PersonId];
//echo "=== AddInfoBranch = $PersonId, $FatherId, $MotherId, $SpouseId, $X1, $Y1, $X2, $Y2 $person[$fldPER]<br>";

  $aPerson[] = $PersonId;
  $aFather[] = $FatherId;
  $aMother[] = $MotherId;
  $aSpouse[] = $SpouseId;
  $aX1[] = $X1;
  $aY1[] = $Y1;
  $aX2[] = $X2;
  $aY2[] = $Y2;

  return "";
}

//рисует иконку, рамку, имя и дату
function DrawMenHTML($Index)
{

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $persons;

  global $aPerson;
  global $aFather;
  global $aMother;
  global $aSpouse;
  global $aX1;
  global $aY1;
  global $aX2;
  global $aY2;

  global $getdir;

  $I = $aPerson[$Index];
  $F = $aFather[$Index];
  $M = $aMother[$Index];
  $S = $aSpouse[$Index];
  $X1 = $aX1[$Index];
  $X2 = $aX2[$Index];
  $Y1 = $aY1[$Index];
  $Y2 = $aY2[$Index];

  $person = $persons[$I];

  $htm = "";

  if ($F == -1 && $M == -1 && $S == -1)
  {
      if ($Y2 > 0)
      {
          $htm .= "<table style='POSITION:absolute;LEFT:".($X2 - 10)."px;TOP:".($Y2 + 80)."px;BORDER-LEFT:2pt solid;HEIGHT:".($Y1 - $Y2 - 35)."px; border-color: green;'><tr><td></td></tr></table>";
      }
  }

  $htm .= "<table style='POSITION:absolute;LEFT:".($X1)."px;TOP:".($Y1 + 45)."px;BORDER-TOP:2pt solid;WIDTH:".($X2 - $X1)."px; border-color: green;'><tr><td></td></tr></table>";

  $htm .= "<div class='shadow' style='POSITION: absolute; LEFT: ".$X2."px; TOP: ".$Y1."px; WIDTH: 235px; HEIGHT: 80px'>";
  if ($person[$fldSEX] == "1")
  {
      $htm .= "<div class='blockm' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 220px; HEIGHT: 65px'>";
  }
  else if ($person[$fldSEX] == "2")
  {
      $htm .= "<div class='blockw' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 220px; HEIGHT: 65px'>";
  }
  else
  {
      $htm .= "<div class='blockn' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 220px; HEIGHT: 65px'>";
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
//  $htm .= "<br>==$I==$F==$M==$S==$X1=$Y1==$X2=$Y2==";
  $htm .= "</div></div>";

  return $htm;
}

?>