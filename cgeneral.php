<?php

General();

function General()
{
  global $lang;

  global $peoples;
  global $persons;
  global $getdir;
  global $page;
  global $cellw;
  global $cellh;

  global $fldINX;
  global $fldID;

  global $fldBEG;
  global $fldEND;
  GLOBAL $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldPLB;
  global $fldPLD;
  global $fldSPS;
  global $fldNOTE;
  global $fldICON;

  global $field_birth;
  global $field_death;


//$filename = __DIR__ . '/file.txt';
$tstamp = file_get_contents("timestamp");
?>

<script type="text/javascript">
  //if(<?php $tstamp ?> != <?php $timestamp ?>){
    setTimeout(function(){
//      window.location.href = window.location.href;
    },10000)
  //}
</script>

<?php
 if($tstamp != $timestamp){
   $timestamp = $tstamp;
 }

  // разбивка на страницы
  if(empty($_GET["p"])){$_GET["p"]="1";}// страницы
  $p = $_GET["p"];// страница
  
  $count = count($persons);// считаем файлы
  $total = ceil($count/$page);// считаем страницы

  echo "<br><br>";

GLOBAL $user;
$users = _check_datauserid($user['id']);

//print_r($user);echo "<br>";
//print_r($users)."<br>";
//echo $users['id'].":".$users['name'].":".$users['status'].":".$users['acces']."<br>";
//$file = __DIR__ ."/cards/$number.card";
//echo "file=$file <br>";
//echo "p=$p <br>";
//echo "count=$count <br>";
//echo "total=$total <br>";
//echo "userId=".$_COOKIE['myfamilytree_userid']."userName=".$_COOKIE['myfamilytree_username']."<br>";
//echo "userId=".$user['id']."userName=".$user['name']."<br>";

  if($total>1):
	#две назад
	print "<font size=+2>";
	if(($p-2)>0):
	  $ptwoleft="<a class='first_page_link' href='?lang=".$lang."&do=cmain&p=".($p-2)."&n=$getname&m=$getmemo&l=$getlink'>".($p-2)."</a>  ";
	else:
	  $ptwoleft=null;
	endif;
			
	#одна назад
	if(($p-1)>0):
	  $poneleft="<a class='first_page_link' href='?lang=".$lang."&do=cmain&p=".($p-1)."&n=$getname&m=$getmemo&l=$getlink'>".($p-1)."</a>  ";
	  $ptemp=($p-1);
	else:
	  $poneleft=null;
	  $ptemp=null;
	endif;
			
	#две вперед
	if(($p+2)<=$total):
	  $ptworight="  <a class='first_page_link' href='?lang=".$lang."&do=cmain&p=".($p+2)."&n=$getname&m=$getmemo&l=$getlink'>".($p+2)."</a>";
	else:
	  $ptworight=null;
	endif;
			
	#одна вперед
	if(($p+1)<=$total):
	  $poneright="  <a class='first_page_link' href='?lang=".$lang."&do=cmain&p=".($p+1)."&n=$getname&m=$getmemo&l=$getlink'>".($p+1)."</a>";
	  $ptemp2=($p+1);
	else:
	  $poneright=null;
	  $ptemp2=null;
	endif;		
			
	# в начало
	if($p!=1 && $ptemp!=1 && $ptemp!=2):
	  $prevp="<a href='?lang=".$lang."&do=cmain&n=$getname&m=$getmemo&l=$getlink' class='first_page_link' title='Begin'><<</a> ";
	else:
	  $prevp=null;
	endif;   
			
	#в конец (последняя)
	if($p!=$total && $ptemp2!=($total-1) && $ptemp2!=$total):
	  $nextp=" ...  <a href='?lang=".$lang."&do=cmain&p=".$total."'".$total."' class='first_page_link'>$total</a>";
	else:
	  $nextp=null;
	endif;
		
	print "<br>".$prevp.$ptwoleft.$poneleft.'<span class="num_page_not_link"><b>'.$p.'</b></span>'.$poneright.$ptworight.$nextp; 
	print "</font>";
  endif;
?>

<?php
  $scrwidth = $_COOKIE['screen_width'];
  $scrheight = $_COOKIE['screen_height'];

  // проверяем существование переменных $width и $height
  if (isset($_GET['scrwidth']) AND isset($_GET['scrheight'])) {
    // если переменные существуют, то выводим полученные значения на экран
    $scrwidth = $_GET['scrwidth'];
    $scrheight = $_GET['scrheight'];
  }// если переменные не существуют, то выполняем следующее
  else {
   if (empty($scrwidth) AND empty($scrheight)) {
    // PHP сгенерирует код JavaScript, который обработает браузер
    // пользователя и передаст значения обратно PHP-скрипту через протокол HTTP
    echo "<script language='javascript'>\n";
    echo " location.href=\"${_SERVER['SCRIPT_NAME']}?${_SERVER['QUERY_STRING']}"
            . "scrwidth=\" + screen.width + \"&scrheight=\" + screen.height;\n";
    echo "</script>\n";
   }
  }

  $cols = (int)ceil($scrheight/$cellw);// Количество столбцов в будущей таблице с картинками
  if($scrwidth > $scrheight) $cols = (int)round($scrwidth/$cellw);

  $k = 0; // Вспомогательный счётчик для перехода на новые строки
  $b = 0;
  echo "<table>\n"; // Начинаем таблицу
  for ($i = ($p-1)*$page; $i < $p*$page; $i++) { // Перебираем все файлы

      if($count == $i) $b = 1;
      if($b == 0){

      if ($k % $cols == 0) echo "<tr heigth='$cellh'>\n"; // Добавляем новую строку
      $gender = $persons[$i][$fldSEX];
      // Начинаем столбец
      if($gender=='1') {echo "<td bgcolor='#00ffff' width='$cellw' heigth='$cellh'>";}
      else if($gender=='2') {echo "<td bgcolor='#ffc0cb' width='$cellw' heigth='$cellh'>";}
      else {echo "<td width='$cellw' heigth='$cellh'>";}

      $inx = $persons[$i][$fldINX];
      $id = $persons[$i][$fldID];
      $name = $persons[$i][$fldPER];
      echo "<a href=?do=cperson&id=".$id.">";
      echo "<b>".$name."</b></a>&nbsp;&nbsp;";

      if($users['id'] > 0 && $users['acces'] < 2){
        echo "<a href=?do=cpersone&id=".$id."><img src='icons/ic_menu_edit.png' witdh=24 height=24></a>";
      }

      echo "<a href=?do=cperson&id=".$id.">";
      if(!empty($persons[$i][$fldICON])){
	$src = "<img src='data:image/jpeg;base64,".$persons[$i][$fldICON]."' width='$cellw' heith='$cellh'>";
	echo $src;
      }else{
        $path = '';
        if($gender=='1') {$path = "icons/Avatar64_Man.png";}
        else if($gender=='2') {$path = "icons/Avatar64_Woman.png";}
        else {$path = "icons/Avatar64.png";}
	echo "<img src='$path' alt='$name' title='$name' width='$cellw' heith='$cellh'>";
      }

      echo "</a>"; // Закрываем ссылку
      if(!empty($persons[$i][$fldBEG])) echo "<p><i>".$field_birth.":</i> ".$persons[$i][$fldBEG]."</p>";
      if(!empty($persons[$i][$fldEND])) echo "<p><i>".$field_death.":</i> ".$persons[$i][$fldEND]."</p>";
      //echo "<p><i>".$persons[$i][$fldINX].":</i> ".$persons[$i][$fldID]."</p>";
      //if(!empty($father)) echo "<p><i>Father:</i> ".$father."</p>";
      //if(!empty($mother)) echo "<p><i>Mother:</i> ".$mother."</p>";
      echo "</td>\n"; // Закрываем столбец
      /* Закрываем строку, если необходимое количество было выведено, либо данная итерация последняя */
      if ((($k + 1) % $cols == 0) || (($i + 1) == count($peoples))) echo "</tr>\n";
      $k++; // Увеличиваем вспомогательный счётчик
      }
  }
  echo "</table>\n"; // Закрываем таблицу
  //echo "<h4>".$getmemo."</h4>";

//for ($i = 0; $i < count($persons); $i++) echo "PERSON: ".$persons[$i][0]."|".$persons[$i][1]."|".$persons[$i][2]."|".$persons[$i][3]."|".$persons[$i][4]."|".$persons[$i][5]."|".$persons[$i][6]."|".$persons[$i][7]."|".$persons[$i][8]."|".$persons[$i][9]."|".$persons[$i][12]."|".$persons[$i][13]."|".$persons[$i][14]."<br>";
//for ($i = 0; $i < count($persons); $i++) echo "PERSON: ".$persons[$i][$fldBEG]."|".$persons[$i][$fldEND]."|".$persons[$i][$fldPER]."|".$persons[$i][$fldFAT]."|".$persons[$i][$fldMOT]."|".$persons[$i][$fldSEX]."|".$persons[$i][$fldICON]."|"."<br>";

  echo "<p><br></p>";
}


?>

 </body>
 </html>
