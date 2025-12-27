<?php

include_once("ccfg.php");
include_once("csub.php");
include_once("cutils.php");
include_once("cvars.php");

global $user;
global $https;
global $filter;

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
//echo "<br>".$url."<br>";

$filter = "";
if(isset($_GET['filter'])){
  $filter = $_GET['filter'];
}
if(isset($_POST['filter'])){
  $filter = $_POST['filter'];
  //header("Refresh: 0.5; index.php?filter=$filter");
}
//echo "<br>".$filter."<br>";

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

function _begin_html($user)
{
 global $getfile;
 global $timestamp;

 global $mn_menu_main;
 global $mn_menu_forest;
 global $mn_menu_tree;
 global $mn_menu_branch;
 global $mn_menu_rings;
 global $mn_menu_generation;
 global $mn_menu_calendar;
 global $mn_menu_glob;
 global $mn_menu_donate;
 global $mn_menu_apps;
 global $mn_menu_contact;
 global $mn_menu_about; 
 global $mn_menu_gedcom; 
 global $mn_menu_help; 
 global $ic_menu_file;
 global $ic_menu_load;
 global $ic_menu_delete;

 global $title, $descript, $keyword, $lang;

 if (!empty($_GET['title'])){
  $title = $_GET['title'];
 }else if (!empty($_GET['page'])){
  $title = $_GET['page'];
 }else if (!empty($_GET['appstores'])){
  $title = $_GET['appstores'];
 }
 $descript = $title;
 $key_word = str_replace("/",",",$descript);
 $key_word = str_replace(" ",",",$descript);
// $key_word = str_replace(".","",$descript);
// echo '<br><br><br><br><br>'.$title.'<br>'.$descript.'<br>'.$keyword;

 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title><?php echo $title; ?></title>
<meta name="description" content="<?php echo $descript; ?>">
<meta name="keywords" content="<?php echo $key_word; ?>">
<meta name="copyright" content="Конюхов Дмитрий Леонидович">

<!-- <meta http-equiv="refresh" content="10"> -->

<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/icons/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/icons/favicon-16x16.png">
<link rel="manifest" href="/icons/site.webmanifest">

<link rel="stylesheet" href="main.css">

</head>

<style>
.navbar {
    background-color: #e2d7b1;
    color: darkgrey;
    overflow: hidden;
    position: fixed;
    bottom: 0;
    width: 100%;
}

/* Style the links inside the navigation bar */
.navbar a {
    float: left;
    display: block;
    color: #f2f2f2;
    text-align: center;
    padding: 16px 18px;
    text-decoration: none;
    font-size: 20px;
}

/* Change the color of links on hover */
.navbar a:hover {
    background-color: #ddd;
    color: black;
}

/* Add a green background color to the active link */
.navbar a.active {
    background-color: #4CAF50;
    color: black;
}

/* Hide the link that should open and close the navbar on small screens */
.navbar .icon {
    display: none;
}
</style>

<style>
.menuskived {position:fixed;top:0px;left:0px;width:100%;padding:5px 0;text-transform: uppercase; text-align: center; line-height: 24px; background: #d5c48b; }
.menuskived ul {padding:0; margin:0;}
.menuskived li{display: inline;}
.menuskived li a {padding: 5px 20px; color: #fff;text-decoration: none;}
</style>

<style>
/* cookie */
 #cookiePopup {
    background: white;
    width: 25%;
    position: fixed;
    top: 100px;
    left: 100px;
    bottom: 300px;
    box-shadow: 0px 0px 15px #cccccc;
    padding: 5px 10px;
  }
    #cookiePopup p{
    text-align: left;
    font-size: 15px;
    color: #4e4e4e;
  }
  #cookiePopup button{
    width: 100%;
    border: navajowhite;
    background: #097fb7;
    padding: 5px;
    border-radius: 10px;
    color: white;
  }
</style>

<body style="background-color:#f0ead6;">

<div id="cookiePopup">
  <h4>Cookie Consent</h4>
  <p>Our website uses cookies to provide your browsing experience and relavent informations.Before continuing to use our website, you agree & accept of our  <a href="https://ru.wikipedia.org/wiki/Cookie" target="_blank">Cookie Policy & Privacy</a></p>
 <button id="acceptCookie">Accept</button> 
