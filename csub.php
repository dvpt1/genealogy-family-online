<?php

if (version_compare(PHP_VERSION, '7.0.0','>=')) include 'mysql.php';
//include_once("ccfg.php");
include_once("cvars.php");
include_once("cutils.php");

mysql_connect($CONFIG['HOST_NAME'], $CONFIG['DB_USERNAME'], $CONFIG['DB_PASSWORD'])
 or die(mysql_error());
mysql_select_db($CONFIG['DATABASE_NAME'])
 or die(mysql_error());
mysql_query('SET character_set_database = utf8');
mysql_query("SET CHARACTER SET UTF8");
mysql_query('SET NAMES utf8');

function _check_database($user, $pass)
{
  $Q = mysql_query(" SELECT id FROM cusers WHERE name = '$user' AND pass = '$pass' ");
  if(mysql_num_rows($Q) == 0) return 0;
  else return mysql_fetch_array($Q);
}

function _check_datausers()
{
//id,name,pass,fio,country,postcode,city,address,phone,http,activation,status,acces,two_factor_code,two_factor_expires_at,notes
  $query = "SELECT `id`,`name`,`pass`,`fio`,`country`,`postcode`,`city`,`address`,`phone`,`http`,`activation`,`status`,`acces`,`two_factor_code`,`two_factor_expires_at`,`notes` FROM `cusers`";
  $result = mysql_query($query);
  return $result;
}

function _check_datauser($user)
{
  $Q = mysql_query(" SELECT `id`,`name`,`pass`,`fio`,`country`,`postcode`,`city`,`address`,`phone`,`http`,`activation`,`status`,`acces`,`two_factor_code`,`two_factor_expires_at`,`notes` FROM cusers WHERE `name` = '$user' ");
  if(mysql_num_rows($Q) == 0) return 0;
  else {
    $usr = array();
    $r = mysql_fetch_array($Q);
    $usr['id']   = $r['id'];
    $usr['name'] = $r['name'];
    $usr['pass'] = $r['pass'];
    $usr['fio'] = $r['fio'];
    $usr['country'] = $r['country'];
    $usr['postcode'] = $r['postcode'];
    $usr['city'] = $r['city'];
    $usr['address'] = $r['address'];
    $usr['phone'] = $r['phone'];
    $usr['http'] = $r['http'];
    $usr['notes'] = $r['notes'];
    $usr['activation'] = $r['activation'];
    $usr['status'] = $r['status'];
    $usr['acces'] = $r['acces'];
    return $usr;
  }
}

function _check_useract($user)
{
  $Q = mysql_query(" SELECT id,activation,status,acces,two_factor_code,two_factor_expires_at FROM cusers WHERE name = '$user' ");
  if(mysql_num_rows($Q) == 0) return 0;
  else {
    $usr = array();
    $r = mysql_fetch_array($Q);
    $usr['id']   = $r['id'];
    $usr['activation'] = $r['activation'];
    $usr['status'] = $r['status'];
    $usr['acces'] = $r['acces'];
    $usr['two_factor_code'] = $r['two_factor_code'];
    $usr['two_factor_expires_at'] = $r['two_factor_expires_at'];
    return $usr;
  }
}

function _check_datauserid($id)
{
  $Q = mysql_query(" SELECT `id`,`name`,`pass`,`fio`,`country`,`postcode`,`city`,`address`,`phone`,`http`,`activation`,`status`,`acces`,`two_factor_code`,`two_factor_expires_at`,`notes` FROM cusers WHERE `id` = '$id' ");
  if(mysql_num_rows($Q) == 0) return 0;
  else {
    $usr = array();
    $r = mysql_fetch_array($Q);
    $usr['id']   = $r['id'];
    $usr['name'] = $r['name'];
    $usr['pass'] = $r['pass'];
    $usr['fio'] = $r['fio'];
    $usr['country'] = $r['country'];
    $usr['postcode'] = $r['postcode'];
    $usr['city'] = $r['city'];
    $usr['address'] = $r['address'];
    $usr['phone'] = $r['phone'];
    $usr['http'] = $r['http'];
    $usr['notes'] = $r['notes'];
    $usr['activation'] = $r['activation'];
    $usr['status'] = $r['status'];
    $usr['acces'] = $r['acces'];
    return $usr;
  }
}

