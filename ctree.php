<?php

Tree();

//рисую генеалогическое древо
function Tree()
{
  global $cnt_persons;

  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $aBougth;
  global $aX1;
  global $aY1;

  global $Bougth;
  global $maxX;
  global $maxY;
  global $XmaxL;
  global $YmaxL;
  global $XmaxR;
  global $YmaxR;

  global $iX2;
  global $iY2;
  global $cntL;
  global $cntR;
  global $curL;
  global $curR;
  global $LeftRight;
  global $level;
  global $shadow;
  global $bH;
  global $bW;
  global $tH;
  global $tW;
  global $cH;
  global $cW;

  //заполняю элементы списка
  $cnt_person = count($persons);

  for ($i = 0; $i < count($persons); $i++) {
      $aBougth[] = 0;
      $aX1[] = -1;
      $aY1[] = -1;
  }

  //progenitors
  $progenitors = array();
  for ($i = 0; $i < count($persons); $i++) {
  //echo "progenitor=".$persons[$i][$fldPER].":".$persons[$i][$fldFAT].":".$persons[$i][$fldMOT]."<br>";
      if (empty($persons[$i][$fldFAT]) && empty($persons[$i][$fldMOT])) {
         $progenitors[] = $i;
      }
  }
  //echo "progenitors=".count($progenitors)."<br>";

  $Bougth = 0;
  $LeftRight = true;//начинаю с правой ветви
  for ($i = 0; $i < count($progenitors); $i++)
  {
      // сканирую
      $Bougth++;

      if ($LeftRight)
      {
          ParentsAlls(220, 10 + 210 * $cntR, $progenitors[$i], $LeftRight);
          $cntR++;
          $LeftRight = false;
      }
      else
      {
          ParentsAlls(-55, 10 + 210 * $cntL, $progenitors[$i], $LeftRight);
          $cntL++;
          $LeftRight = true;
      }
  }

//echo $Bougth."|".$cntL."|".$cntR;

  // добавить
  $maxX = -($XmaxL) + 85 + $cntL * 5;
  $x1 = 0;
  for ($i = 0; $i < count($persons); $i++)
  {
      $delta = ($cntL + $cntR - $aBougth[$i]) * 5;
      if ($aX1[$i] > 0)
      {
          $x1 = $aX1[$i] + $maxX + $delta;
      }
      else
      {
          $x1 = $aX1[$i] + $maxX - $delta;
      }
      $aX1[$i] = $x1;
//echo "=aX1=".$aX1[$i]."=delta=".$delta."=cntL=".$cntL."=cntR=".$cntR."=aBougth=".$aBougth[$i]."<br>";
  }
  //$maxX = $maxX + 200;


  // инверсия
  if ($YmaxL > $YmaxR) $maxY = $YmaxL + 60; else $maxY = $YmaxR + 60;
  $y1 = 0;
  $y2 = 0;
  for ($i = 0; $i < count($persons); $i++)
  {
      if ($aY1[$i] != -1)
      {
          $y1 = $maxY - $aY1[$i];
          $aY1[$i] = $y1;
      }
      if ($aY2[i] != -1)
      {
          $y2 = $maxY - $aY2[$i];
          $aY2[i] = $y2;
      }
  }


  //рисую ствол и ветки
  $curL = $cntL;
  $curR = $cntR;

  if ($Bougth > 1) echo DrawTree();

  for ($i = 0; $i < count($persons); $i++)
  {
      if ($aBougth[$i] != 0)
      {
          // связываю родоначальников с древом
          if (empty($persons[$i][$fldFAT]) && empty($persons[$i][$fldMOT])) {
             echo LinkTree($i);
          }
      }

      // список детей
      $childers = array();
      for ($ii = 0; $ii < count($fathers); $ii++) {
          if (strcmp($fathers[$ii][0], $i) == 0) {
             $childers[] = $fathers[$ii][1];
          }
      }
      for ($ii = 0; $ii < count($mothers); $ii++) {
          if (strcmp($mothers[$ii][0], $i) == 0) {
             $childers[] = $mothers[$ii][1];
          }
      }

      // связываю родителя с ребенком
      for ($f = 0; $f < count($childers); $f++)
      {
          if ($aBougth[$childers[$f]] == $aBougth[$i])
          {
             echo LinkFather($childers[$f], $i);
          }
          else
          {
             echo LinkMother($childers[$f], $i);
          }
      }

  }

  // Рисую ФИО
  for ($i = 0; $i < count($persons); $i++)
  {
      if ($aBougth[$i] != 0)
      {
         echo DrawTreeHTML($i);
      }
  }

  return "";
}