</div>

<script type="text/javascript">
// set cookie according to you
var cookieName= "CodingStatus";
var cookieValue="Coding Tutorials";
var cookieExpireDays= 30;

// when users click accept button
let acceptCookie= document.getElementById("acceptCookie");
acceptCookie.onclick= function(){
    createCookie(cookieName, cookieValue, cookieExpireDays);
}

// function to set cookie in web browser
 let createCookie= function(cookieName, cookieValue, cookieExpireDays){
  let currentDate = new Date();
  currentDate.setTime(currentDate.getTime() + (cookieExpireDays*24*60*60*1000));
  let expires = "expires=" + currentDate.toGMTString();
  document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
  if(document.cookie){
    document.getElementById("cookiePopup").style.display = "none";
  }else{
    alert("Unable to set cookie. Please allow all cookies site from cookie setting of your browser");
  }

 }

// get cookie from the web browser
let getCookie= function(cookieName){
  let name = cookieName + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
// check cookie is set or not
let checkCookie= function(){
    let check=getCookie(cookieName);
    if(check==""){
        document.getElementById("cookiePopup").style.display = "block";
    }else{
        
        document.getElementById("cookiePopup").style.display = "none";
    }
}
checkCookie();
</script>

<script language="javascript">
   //alert(screen.width + "*" + screen.height);
   var expires = "";
   var days = 1;
   var date = new Date();
   date.setTime(date.getTime() + (days*24*60*60*1000));
   expires = "; expires=" + date.toUTCString();
   document.cookie = "screen_width" + "=" + screen.width+expires + "; path=/"; 
   document.cookie = "screen_height" + "=" + screen.height+expires + "; path=/"; 
   //alert(document.cookie);
</script>

<?php
 if(isset($_COOKIE['myfamilytree_gedcom'])){   //echo 'Куки успешно установлены!<br>';
   $getfile = 'gedcom/'.$_COOKIE['myfamilytree_gedcom'];
 }else{   //echo 'Куки НЕ установлены!<br>';
   $getfile = 'gedcom/kings.ged';
 }

//echo "<br><br><br><br>";print_r($user);echo $user['id'].":".$user['name'].":".$user['status'].":".$user['acces']."<br>";

 $id_person = '';
 $do = 'cmain';
 if (!empty($_GET['do'])) $do = $_GET['do'];
 if (!empty($_POST['do'])) $do = $_POST['do'];
 if ($do == 'cpersone') {
   $id_person = '&id='.$_GET['id'];
 }
 echo '<div class="menuskived defaultskived">';
 echo '<table><tr><td aling=center valign=center>';
 echo '<a href="'.$https.'"><img src="icons/icon301.png" height=48 width=48></a>';
 echo '</td><td>';
 echo '<table><tr><td>';
 echo '<ul>';
 echo '<li><a href=?do=cmain'.$id_person.'&title='.$mn_menu_main.'><img src="icons/mn_menu_book.png" height=36 width=36>'.$mn_menu_main.'</a></li>';
 echo '<li><a href=?do=cforest'.$id_person.'&title='.$mn_menu_forest.'><img src="icons/mn_menu_forests.png" height=36 width=36>'.$mn_menu_forest.'</a></li>';
 echo '<li><a href=?do=ctree'.$id_person.'&title='.$mn_menu_tree.'><img src="icons/mn_menu_tree.png" height=36 width=36>'.$mn_menu_tree.'</a></li>';
 echo '<li><a href=?do=cbranch'.$id_person.'&title='.$mn_menu_branch.'><img src="icons/mn_menu_branch.png" height=36 width=36>'.$mn_menu_branch.'</a></li>';
 echo '<li><a href=?do=crings'.$id_person.'&title='.$mn_menu_rings.'><img src="icons/mn_menu_ring.png" height=36 width=36>'.$mn_menu_rings.'</a></li>';
 echo '<li><a href=?do=cgenr'.$id_person.'&title='.$mn_menu_generation.'><img src="icons/mn_menu_genr.png" height=36 width=36>'.$mn_menu_generation.'</a></li>';
 echo '<li><a href=?do=ccaln'.$id_person.'&title='.$mn_menu_calendar.'><img src="icons/mn_menu_calendar.png" height=36 width=36>'.$mn_menu_calendar.'</a></li>';
 echo '<li><a href=?do=cglob'.$id_person.'&title='.$mn_menu_glob.'><img src="icons/mn_menu_glob.png" height=36 width=36>'.$mn_menu_glob.'</a></li>';
 echo '</ul>';
 echo '</td></tr></table>';
 echo '</td></tr></table>';
 echo '</div>';

}

