<?php

if(empty($_POST['username']) || empty($_POST['password'])){
  //echo "No access=".$_POST['username'].":".$_POST['password']."<br>";
  exit;
}

include_once("../ccfg.php");
include_once("../chtmls.php");
include_once("../cvars.php");
include_once("../cdatabases.php");

$user_data = _check_database($_POST['username'], $_POST['password']);
if($user_data == 0) {
  exit;
}

  global $fldINX;
  global $fldID;

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

  if(count((array)$persons) == 0){
	include_once("../cimport.php");
  }

  if($_POST['id'] == 0){
    $personnew = $persons[count($persons) - 1];
    $new_inx = $personnew[$fldINX] + 1;
    $new_id = $personnew[$fldID] + 1;

    $inx_person = $new_inx;
    $id_person = $new_id;
  } else {
    $inx_person = $_POST['inx'];
    $id_person = $_POST['id'];
  }

/* create json */
  $jsonPerson = new stdClass(); 
  $jsonPerson->id = intval($id_person);
  $jsonPerson->person = $_POST['persona'];
  $jsonPerson->gender = $_POST['genders'];
  $jsonPerson->birthday->date = $_POST['birth'];
  $jsonPerson->birthday->place = $_POST['placeb'];
  $jsonPerson->birthday->maps = $_POST['mapsb'];
  $jsonPerson->deathday->date = $_POST['death'];
  $jsonPerson->deathday->place = $_POST['placed'];
  $jsonPerson->deathday->maps = $_POST['mapsd'];
  $jsonPerson->burialday->date = $_POST['burial'];
  $jsonPerson->burialday->place = $_POST['placet'];
  $jsonPerson->burialday->maps = $_POST['mapst'];
/***/
  if(!empty($_POST['fathers'])) {
    $fts = explode(",", $_POST['fathers']);
    $fats = array();
    for ($i = 0; $i < count($fts); $i++) {
      $fats[$i] = array("id" => $fts[$i]);
    }
    if(count($fats) > 0) $jsonPerson->fathers = $fats;
  }
  if(!empty($_POST['mothers'])) {
    $mts = explode(",", $_POST['mothers']);
    $mots = array();
    for ($i = 0; $i < count($mts); $i++) {
      $mots[$i] = array("id" => $mts[$i]);
    }
    if(count($mots) > 0) $jsonPerson->mothers = $mots;
  }
  if(!empty($_POST['spouses'])) {
    $sps = explode(",", $_POST['spouses']);
    $spsw = explode(",", $_POST['wedding']);
    $spsp = explode(",", $_POST['placew']);
    $spsm = explode(",", $_POST['mapsw']);
    $spss = array();
    for ($i = 0; $i < count($sps); $i++) {
      $spss[$i] = array("id" => $sps[$i], "wedding" => $spsw[$i], "place" => $spsp[$i], "maps" => $spsm[$i]);//add wedding palase map
    }
    if(count($spss) > 0) $jsonPerson->spouses = $spss;
  }
  if(!empty($_POST['placel'])) {
    $rpsb = explode(",", $_POST['datel']);
    $rpsp = explode(",", $_POST['placel']);
    $rpsm = explode(",", $_POST['mapsl']);
    $rpss = array();
    for ($i = 0; $i < count($rpsb); $i++) {
      $rpss[$i] = array("date" => $rpsb[$i], "place" => $rpsp[$i], "maps" => $rpsm[$i]);//add date palase map
    }
    if(count($rpss) > 0) $jsonPerson->residences = $rpss;
  }
/***/
  $jsonPerson->occupation = $_POST['occu'];
  $jsonPerson->national = $_POST['nati'];
  $jsonPerson->education = $_POST['educ'];
  $jsonPerson->religion = $_POST['reli'];
  $jsonPerson->notes = $_POST['notes'];
  $icon = str_replace(" ", "+", $_POST['icon']);
  $jsonPerson->icon = $icon;
  
  $timestamp = date('YmdHisu');
  $jsonPerson->stamp->timestamp = $timestamp;
  $jsonPerson->stamp->avtor = $avtora;
  $jsonPerson->stamp->datetime = $datetimea;
  $jsonPerson->stamp->avtorup = $avtorupa;
  $jsonPerson->stamp->datetimeup = $datetimeupa;

  $jsonPersonvar = json_encode($jsonPerson);
 
  // Generate json file
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"

  $p = __DIR__;
  $mainPath = substr($p,0,strlen($p)-4);

  $file = "$mainPath/cards/$number.card";
  file_put_contents($file, $jsonPersonvar);

////////////////////////////////////////////////////////////
  file_put_contents("../timestamp", $timestamp);
////////////////////////////////////////////////////////////

//echo " PERSONA=".$_POST['persona'].$_POST['fathers'].$_POST['mothers'].$_POST['spouses'];

?>