//заполняю координаты
function ParentsAlls($X, $Y, $index, $LR)
{
  global $cnt_persons;
  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;

  global $aBougth;
  global $aX1;
  global $aY1;

  global $Bougth;
  global $maxX;
  global $maxY;
  global $XmaxL;
  global $YmaxL;
  global $XmaxR;
  global $YmaxR;

  global $iX2;
  global $iY2;
  global $cntL;
  global $cntR;
  global $curL;
  global $curR;
  global $bH;
  global $bW;
  global $tH;
  global $tW;
  global $cH;
  global $cW;

  if ($aBougth[$index] > 0) return 0;

  if ($LR)
  {
     if ($X > $XmaxR) $XmaxR = $X;
     if ($Y > $YmaxR) $YmaxR = $Y;
  }
  else
  {
     if ($X < $XmaxL) $XmaxL = $X;
     if ($Y > $YmaxL) $YmaxL = $Y;
  }

//echo count($aBougth)."++".$aBougth[$index]."++".$persons[$index][$fldPER]."==XL==".$XmaxL."=XR==".$XmaxR."<br>";
//echo "progenitor=".$persons[$index][$fldPER]."<br>";

  AddInfoTree($index, $X, $Y);
  $dX = $X;
  $dY = $Y;
  $dlt = 0;

  //список детей
  $childrens = array();
  for ($i = 0; $i < count($fathers); $i++) {
    if (strcmp($fathers[$i][1], $index) == 0) {
       $childrens[] = $fathers[$i][0];
    }
  }
  for ($i = 0; $i < count($mothers); $i++) {
    if (strcmp($mothers[$i][1], $index) == 0) {
       $childrens[] = $mothers[$i][0];
    }
  }

  for ($i = 0; $i < count($childrens); $i++)
  {
      if ($LR)
      {
          $dX = $dX + 265;
          $dlt = ParentsAlls($dX, $dY + 105, $childrens[$i], $LR);
          if ($dlt == 0)
          {
              $dX = $X;
          }
          else
          {
              $dX = $dlt;
          }
      }
      else
      {
          $dX = $dX - 265;
          $dlt = ParentsAlls($dX, $dY + 105, $childrens[$i], $LR);
          if ($dlt == 0)
          {
              $dX = $X;
          }
          else
          {
              $dX = $dlt;
          }
      }
  }

  return $dX;
}

function AddInfoTree($index, $X1, $Y1)
{
  global $aBougth;
  global $aX1;
  global $aY1;
  global $Bougth;

  $X1 = CheckedX($X1, $Y1);

  $aX1[$index] = $X1;
  $aY1[$index] = $Y1;

  $aBougth[$index] = $Bougth;

//echo count($aBougth)."++".$aBougth[$index]."++".$Bougth."++".$persons[$index][$fldPER]."==X1==".$X1."=Y1==".$Y1."<br>";
}

//заполняю координаты
function CheckedX($X1, $Y1)
{
  global $cnt_persons;
  global $aX1;
  global $aY1;

  $done = true;
  while ($done)
  {
      $done = false;

      // проверка на незанятость координаты
      for ($i = 0; $i < count($persons); $i++)
      {
          if ($aY1[$i] == $Y1)
          {
              if (($X1 >= $aX1[$i]) && ($X1 < ($aX1[$i] + 220)))
              {
                  if ($X1 > 0)
                  {
                      $X1 = $X1 + 225;
                      if ($X1 > $XmaxR) $XmaxR = $X1;
                  }
                  else
                  {
                      $X1 = $X1 - 225;
                      if ($X1 < $XmaxL) $XmaxL = $X1;
                  }

                  $done = true;
                  break;
              }
          }
      }
  }

  return $X1;
}