function _adduser_database($user, $pass, $fio, $country, $postcode, $city, $address, $phone, $http, $notes, $activation, $acces)
{
  $Q = mysql_query("INSERT INTO cusers (name,pass,fio,country,postcode,city,address,phone,http,notes,activation,acces) VALUES ('$user','$pass','$fio','$country','$postcode','$city','$address','$phone','$http','$notes','$activation','$acces')");
//echo "Q: ".$Q."<br>"; 
}

function _saveuser_database($user, $fio, $country, $postcode, $city, $address, $phone, $http, $status, $access, $notes)
{
  $Q = mysql_query("UPDATE cusers SET fio='$fio',country='$country',postcode='$postcode',city='$city',address='$address',phone='$phone',http='$http',status='$status',acces='$access',notes='$notes' WHERE name='$user'");
}

function _savepass_database($user, $passnew)
{
  $Q = mysql_query("UPDATE cusers SET pass='$passnew' WHERE name='$user'");
}

function _saveact_database($user, $code)
{
  $Q = mysql_query("UPDATE cusers SET activation='$code' WHERE name='$user'");
}

function _savetwo_database($user, $two_num, $two_time)
{
  $Q = mysql_query("UPDATE cusers SET two_factor_code='$two_num',two_factor_expires_at='$two_time' WHERE name='$user'");
//echo "Q: ".$Q."<br>"; 
}

function _check_auth($cookie)
{
  session_start();
  $user = array();
  $session = $cookie['SESSION'];
  $q = mysql_query(" SELECT id,name FROM csessions WHERE session = '".$session."' ") or die(mysql_error());
  if(mysql_num_rows($q) == 0)
    header("Location: index.php");
  else {
    $r = mysql_fetch_array($q);
    $user['id']   = $r['id'];
    $user['name'] = $r['name'];
    if(empty($user['name'])) header("Location: index.php");
  }
  return $user;
}

function _check_user($cookie)
{
  session_start();
  $user = array();
  $session = $cookie['SESSION'];
  $q = mysql_query(" SELECT id,name FROM csessions WHERE session = '".$session."' ") or die(mysql_error());
  if(mysql_num_rows($q) != 0) {
    $r = mysql_fetch_array($q);
    $user['id']   = $r['id'];
    $user['name'] = $r['name'];
    if(empty($user['name'])) header("Location: index.php");
  }
  return $user;
}

function _set_cookie($user_data, $rem, $session, $username)
{
  if($rem == 1) setcookie('SESSION', $session, time() + 186400);
  else setcookie('SESSION', $session);

  $user_id = $user_data['id'];
  $C = mysql_query(" SELECT * FROM csessions WHERE id = '$user_id' AND name = '$username' ");
  if(mysql_num_rows($C) == 0)
    $Q = mysql_query(" INSERT INTO csessions (session, id, name) VALUES ('$session','$user_id','$username') ");
  else
    $Q = mysql_query(" UPDATE csessions SET session = '$session' WHERE id = '$user_id' AND name = '$username' ");

  redirect("index.php");
}

function _logout_user($cookie)
{
  $session = $cookie['SESSION'];
  $q = mysql_query(" DELETE FROM csessions WHERE session = '$session' ") or die(mysql_error());
  setcookie('SESSION', '', 0);

  header("location: index.php");
}

function _already_logged($cookie)
{
  if(isset($cookie['SESSION']))
    header("location: index.php");
}

function fm($String)
{
  return addslashes(strip_tags($String));
}

function redirect($url)
{
  echo "<script type='text/javascript'>window.location.href = '".$url."';</script>";
  ob_start();
  header("location:$url");
  ob_end_flush();

  die('Header did not work!');
  exit;
}

?>