function _index_html($user)
{
 global $getfile;
 global $timestamp;

 GLOBAL $persons;
 GLOBAL $gedcoms;
 GLOBAL $gedcom;
 global $getfile;
 global $user;
 global $lang;
 //global $page;

 global $title;
 global $cattitle;
 global $mn_menu_main;
 global $mn_menu_forest;
 global $mn_menu_tree;
 global $mn_menu_branch;
 global $mn_menu_rings;
 global $mn_menu_generation;
 global $mn_menu_calendar;
 global $mn_menu_glob;
 global $mn_menu_donate;
 global $mn_menu_apps;
 global $mn_menu_contact;
 global $mn_menu_about; 
 global $ic_menu_file;
 global $ic_menu_load;
 global $ic_menu_delete;
 global $filter;

//=== FILES =================================== //
echo "<br><br><br>";

if (!empty($_GET['page'])){
	$page = $lang."/".$_GET['page'].".html";
	echo "<br><br>";
	include_once($page);
}else if (!empty($_GET['appstores'])){
	$page = $lang."/appstores/".$_GET['appstores'].".html";
	echo "<br><br>";
	include_once($page);
}else{
	$getfile ='';
	if(isset($_COOKIE['myfamilytree_gedcom'])){   //echo 'Куки успешно установлены!<br>';
		$getfile = 'gedcom/'.$_COOKIE['myfamilytree_gedcom'];
	}else{   //echo 'Куки НЕ установлены!<br>';
		if ($user['id'] < 1) $getfile = 'gedcom/kings.ged';
	}

	$do = 'cmain';
	if (!empty($_GET['do'])) $do = $_GET['do'];
	if (!empty($_POST['do'])) $do = $_POST['do'];

// test reload
	$tmstmp = file_get_contents("timestamp");
	if(isset($_COOKIE["timestamp"])) {
		$timestamp = $_COOKIE['timestamp'];
//echo "===TimeStamp=1=".$timestamp."<br>";
		if($timestamp != $tmstmp){
			$timestamp = $tmstmp;
//echo "===TimeStamp==".$timestamp."<br>";

//   setcookie('timestamp', $timestamp);
?>
<script language="javascript">
   var name = 'timestamp';
   var value = '<? echo $tmstmp; ?>';
   var days = 7;
   var date = new Date();
   date.setTime(date.getTime() + (days*24*60*60*1000));
   expires = "; expires=" + date.toUTCString();
   document.cookie = name + "=" + (value || "")  + expires + "; path=/";
   //alert(document.cookie);
</script>
<?
		}
		include_once("cimport.php");
	} else {
//   setcookie('timestamp', $tmstmp);
?>
<script language="javascript">
   var name = 'timestamp';
   var value = '<? echo $tmstmp; ?>';
   var days = 7;
   var date = new Date();
   date.setTime(date.getTime() + (days*24*60*60*1000));
   expires = "; expires=" + date.toUTCString();
   document.cookie = name + "=" + (value || "")  + expires + "; path=/";
   //alert(document.cookie);
</script>
<?
		$timestamp = $_COOKIE['timestamp'];
//echo "===TimeStamp=2=".$timestamp."<br>";
		if(count((array)$persons) == 0){
			include_once("cimport.php");
		}
	}

	if ($do == 'cmain') {
		include_once("cgeneral.php");
	} else if ($do == 'cpersone') {
		include_once("cpersone.php");
	} else if ($do == 'cperson') {
		include_once("cperson.php");
	} else if ($do == 'cforest') {
		include_once("cforest.php");
	} else if ($do == 'ctree') {
		include_once("ctree.php");
	} else if ($do == 'cbranch') {
		include_once("cbranch.php");
	} else if ($do == 'crings') {
		include_once("crings.php");
	} else if ($do == 'cgenr') {
		include_once("cgenr.php");
	} else if ($do == 'ccaln') {
		include_once("ccalendar.php");
	} else if ($do == 'cglob') {
		include_once("cglob.php");
	} else if ($do == 'cgedcomv') {
		include_once("cgedcomv.php");
	} else if ($do == 'csearch') {
		include_once("csearch.php");
	} else if ($do == 'cdonate') {
		include_once("cdonate.php");
	} else if ($do == 'ccontact') {
		include_once("ccontact.php");
	} else if ($do == 'cprivacy') {
		include_once($lang."/cprivacy.php");
	} else if ($do == 'cmission') {
		include_once($lang."/cmission.php");
	} else if ($do == 'chelp') {
		include_once("chelp.php");
	} else if ($do == 'cappstores') {
		echo '<br><br>';
		include_once($lang."/appstores/appstores.html");
	} else if ($do == 'cuseful') {
		echo '<br><br>';
		include_once($lang."/index.html");
	} else if ($do == 'user') {
		include_once("cuser.php");
	} else if ($do == 'logout') {
		if($user['id'] > 0){
			include_once("clogout.php");
		}else{
			include_once("index.php");
		}
	} else if ($do == 'login') {
		include_once("clogin.php");
	} else if ($do == 'regs') {
		include_once("cregs.php");
	} else if ($do == 'forgot') {
		include_once("cforgot.php");
	} else if ($do == 'cupload') {//   include_once("upload.php");
	}

/*=========================================*/
//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
//echo "===File==".$getfile."<br>";
//echo "===Persons==".Count($persons)."<br>";
//echo "===User==".$user['id']."<br>";
//echo "===do=".$do."<br>";
//echo "<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>";
/*=========================================*/

	if (
	$do != 'cpersone' && 
	$do != 'cforest' &&
	$do != 'ctree' &&
	$do != 'cbranch' &&
	$do != 'crings' &&
	$do != 'cgenr' &&
	$do != 'ccaln' &&
	$do != 'cglob')
	{
?>
<script>
  function autoRefresh() {
    window.location = window.location.href;
  }

  setInterval('autoRefresh()', 15000);
</script>
<?
	}
	$do = '';
}

}