//рисует иконку, рамку, имя и дату
function DrawTreeHTML($Index)
{
  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldICON;

  global $persons;
  global $aX1;
  global $aY1;
  global $getdir;
  global $maxX;

  $person = $persons[$Index];
  $X1 = $aX1[$Index];
  $Y1 = $aY1[$Index];

//echo $person[$fldPER]."=X1==".$X1."=Y1==".$Y1."<br>";

  $htm = "";

  $htm .= "<div class='shadow' style='POSITION: absolute; LEFT: ".$X1."px; TOP: ".$Y1."px; WIDTH: 235px; HEIGHT: 80px'>";
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
  $htm .= "</div></div>";

  return $htm;
}

function DrawTree()
{
  global $maxX;
  global $maxY;

//echo "LinkTree==X1==".$maxX."=Y1==".$maxY."<br>";

  $htm = "";
  $htm .= "<table style='POSITION: absolute; LEFT: ";//вертикально
  $htm .= ($maxX + 200)."px; TOP: 0px; BORDER-TOP: 0pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 2pt solid; WIDTH: 0px; HEIGHT: ";
  $htm .= ($maxY + 70)."px; border-color: Brown;'><tr><td></td></tr></table>";
  return $htm;
}

function LinkTree($index)
{
  global $maxX;
  global $maxY;
  global $aX1;
  global $aY1;
  global $curR;
  global $curL;
  global $cH;
  global $bW;

//echo "LinkTree==X1==".$aX1[$index]."=Y1==".$aY1[$index]."<br>";

  $htm = "";
  if ($aX1[$index] > $maxX)
  {
      $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//вертикально
      $htm .= ($maxX + 200 + $curR * 5)."px; TOP: ".($aY1[$index] + $cH)."px; BORDER-TOP: 0pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 2pt solid; WIDTH: 0px; HEIGHT: ";
      $htm .= ($maxY - $aY1[$index] + $cH)."px; border-color: SandyBrown;'><tr><td></td></tr></table>";

      $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//горизонтально
      $htm .= ($maxX + 200 + $curR * 5)."px; TOP: ".($aY1[$index] + $cH)."px; BORDER-TOP: 2pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
      $htm .= ($curR * 5 + 20)."px; HEIGHT: 0px; border-color: green;'><tr><td></td></tr></table>";

      $curR--;
  }
  else
  {
      $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//вертикально
      $htm .= ($maxX + 200 - $curL * 5)."px; TOP: ".($aY1[$index] + $cH)."px; BORDER-TOP: 0pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 2pt solid; WIDTH: 0px; HEIGHT: ";
      $htm .= ($maxY - $aY1[$index] + $cH)."px; border-color: SandyBrown;'><tr><td></td></tr></table>";

      $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//горизонтально
      $htm .= ($aX1[$index] + $bW)."px; TOP: ".($aY1[$index] + $cH)."px; BORDER-TOP: 2pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
      $htm .= ($curL * 5 + 20)."px; HEIGHT: 0px; border-color: green;'><tr><td></td></tr></table>";

      $curL--;
  }
  return $htm;
}


