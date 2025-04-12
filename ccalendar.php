<?php

Calendar();

//рисую все генеалогические ветви и фамилии
function Calendar()
{
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;

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

  global $mon;
  global $moz;
  global $week;
  global $weekday;

  global $mn_menu_calendar;

  global $nameyear;
  global $namemonth;
  global $nameday;

  if(isset($_GET['title'])) $title = $_GET['title'];//номер текущего года

//echo date("d/m/Y");
  $d = getdate(); // использовано текущее время
  //foreach ( $d as $key => $val ) echo "$key = $val";
//echo "<hr>Сегодня: $d[mday].$d[mon].$d[year]";

  $year = $d[year];
  $month = $d[mon];
  $day = $d[mday];

  // определить текущие переменные
  //??setlocale(LC_ALL,'ru_RU.UTF8','ru_RU','rus');
  $y = date('Y');//номер текущего года
  $m = date('n');//номер текущего месяца
  $d = date('d');//номер текущего дня
  $w = date('w');//порядковый номер дня недели

//echo "<hr>Сегодня1: ".$y.":".$m.":".$d.":".$w.":";

  if(isset($_GET['year'])) $year = $_GET['year'];//номер текущего года
  if(isset($_GET['month'])) $month = $_GET['month'];//номер текущего года
  if(isset($_GET['day'])) $day = $_GET['day'];//номер текущего года

//echo "<hr>Сегодня2: ".$year.":".$month.":".$day.":".$w.":";

  if(isset($_GET['year']) || !isset($_GET['year'])) $title .= " $nameyear $year";
  if(isset($_GET['month'])) $title .= " $namemonth $mon[$month]";
  if(isset($_GET['day'])) $title .= " $nameday $day";
  echo "<title>".$title."</title>";

  // нарисовать список Год
  echo '<table border=0 width=100%><tr><td align=center valign=center>';
  echo '<br>';
  echo '<div class="tag_tags">';
  for ($i = ($year - 5); $i <= ($year + 5); $i++) {
	echo "<a href=index.php?do=caln&year=$i&title=$title>$i</a>&nbsp;";
  }
  echo '</div><div class="clear"></div>';
  echo '</td></tr></table>';

  // нарисовать таблицу
  if(isset($_GET['day'])){
    echo "<center>";
    echo "<p><font size=+4>$nameyear $year</font></p>";
    echo "<p><font size=+8>$namemonth $mon[$month]</font></p>";
    echo "<p><font size=+12>$nameday $day</font></p>";

    LoadImenini1($month, $day);

    echo "</center>";
  }else
  if(isset($_GET['month'])){

    $row01 = 3;
    $col01 = 4;
    echo '<table border=0 width=100%>';
	$n = $month;
	if ($n != 0) {
	    echo '<div class="tag_tagc">';
	    echo '<a href="index.php?do=caln&year='.$year.'&month='.$n.'&title='.$title.'">'.$mon[$n].'</a>';
	    echo '</div><div class="clear"></div>';
	    // Определение дня недели первого числа месяца
	    $daybeg = date('w',strtotime('01.'.$n.'.'.$year)) - 1;
	    if ($daybeg < 0) {$daybeg = 6;}
	    //$daybeg = date("w",mktime(0, 0, 0, $n, 1, $year)) - 1;
	    // Определение количество дней в месяце
	    $curdate = strtotime('01.'.$n.'.'.$year);
	    $dayend = date("t",$curdate);
	    // нарисовать таблицу месяца
	    echo '<table border=0 width=100%>';
	    // нарисовать название дней недели
	    echo '<tr>';
	    for ($i = 1; $i <= 7; $i++) {
		echo '<td width=14% align=center valign=center><div class="tag_tagc1">';
		if (($i == 6) OR ($i == 7)) {
		    echo '<font color=red>';
		} else {
		    echo '<font color=green>';
		}
		echo ($week[$i]).'</font></div><div class="clear"></div></td>';
	    }
    	    echo '</tr>';
	    // нарисовать числа недели
	    $bw = 6;
	    $bh = 7;
	    for ($arow = 0; $arow < $bw; $arow++) {
	    echo '<tr>';
	    for ($acol = 0; $acol < $bh; $acol++) {
		$nn = $bh * $arow + $acol;//пересчитываю координаты ячейки в индекс списка
		if (($daybeg <= $nn) AND ($nn < ($daybeg + $dayend))) {
		    echo '<td width=14% height=50 align=center valign=center>';
		    if (GetBirthDay($n, ($nn - $daybeg + 1))) {
			echo '<div class="tag_tagb1">';
		    } else if ((($d - 1) == ($nn - $daybeg)) AND ($m == $n) AND ($y == $year)) {//если текущий день,месяц,год
			echo '<div class="tag_tagw1">';
		    } else if (GetHoliDay($n, ($nn - $daybeg + 1))) {
			echo '<div class="tag_tagh1">';
		    } else if (($acol == 5) OR ($acol == 6)) {
			echo '<div class="tag_tagm1">';
		    } else {
			echo '<div class="tag_tagn1">';
		    }
		    echo '<a href="index.php?do=caln&year='.$year.'&month='.$n.'&day='.($nn - $daybeg + 1).'&title='.$title.'">'.($nn - $daybeg + 1).'</a>';
		    echo '</font>';
		    echo '</div>';
		    echo '<div class="clear"></div>';
		    echo '</td>';
		} else {
		    echo '<td width=14% align=center valign=center>';
		    echo '&nbsp;';
		    echo '</td>';
		}
	    }
	    echo '</tr>';
	    }
	    echo '</table>';
	} else {
	    echo '&nbsp;';
	}
    echo '</table>';

  }else
  if(isset($_GET['year']) || !isset($_GET['year'])){
    $row01 = 3;
    $col01 = 4;
    echo '<table border=0 width=100%>';
    for ($yrow = 0; $yrow < $row01; $yrow++) {
	echo '<tr>';
    for ($ycol = 0; $ycol < $col01; $ycol++) {
	echo '<td align=center valign=top>';
	$n = NumMonthHorz( 1, $yrow+1, $ycol+1);
	if ($n != 0) {
	    echo '<div class="tag_tagc">';
	    echo '<a href="index.php?do=caln&year='.$year.'&month='.$n.'&title='.$title.'">'.$mon[$n].'</a>';
	    echo '</div><div class="clear"></div>';
	    // Определение дня недели первого числа месяца
	    $daybeg = date('w',strtotime('01.'.$n.'.'.$year)) - 1;
	    if ($daybeg < 0) {$daybeg = 6;}
	    //$daybeg = date("w",mktime(0, 0, 0, $n, 1, $year)) - 1;
	    // Определение количество дней в месяце
	    $curdate = strtotime('01.'.$n.'.'.$year);
	    $dayend = date("t",$curdate);
	    // нарисовать таблицу месяца
	    echo '<table border=0 width=100%>';
	    // нарисовать название дней недели
	    echo '<tr>';
	    for ($i = 1; $i <= 7; $i++) {
		echo '<td width=14% align=center valign=center><div class="tag_tagc1">';
		if (($i == 6) OR ($i == 7)) {
		    echo '<font color=red>';
		} else {
		    echo '<font color=green>';
		}
		echo ($week[$i]).'</font></div><div class="clear"></div></td>';
	    }
    	    echo '</tr>';
	    // нарисовать числа недели
	    $bw = 6;
	    $bh = 7;
	    for ($arow = 0; $arow < $bw; $arow++) {
	    echo '<tr>';
	    for ($acol = 0; $acol < $bh; $acol++) {
		$nn = $bh * $arow + $acol;//пересчитываю координаты ячейки в индекс списка
		if (($daybeg <= $nn) AND ($nn < ($daybeg + $dayend))) {
		    echo '<td width=14% height=50 align=center valign=center>';
		    if (GetBirthDay($n, ($nn - $daybeg + 1))) {
			echo '<div class="tag_tagb1">';
		    } else if ((($d - 1) == ($nn - $daybeg)) AND ($m == $n) AND ($y == $year)) {//если текущий день,месяц,год
			echo '<div class="tag_tagw1">';
		    } else if (GetHoliDay($n, ($nn - $daybeg + 1))) {
			echo '<div class="tag_tagh1">';
		    } else if (($acol == 5) OR ($acol == 6)) {
			echo '<div class="tag_tagm1">';
		    } else {
			echo '<div class="tag_tagn1">';
		    }
		    echo '<a href="index.php?do=caln&year='.$year.'&month='.$n.'&day='.($nn - $daybeg + 1).'&title='.$title.'">'.($nn - $daybeg + 1).'</a>';
		    echo '</font>';
		    echo '</div>';
		    echo '<div class="clear"></div>';
		    echo '</td>';
		} else {
		    echo '<td width=14% align=center valign=center>';
		    echo '&nbsp;';
		    echo '</td>';
		}
	    }
	    echo '</tr>';
	    }
	    echo '</table>';
	} else {
	    echo '&nbsp;';
	}
	echo '</td>';
    }
	echo '</tr>';
    }
    echo '</table>';
  }

}