function _end_html($user)
{
 GLOBAL $gedcoms;
 GLOBAL $gedcom;
 global $getfile;
 global $user;
 global $lang;
 //global $page;

 global $mn_menu_main;
 global $mn_menu_tree;
 global $mn_menu_branch;
 global $mn_menu_rings;
 global $mn_menu_generation;
 global $mn_menu_calendar;
 global $mn_menu_glob;
 global $mn_menu_donate;
 global $mn_menu_apps;
 global $mn_menu_contact;
 global $mn_menu_privacy; 
 global $mn_menu_mission; 
 global $mn_menu_useful; 
 global $mn_menu_help; 
 global $ic_menu_add;
 global $ic_menu_file;
 global $ic_menu_load;
 global $ic_menu_delete;
 global $ic_menu_filter;
 global $filter;

 echo '<div class="navbar" id="myNavbar">';
 echo '<table><tr><td align=center valign=center>';
 echo '<a href="?do=cpersone&id=0&title='.$ic_menu_add.'"><img src="icons/ic_menu_add.png" width=24 height=24>'.$ic_menu_add.'</a>';
// echo '<a href="?lang='.$lang.'&do=chelp&title='.$mn_menu_help.'"><img src="icons/ic_menu_help.png" width=24 height=24>'.$mn_menu_help.'</a>';
 echo '</td><td align=center valign=center>';
?>
<form method="POST" action="index.php?filter=<?php echo $filter; ?>">
    <input type="text" name="filter" value="<?php echo $filter; ?>">
    <input type="submit" value="&#128269;">
</form>
<?php
 echo '</td><td align=center valign=center>';
 if (!empty($user)) {
   echo "&nbsp;<a href=mailto:".$user['name'].">".$user['name']."</a>&nbsp;"; 
   echo "&nbsp;<a href=?do=user>Кабинет</a>&nbsp;";
   echo "&nbsp;<a href=?do=logout>Выйти</a>&nbsp;";
 } else {
   echo "&nbsp;<a href=?do=login>Войти</a>&nbsp;";
 }
 echo '</td><td align=center valign=center>';
 if($user['id'] == 1) {
   echo '<form action="cupload.php?lang='.$lang.'&do=cupload" method="post" enctype="multipart/form-data">';
   if(!isset($_COOKIE['myfamilytree_gedcom']))
   {
     echo '<input type="file" id="mygedcom" name="file">';
     echo '<input type="submit" name="load" value="'.$ic_menu_load.'">';
   }else{
     echo ' '.$getfile;
     echo '<input type="submit" name="delete" value="'.$ic_menu_delete.'">';
   }
   echo '</form>';
 }
 echo '</td></tr></table>';
 echo '</div>';
 ?>

 </body>
 </html>
 <?
}