function LinkFather($father, $childr)
{
    global $maxX;
    global $maxY;
    global $aX1;
    global $aY1;
    global $curR;
    global $curL;
    global $cH;
    global $bH;
    global $cW;
    global $bW;
    global $tH;

    $htm = "";

    if ($aX1[$father] > $maxX)
    {
        $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//вертикально
        $htm .= ($aX1[$childr] + $cW)."px; TOP: ".($aY1[$childr] + $bH)."px; BORDER-TOP: 0pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 2pt solid; WIDTH: 0px; HEIGHT: ";
        $htm .= ($tH - $shadow - 3)."px'><tr><td></td></tr></table>";

        $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//горизонтально
        $htm .= ($aX1[$father] + $bW)."px; TOP: ".($aY1[$father] + $cH)."px; BORDER-TOP: 2pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
        $htm .= ($aX1[$childr] - $aX1[$father] - $cW + 2)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
    }
    else
    {
        $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//вертикально
        $htm .= ($aX1[$childr] + $cW)."px; TOP: ".($aY1[$childr] + $bH - 3)."px; BORDER-TOP: 0pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 2pt solid; WIDTH: 0px; HEIGHT: ";
        $htm .= ($tH - $shadow)."px'><tr><td></td></tr></table>";

        $htm .= "<table bordercolor=#008000 style='POSITION: absolute; LEFT: ";//горизонтально
        $htm .= ($aX1[$childr] + $cW)."px; TOP: ".($aY1[$father] + $cH)."px; BORDER-TOP: 2pt solid; BORDER-BOTTOM: 0pt solid; BORDER-RIGHT: 0pt solid; BORDER-LEFT: 0pt solid; WIDTH: ";
        $htm .= ($aX1[$father] - $aX1[$childr] - $cW)."px; HEIGHT: 0px'><tr><td></td></tr></table>";
    }

    return $htm;
}

