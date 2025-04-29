<?php

if (version_compare(PHP_VERSION, '7.0.0','>=')) include 'mysql.php';
include_once("ccfg.php");
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
//echo "check_database: ".$user.":".$pass."<br>"; 
// register.php
GLOBAL $pepper;// = getConfigVariable("pepper");
//echo "pepper: ".$pepper."<br>"; 
$pwd_peppered = hash_hmac("sha256", $pass, $pepper);
$pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT); //$pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
//echo "pwd_peppered: ".$pwd_peppered." password_hash: ".$pwd_hashed."<br>"; 
//add_user_to_database($username, $pwd_hashed);

  $Q = mysql_query(" SELECT id FROM users WHERE name = '$user' AND pass = '$pwd_peppered' ");
  if(mysql_num_rows($Q) == 0) return 0;
  else return mysql_fetch_array($Q);
}

function _check_datausers()
{
  $query = "SELECT id,name,pass,fio,country,postcode,city,address,phone,http,notes FROM users";
  $result = mysql_query($query);
  return $result;
}

function _check_datauser($user)
{
  $Q = mysql_query(" SELECT id,name,pass,fio,country,postcode,city,address,phone,http,notes FROM users WHERE name = '$user' ");
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
    return $usr;
  }
}

function _check_useract($user)
{
  $Q = mysql_query(" SELECT id,activation,status,two_factor_code,two_factor_expires_at FROM users WHERE name = '$user' ");
  if(mysql_num_rows($Q) == 0) return 0;
  else {
    $usr = array();
    $r = mysql_fetch_array($Q);
    $usr['id']   = $r['id'];
    $usr['activation'] = $r['activation'];
    $usr['status'] = $r['status'];
    $usr['two_factor_code'] = $r['two_factor_code'];
    $usr['two_factor_expires_at'] = $r['two_factor_expires_at'];
    return $usr;
  }
}

function _adduser_database($user, $pass, $fio, $country, $postcode, $city, $address, $phone, $http, $notes, $activation)
{
// register.php
GLOBAL $pepper;// = getConfigVariable("pepper");
//echo "pepper: ".$pepper."<br>"; 
$pwd_peppered = hash_hmac("sha256", $pass, $pepper);
$pwd_hashed = password_hash($pwd_peppered, PASSWORD_DEFAULT); //$pwd_hashed = password_hash($pwd_peppered, PASSWORD_ARGON2ID);
//echo "pwd_peppered: ".$pwd_peppered." password_hash: ".$pwd_hashed."<br>"; 
//add_user_to_database($username, $pwd_hashed);

//echo $user.$pwd_peppered.$fio.$country.$postcode.$city.$address.$phone.$http.$notes.$activation."<br>"; 
  $Q = mysql_query("INSERT INTO users (name,pass,pwd,fio,country,postcode,city,address,phone,http,notes,activation) VALUES ('$user','$pwd_peppered','$pass','$fio','$country','$postcode','$city','$address','$phone','$http','$notes','$activation')");
//echo "Q: ".$Q."<br>"; 
}

function _saveuser_database($user, $fio, $country, $postcode, $city, $address, $phone, $http, $notes)
{
  $Q = mysql_query("UPDATE users SET fio='$fio',country='$country',postcode='$postcode',city='$city',address='$address',phone='$phone',http='$http',notes='$notes' WHERE name='$user'");
}

function _savepass_database($user, $passnew)
{
  $Q = mysql_query("UPDATE users SET pass='$passnew' WHERE name='$user'");
}

function _saveact_database($user, $code)
{
  $Q = mysql_query("UPDATE users SET activation='$code' WHERE name='$user'");
}

function _savetwo_database($user, $two_num, $two_time)
{
  $Q = mysql_query("UPDATE users SET two_factor_code='$two_num',two_factor_expires_at='$two_time' WHERE name='$user'");
//echo "Q: ".$Q."<br>"; 
}

function _check_auth($cookie)
{
  session_start();
  $user = array();
  $session = $cookie['SESSION'];
  $q = mysql_query(" SELECT id,name FROM sessions WHERE session = '".$session."' ") or die(mysql_error());
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
  $q = mysql_query(" SELECT id,name FROM sessions WHERE session = '".$session."' ") or die(mysql_error());
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
  $C = mysql_query(" SELECT * FROM sessions WHERE id = '$user_id' AND name = '$username' ");
  if(mysql_num_rows($C) == 0)
    $Q = mysql_query(" INSERT INTO sessions (session, id, name) VALUES ('$session','$user_id','$username') ");
  else
    $Q = mysql_query(" UPDATE sessions SET session = '$session' WHERE id = '$user_id' AND name = '$username' ");

  header("location: index.php");
}

function _logout_user($cookie)
{
  $session = $cookie['SESSION'];
  $q = mysql_query(" DELETE FROM sessions WHERE session = '$session' ") or die(mysql_error());
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

?>