function _regs_html()
{
 global $lang;
 global $mn_menu_main;
 global $mn_menu_tree;
 global $mn_menu_branch;
 global $mn_menu_rings;
 global $mn_menu_generation;
 global $mn_menu_calendar;
 global $mn_menu_glob;
 global $mn_menu_donate;
 global $mn_menu_apps;
 global $mn_menu_contact;
 global $mn_menu_about; 
 global $ic_menu_file;
 global $ic_menu_load;
 global $ic_menu_delete;

 $msg = $GLOBALS["msg"];
 global $hello, $txtreg1, $lgnmail, $pwd1, $pwd2, $fio, $country, $post, $city, $adres, $phone, $www, $note, $registr; 

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";
 ?>
 <br><br><br><br>
 <center>
 <table width="80%" align="left" border="0" cellpadding="2">
  <b><p align="center"><?php echo $hello; ?></p>
  <p align="left"><b><?php echo $txtreg1; ?></b></p>

 <form name="adduser" action="cregs.php" method="post">
 <tr><td width="30%"><?php echo $lgnmail; ?><font color=red>*</font>: </td>
  <td width="70%"><input type="text" name="user" size="40"></td>
 </tr>
 <tr><td><?php echo $pwd1; ?><font color=red>*</font>: </td>
  <td><input type="password" name="pass" size="20"></td>
 </tr>
 <tr><td><?php echo $pwd2; ?><font color=red>*</font>: </td>
  <td><input type="password" name="pass1" size="20"></td>
 </tr>
 <tr><td><?php echo $fio; ?></td>
  <td><input type="text" name="fio" size="60"></td>
 </tr>
 <tr><td><?php echo $country; ?></td>
  <td><input type="text" name="country" size="20"></td>
 </tr>
 <tr><td><?php echo $post; ?></td>
  <td><input type="text" name="postcode" size="10"></td>
 </tr>
 <tr><td><?php echo $city; ?></td>
  <td><input type="text" name="city" size="30"></td>
 </tr>
 <tr><td><?php echo $adres; ?></td>
  <td><input type="text" name="address" size="70"></td>
 </tr>
 <tr><td><?php echo $phone; ?></td>
  <td><input type="text" name="phone" size="20"></td>
 </tr>
 <tr><td><?php echo $www; ?></td>
  <td><input type="text" name="http" size="40"></td>
 </tr>
 <tr><td><?php echo $note; ?></td>
  <td><textarea name="notes" rows="5" cols="80"></textarea></td>
 </tr>
 <tr><td colspan="2" align="center">
  <input type="submit" name="submit" value="<?php echo $registr; ?>" onclick="javascript:return checkadduser()">
  </td>
 </tr>
 </form>

 <br><br><br><br>
 </table>
 </center>
 <br><br>
 <?
}

