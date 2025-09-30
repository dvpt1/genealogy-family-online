<?php

if(empty($_POST['username']) || empty($_POST['password'])){
  //echo "No access=".$_POST['username'].":".$_POST['password']."<br>";
  exit;
}

include_once("ccfg.php");
include_once("csub.php");

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

  if($_POST['id'] == 0){
    $personnew = $persons[count($persons) - 1];
    $new_inx = $personnew[$fldINX] + 1;
    $new_id = $personnew[$fldID] + 1;

    $inx_person = $new_inx;
    $id_person = $new_id;
  } else {
    $inx_person = $_POST['inx'];;
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
  $jsonPerson->lifeday->date = $_POST['live'];
  $jsonPerson->lifeday->place = $_POST['placel'];
  $jsonPerson->lifeday->maps = $_POST['mapsl'];
  $jsonPerson->burialday->date = $_POST['burial'];
  $jsonPerson->burialday->place = $_POST['placet'];
  $jsonPerson->burialday->maps = $_POST['mapst'];
/***/

//echo "<hr>father ==".$_POST['fathers'];
  if(!empty($_POST['fathers'])) {
    $fts = explode(",", $_POST['fathers']);
    $fats = array();
    for ($i = 0; $i < count($fts); $i++) {
      $fats[$i] = array("id" => $fts[$i]);
    }
//print_r($fats);
    if(count($fats) > 0) $jsonPerson->fathers = $fats;
  }

//echo "<hr>mother ==".$_POST['mothers'];
  if(!empty($_POST['mothers'])) {
    $mts = explode(",", $_POST['mothers']);
    $mots = array();
    for ($i = 0; $i < count($mts); $i++) {
      $mots[$i] = array("id" => $mts[$i]);
    }
//print_r($mots);
    if(count($mots) > 0) $jsonPerson->mothers = $mots;
  }

  
/***/
  $jsonPerson->occupation = $_POST['occu'];
  $jsonPerson->national = $_POST['nati'];
  $jsonPerson->education = $_POST['educ'];
  $jsonPerson->religion = $_POST['reli'];
  $jsonPerson->notes = $_POST['notes'];
  $jsonPerson->icon = $_POST['icon'];
  
  $timestamp = date('YmdHisu');
  $jsonPerson->stamp->timestamp = $timestamp;
  $jsonPerson->stamp->avtor = $avtora;
  $jsonPerson->stamp->datetime = $datetimea;
  $jsonPerson->stamp->avtorup = $avtorupa;
  $jsonPerson->stamp->datetimeup = $datetimeupa;

  $jsonPersonvar = json_encode($jsonPerson);
 
  // Generate json file
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"
  $file = __DIR__ ."/cards/$number.card";
  file_put_contents($file, $jsonPersonvar);
//echo $number.":".$file;

////////////////////////////////////////////////////////////
  //$timestamp = date('YmdHisu');
  file_put_contents("timestamp", $timestamp);
////////////////////////////////////////////////////////////

echo $_POST['persona']."<br>";

?>