function LinkMother($mother, $childr)
{
    global $maxX;
    global $maxY;
    global $aX1;
    global $aY1;
    global $curR;
    global $curL;
    global $cH;
    global $bH;
    global $cW;
    global $bW;
    global $tH;

    $htm = "";

    if ($aX1[$mother] > $maxX)
    {
        $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально parent
        $htm .= ($aX1[$mother] + $bW + 2)."px;TOP:".($aY1[$mother] + $cH - 2)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
        $htm .= "15px;HEIGHT:0px'><tr><td></td></tr></table>";
    }
    else
    {
        $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально parent
        $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$mother] + $cH - 2)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
        $htm .= "15px;HEIGHT:0px'><tr><td></td></tr></table>";
    }

    if ($aX1[$childr] > maxX)
    {
        $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
        $htm .= ($aX1[$childr] + $cW + 2)."px;TOP:".($aY1[$childr] + $bH)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
        $htm .= (10)."px'><tr><td></td></tr></table>";
    }
    else
    {
        $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
        $htm .= ($aX1[$childr] + $cW - 2)."px;TOP:".($aY1[$childr] + $bH)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
        $htm .= (10)."px'><tr><td></td></tr></table>";
    }

    if ($aX1[$mother] >= $maxX && $aX1[$childr] < $maxX)
    {

        if ($aY1[$mother] >= $aY1[$childr])
        {//родитель выше или равен ребенку
            $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
            $htm .= ($aX1[$mother] + 245 + 1)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
            $htm .= ($aY1[$mother] - $aY1[$childr] - 59 + $shadow)."px'><tr><td></td></tr></table>";
            $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
            $htm .= ($aX1[$childr] + 115 - 2)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
            $htm .= ($aX1[$mother] + 135 - $aX1[$childr])."px;HEIGHT:0px'><tr><td></td></tr></table>";
        }
        else
        {
            $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
            $htm .= ($aX1[$mother] + 245)."px;TOP:".($aY1[$mother] + 33)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
            $htm .= ($aY1[$childr] - $aY1[$mother] + 59)."px'><tr><td></td></tr></table>";
            $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
            $htm .= ($aX1[$childr] + 115)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
            $htm .= ($aX1[$mother] + 130 - $aX1[$childr])."px;HEIGHT:0px'><tr><td></td></tr></table>";
        }

    }
    else if ($aX1[$mother] < $maxX && $aX1[$childr] > $maxX)
    {

        if ($aY1[$mother] > $aY1[$childr])
        {//родитель выше или равен ребенку
            $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
            $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
            $htm .= ($aY1[$mother] - $aY1[$childr] - 60 + $shadow)."px'><tr><td></td></tr></table>";
            $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
            $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
            $htm .= ($aX1[$childr] - $aX1[$mother] + 135)."px;HEIGHT:0px'><tr><td></td></tr></table>";
        }
        else
        {
            $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
            $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$mother] + 35)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
            $htm .= ($aY1[$childr] - $aY1[$mother] + 55 + 1)."px'><tr><td></td></tr></table>";
            $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
            $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
            $htm .= ($aX1[$childr] - $aX1[$mother] + 135 - 1)."px;HEIGHT:0px'><tr><td></td></tr></table>";
        }

    }
    else if ($aX1[$mother] > $maxX && $aX1[$childr] > $maxX)
    {

        if ($aX1[$mother] + 115 >= $aX1[$childr] - 15)
        {//родитель дальше или равен ребенку

            if ($aY1[$mother] >= $aY1[$childr])
            {//родитель выше или равен ребенку
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$mother] + 245)."px;TOP:".($aY1[$childr] + 90 - 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$mother] - $aY1[$childr] - 60 - $shadow)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$childr] + $cW)."px;TOP:".($aY1[$childr] + 90 - 1)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$mother] + 135 - $aX1[$childr] - 3)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }
            else
            {
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$mother] + 245)."px;TOP:".($aY1[$mother] + 35 - 1)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$childr] - $aY1[$mother] + 60 - $shadow)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$childr] + $cW)."px;TOP:".($aY1[$childr] + 90 - 1)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$mother] + 135 - $aX1[$childr] - 3)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }

        }
        else
        {

            if ($aY1[$mother] >= $aY1[$childr])
            {
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$mother] + 245)."px;TOP:".($aY1[$mother] + 34)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$mother] - $aY1[$childr] + 57 - $shadow)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$mother] + 245)."px;TOP:".($aY1[$childr] + 89)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$childr] - 130 - $aX1[$mother] + $shadow + 4)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }
            else
            {
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$mother] + 245)."px;TOP:".($aY1[$mother] + 33)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$childr] - $aY1[$mother] + 57 - $shadow)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$mother] + 245)."px;TOP:".($aY1[$childr] + 89)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$childr] - 130 - $aX1[$mother] + $shadow + 4)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }

        }

    }
    else if ($aX1[$mother] < $maxX && $aX1[$childr] < $maxX)
    {

        if ($aX1[$mother] - 15 >= $aX1[$childr] + $cW)
        {//родитель дальше или равен ребенку

            if ($aY1[$mother] >= $aY1[$childr])
            {//родитель выше или равен ребенку
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$mother] - $aY1[$childr] - 60 + $shadow)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$childr] + 115 - 2)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$mother] - $aX1[$childr] - 135 + $shadow + 2)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }
            else
            {
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$mother] + 35)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$childr] - $aY1[$mother] + 60 - 3)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$childr] + 115 - 2)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$mother] - $aX1[$childr] - 135 + $shadow + 2)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }

        }
        else
        {

            if ($aY1[$mother] >= $aY1[$childr])
            {
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$childr] - 15)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$mother] - $aY1[$childr] - 39)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$childr] - $aX1[$mother] + 135)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }
            else
            {
                $htm .= "<table style='POSITION:absolute;LEFT:";//вертикально
                $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$mother] + 35)."px;BORDER-TOP:0pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:2pt solid;WIDTH:0px;HEIGHT:";
                $htm .= ($aY1[$childr] - $aY1[$mother] + 56)."px'><tr><td></td></tr></table>";
                $htm .= "<table style='POSITION:absolute;LEFT:";//горизонтально
                $htm .= ($aX1[$mother] - 15)."px;TOP:".($aY1[$childr] + 90)."px;BORDER-TOP:2pt solid;BORDER-BOTTOM:0pt solid;BORDER-RIGHT:0pt solid;BORDER-LEFT:0pt solid;WIDTH:";
                $htm .= ($aX1[$childr] - $aX1[$mother] + 135 - 3)."px;HEIGHT:0px'><tr><td></td></tr></table>";
            }

        }

    }

    return $htm;
}

?>