function _login_html()
{
 global $lang;
 $msg = $GLOBALS["msg"];
 $prm1 = $GLOBALS["prm1"];
 $prm2 = $GLOBALS["prm2"];
 global $lgn1,$pwd3,$foglgn1,$registr,$fogpwd3,$enter1;

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";
 ?>
 <br><br><br><br>
 <center>
 <table width="350" align="center" border="0" cellpadding="2">
 <form action="clogin.php" method="post">
 <tr><td><?php echo $lgn1; ?></td>
   <td><input type="text" name="user" size="40" value="<?php echo $prm1; ?>"></td>
 </tr>
 <tr><td><?php echo $pwd3; ?></td>
  <td><input type="password" name="pass" size="20" value="<?php echo $prm2; ?>"></td>
 </tr>
 <tr><td colspan="2" align="center">
  <?php echo $foglgn1; ?><input type="checkbox" name="rem" value="1" checked>
  </td>
 </tr>   
 <tr><td colspan="2" align="center">
  <input type="submit" name="login" value="<?php echo $enter1; ?>">
  </td>
 </tr>
 <tr><td colspan="2" align="center">
  <p align="center"><b><a href=?lang=<?php echo $lang; ?>&do=regs><?php echo $registr; ?></a></b></p>
  <p align="center"><a href=?lang=<?php echo $lang; ?>&do=forgot><?php echo $fogpwd3; ?></a></p>
  </td>
 </tr>
 </form>
 <br><br><br><br>
 </table>
 </center>
 <br>
 <?
}

function _logout_html()
{
 global $lang;
 global $do;
 global $error14;
 $msg = $GLOBALS["msg"];

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";

 if(isset($_COOKIE['myfamilytree_gedcom'])){
   $getfile = 'gedcom/'.$_COOKIE['myfamilytree_gedcom'];
   echo "DELETE=$getfile<br>";
   echo $error14."<br>";
   unset($_COOKIE['myfamilytree_gedcom']);
   setcookie("myfamilytree_gedcom", "", time()-3600); 
   unlink($getfile);
 }

 $do = "";
 ?>
 <br><br><br><br>
 <?
}

function _forgot_html()
{
 $msg = $GLOBALS["msg"];
 $prm1 = $GLOBALS["prm1"];
 global $lgn1,$fog1;

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";
 ?>
 <br><br><br><br>
 <center>
 <table width="350" align="center" border="0" cellpadding="2">
 <form action="cforgot.php" method="post">
 <tr><td><?php echo $lgn1; ?></td>
   <td><input type="text" name="user" size="40" value="<?php echo $prm1; ?>"></td>
 </tr>
 <tr><td colspan="2" align="center">
  <input type="submit" name="forgot" value="<?php echo $fog1; ?>">
  </td>
 </tr>
 </form>
 <br><br><br><br>
 </table>
 </center>
 <br>
 <?
}

function _edit_user($user)
{
 $msg = $GLOBALS["msg"];
 global $edtt, $lgnmail, $pwdold, $pwdnew1, $pwdnew2, $pwdizm, $fio, $country, $post, $city, $adres, $phone, $www, $note, $registr, $save; 

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";

 ?>
 <br><br><br><br>
 <table width="350" align="left" border="0" cellpadding="2">
 <b><?php echo $edtt; ?></b>
 <form name="adduser" action="cuser.php" method="post">
 <tr><td><?php echo $lgnmail; ?></td>
  <td><b><?php echo $user['name']; ?></b></td>
 </tr>
 <tr><td><?php echo $pwdold; ?></td>
  <td><input type="password" name="pass" size="20"></td>
 </tr>
 <tr><td><?php echo $pwdnew1; ?></td>
  <td><input type="password" name="pass1" size="20"></td>
 </tr>
 <tr><td><?php echo $pwdnew2; ?></td>
  <td><input type="password" name="pass2" size="20"></td>
 </tr>
 <tr><td colspan="2" align="left">
  <input type="submit" name="savepass" value="<?php echo $pwdizm; ?>">
  </td>
 </tr>
 <tr><td><?php echo $fio; ?></td>
  <td><input type="text" name="fio" size="60" value="<?php echo $user['fio']; ?>"></td>
 </tr>
 <tr><td><?php echo $country; ?></td>
  <td><input type="text" name="country" size="20" value="<?php echo $user['country']; ?>"></td>
 </tr>
 <tr><td><?php echo $post; ?></td>
  <td><input type="text" name="postcode" size="10" value="<?php echo $user['postcode']; ?>"></td>
 </tr>
 <tr><td><?php echo $city; ?></td>
  <td><input type="text" name="city" size="30" value="<?php echo $user['city']; ?>"></td>
 </tr>
 <tr><td><?php echo $adres; ?></td>
  <td><input type="text" name="address" size="80" value="<?php echo $user['address']; ?>"></td>
 </tr>
 <tr><td><?php echo $phone; ?></td>
  <td><input type="text" name="phone" size="20" value="<?php echo $user['phone']; ?>"></td>
 </tr>
 <tr><td><?php echo $www; ?></td>
  <td><input type="text" name="http" size="40" value="<?php echo $user['http']; ?>"></td>
 </tr>
 <tr><td><?php echo $note; ?></td>
  <td><textarea name="notes" rows="5" cols="80"><?php echo $user['notes']; ?></textarea></td>
 </tr>
 <tr><td colspan="2" align="center">
  <input type="submit" name="saveuser" value="<?php echo $save; ?>">
  </td>
 </tr>
 <tr><td><br><br><br><br></td></tr>
 </form>
 </table>
 
 <br><br>
 <?
}