function NumMonthHorz($nm, $rw, $cl)
{
  $cmatriz01[1][1] = 1; $cmatriz01[1][2] = 2; $cmatriz01[1][3] = 3; $cmatriz01[1][4] = 4;
  $cmatriz01[2][1] = 5; $cmatriz01[2][2] = 6; $cmatriz01[2][3] = 7; $cmatriz01[2][4] = 8;
  $cmatriz01[3][1] = 9; $cmatriz01[3][2] =10; $cmatriz01[3][3] =11; $cmatriz01[3][4] =12;
  switch ($nm) {
  case 1: return $cmatriz01[$rw][$cl];
  case 2: return $cmatriz02[$rw][$cl];
  case 3: return $cmatriz03[$rw][$cl];
  case 4: return $cmatriz04[$rw][$cl];
  case 5: return $cmatriz05[$rw][$cl];
  case 6: return $cmatriz06[$rw][$cl];
  case 7: return $cmatriz07[$rw][$cl];
  }
  return 0;
}

function GetBirthDay($nmon, $nday)
{
  global $persons;
/*
$string = '2015-07-05 06:02:09'; // наша дата в string
$date = new DateTime($string);

// день 
$day = $date->format('d'); // 05 
$day = $date->format('j'); // 5

// месяц 
$month = $date->format('m'); // 07 
$month = $date->format('n'); // 7 

// дней в указанном месяце 
$days = $date->format('t'); // 31 

// год 
$year = $date->format('Y'); // 2015 
$year = $date->format('y'); // 15

// день недели  1 - понедельник, 7 - воскресенье 
$dayWeek = $date->format('N'); // 7 

// порядковый номер дня в году 
$dayYear = $date->format('z'); // 185 (начинается с 0) 

// високосный год (0 - нет, 1 - да)
$year = $date->format('L'); // 0 

// timestamp
$timestamp = $date->getTimestamp(); // 143692932915
*/
  for ($i = 0; $i < count($persons); $i++) {
      $string = $persons[$i][$fldBEG]; // наша дата в string
      $date = new DateTime($string);
      // день 
      $day = $date->format('j'); // 5
      // месяц 
      $month = $date->format('n'); // 7 
      if ($month == $nmon & $day == $nday) {
        return true;
      }
  }
  return false;
}

function GetHoliDay($nmon, $nday)
{
  /*$q = mysql_query('SELECT name FROM holiday WHERE month='.$nmon.' AND day='.$nday)
	or die(mysql_error());
  if(mysql_num_rows($q) != 0) {
    return True;
  } else {
    return False;
  }*/
  return false;
}

function LoadImenini1($nmon, $nday)
{
  GLOBAL $imenini;
  $q = mysql_query('SELECT link FROM imenini WHERE month='.$nmon.' AND day='.$nday)
	or die(mysql_error());
  if(mysql_num_rows($q) != 0) {
    echo "<b>$imenini: </b>";
    while ($r = mysql_fetch_array($q)) {
	echo '<b>'.$r['link'].'</b>';
    }
  }
}

?>