function _draw_user($Q)
{
 echo "<br><br><br><br><br><br>";  
 echo "<table>";
 while ($vars = mysql_fetch_array($Q)) {
  echo "<tr><td><h4>ID: ".$vars['id']."</h4></td></tr>";
  echo "<tr><td><h4>EMAIL: ".$vars['name']."</h4></td></tr>";
  echo "<tr><td>fio: ".$vars['fio']."</td></tr>";
  echo "<tr><td>country: ".$vars['country']."</td></tr>";
  echo "<tr><td>postcode: ".$vars['postcode']."</td></tr>";
  echo "<tr><td>city: ".$vars['city']."</td></tr>";
  echo "<tr><td>address: ".$vars['address']."</td></tr>";
  echo "<tr><td>phone: ".$vars['phone']."</td></tr>";
  echo "<tr><td>http: ".$vars['http']."</td></tr>";
  echo "<tr><td>notes: ".$vars['notes']."</td></tr>";
 }
 echo "</table>";  
 echo "<br>";  
}

// привожу правильный вариант этой функции (с комментариями):
// $filepath – путь к файлу, который мы хотим отдать
// $mimetype – тип отдаваемых данных (можно не менять)
function func_download_file($filepath, $mimetype = 'application/octet-stream') {
 $fsize = filesize($filepath); // берем размер файла
 $ftime = date('D, d M Y H:i:s T', filemtime($filepath)); // определяем дату его модификации
 $fd = @fopen($filepath, 'rb'); // открываем файл на чтение в бинарном режиме
 if (isset($_SERVER['HTTP_RANGE'])) { // поддерживается ли докачка?
    $range = $_SERVER['HTTP_RANGE']; // определяем, с какого байта скачивать файл
    $range = str_replace('bytes=', '', $range);
    list($range, $end) = explode('-', $range);
    if (!empty($range)) {
	fseek($fd, $range);
    }
 } else { // докачка не поддерживается
    $range = 0;
 }
 if ($range) {
    header($_SERVER['SERVER_PROTOCOL'].' 206 Partial Content'); // говорим браузеру, что это часть какого-то контента
 } else {
    header($_SERVER['SERVER_PROTOCOL'].' 200 OK'); // стандартный ответ браузеру
 }
// прочие заголовки, необходимые для правильной работы
 header('Content-Disposition: attachment; filename='.basename($filepath));
 header('Last-Modified: '.$ftime);
 header('Accept-Ranges: bytes');
 header('Content-Length: '.($fsize - $range));
 if ($range) {
    header("Content-Range: bytes $range-".($fsize - 1).'/'.$fsize);
 }
 header('Content-Type: '.$mimetype);
 fpassthru($fd); // отдаем часть файла в браузер (программу докачки)
 fclose($fd);
 exit;
}

?>
