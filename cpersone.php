<?php

include_once("chtmls.php");
include_once("cvars.php");

//$user = _check_auth($_COOKIE);
$user = array();
$user['id'] = 1;
$userId = $user['id'];

Persone($user);

//рисует иконку, рамку, имя и дату
function Persone($user)
{
  global $timestamp;

  global $userId;

  $msg = $GLOBALS["msg"];
  if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";

  global $edtt, $lgnmail, $pwdold, $pwdnew1, $pwdnew2, $pwdizm, $fio, $country, $post, $city, $adres, $phone, $www, $note, $registr, $save, $delete, $questdel; 
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

  global $lang;

  global $fldINX;
  global $fldID;

  global $fldBEG;
  global $fldEND;
  global $fldPER;
  global $fldFAT;
  global $fldMOT;
  global $fldSEX;
  global $fldPLB;
  global $fldPLD;
  global $fldPLL;
  global $fldPLT;
  global $fldMAPB;
  global $fldMAPD;
  global $fldMAPL;
  global $fldMAPT;
  global $fldOCCU;
  global $fldNATI;
  global $fldEDUC;
  global $fldRELI;
  global $fldNOTE;
  global $fldICON;
  global $fldCHAN;

  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $fldSPOUS1;
  global $fldSPOUS2;
  global $fldWEDDIN;
  global $fldPLACEW;
  global $fldMAPSW;

  global $field_name;
  global $field_gender;
  global $field_father;
  global $field_mother;
  global $field_birth;
  global $field_death;
  global $field_placeb;
  global $field_placed;
  global $field_placet;
  global $field_foto;
  global $field_note;
  global $field_child;
  global $field_son;
  global $field_daughter;
  global $field_brother;
  global $field_sister;
  global $field_spouse;
  global $field_husband;
  global $field_wife;
  global $field_wedding;
  global $field_placew;
  global $field_placel;
  global $field_occu;
  global $field_nati;
  global $field_educ;
  global $field_reli;
  global $field_call;
  global $field_email;

  global $gender_neutral;
  global $gender_male;
  global $gender_female;

  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;

  global $cnt_persons;
  global $inx_person;
  global $id_person;
  global $person;
  global $gedcom;

//  $father_key = "";
//  $mother_key = "";
//  $spouse_key = "";

  $src_icon = "";
  $src_image = "";
  $inx_person = $_GET['inx'];
  $person = $persons[$inx_person];
  $id_person = intval($person[$fldID]);

  $weddinga = "";
  $placewa = "";
  $mapswa = "";

  session_start();

  $person_inx = $_SESSION["personinx"];
  if($inx_person != $person_inx){
    $_SESSION['icona'] = "";
    //unset($_SESSION['icona']);
    $_SESSION['fathera'] = "";
    $_SESSION['mothera'] = "";
    $_SESSION['spousea'] = "";
  }
  $_SESSION["personinx"] = $inx_person;

  //echo "<br><br><br><br>";
  //print_r($_COOKIE);
  //echo "_COOKIE<br>";
  //print_r($fathers);
  //echo "_fathers<br>";
  //print_r($mothers);
  //echo "_mothers<br>";

if(isset($_POST['saveperson'])) {

  if($_GET['inx'] == -1){
    $personnew = $persons[count($persons) - 1];
    $new_inx = $personnew[$fldINX] + 1;
    $new_id = $personnew[$fldID] + 1;

    $inx_person = $new_inx;
    $id_person = $new_id;
    $persons[$inx_person][$fldINX] = $new_inx;
    $persons[$inx_person][$fldID] = $new_id;
  }

//echo "<br><br><br><br>";
//echo "==spouse_key=[".$_SESSION["spousea"]."]===<br>";
//echo "==father_key=[".$_SESSION["fathera"]."]===<br>";
//echo "==mother_key=[".$_SESSION["mothera"]."]===<br>";
//echo "==spouse_key=[".$_POST["spousea"]."]===<br>";
//echo "==father_key=[".$_POST["fathera"]."]===<br>";
//echo "==mother_key=[".$_POST["mothera"]."]===<br>";
//echo "<br><br><br><br>".$inx_person.":".$user['name'].";inx=".$persons[$inx_person][$fldINX].":".$_POST['persona'].":".$_POST['genders'].":".$_POST['fathera'].":".$_POST['mothera']."<br>";

  $persons[$inx_person][$fldBEG ] = $_POST['birth'];
  $persons[$inx_person][$fldEND ] = $_POST['death'];
  $persons[$inx_person][$fldPER ] = $_POST['persona'];
  $persons[$inx_person][$fldFAT ] = $_POST['father'];
  $persons[$inx_person][$fldMOT ] = $_POST['mother'];
  $persons[$inx_person][$fldSEX ] = $_POST['genders'];
  $persons[$inx_person][$fldPLB ] = $_POST['placeb'];
  $persons[$inx_person][$fldPLL ] = $_POST['placel'];
  $persons[$inx_person][$fldPLD ] = $_POST['placed'];
  $persons[$inx_person][$fldPLT ] = $_POST['placet'];
//  $persons[$inx_person][$fldMAPB] = $_POST['mapsb'];
//  $persons[$inx_person][$fldMAPD] = $_POST['mapsd'];
//  $persons[$inx_person][$fldMAPL] = $_POST['mapsl'];
//  $persons[$inx_person][$fldMAPT] = $_POST['mapst'];
  $persons[$inx_person][$fldOCCU] = $_POST['occu'];
  $persons[$inx_person][$fldNATI] = $_POST['nati'];
  $persons[$inx_person][$fldEDUC] = $_POST['educ'];
  $persons[$inx_person][$fldRELI] = $_POST['reli'];
  $persons[$inx_person][$fldNOTE] = $_POST['notes'];
  $persons[$inx_person][$fldICON] = $_POST['icon'];

//echo "src_image1<br>";
/*  if(isset($_SESSION["icona"])){
    if(empty($_SESSION["icona"])) $src_icon = $person[$fldICON]; else $src_icon = $_SESSION["icona"];
    $persons[$inx_person][$fldICON] = $src_icon;
  }else{
    $persons[$inx_person][$fldICON] = "";
    $_SESSION["icona"] = "";
  }*/

  // fathers
  $fat1 = array(); // fathers from form
  if(isset($_SESSION["fathera"])) $father_key = $_SESSION["fathera"];
  if(strlen("$father_key") == 0) $father_key = $_POST['fathera'];
//echo 'father_key='.$father_key.'<br>';
  if($father_key != ""){
    $faths = explode(",", $father_key);
    for ($i = 0; $i < count($faths); $i++) {
      $fat1[] = $faths[$i];
    }
  }
  $fat2 = array(); // fathers from base
  for ($i = 0; $i < count($fathers); $i++) {
    if ($fathers[$i][0] == $inx_person) {
       $ii = $fathers[$i][1];
       $fat2[] = $ii;
//echo 'father_key2='.$ii.'<br>';
    }
  }
  for ($i = 0; $i < count($fat1); $i++) { // father add
     $b = false;
     for ($j = 0; $j < count($fat2); $j++) {
       if(strlen($fat2[$j]) > 0 && $fat1[$i] == $fat2[$j]) {
         $b = true;
         break;
       }
     }
     if(!$b){
//echo '<b>fatherAdd='.$inx_person.';'.$fat1[$i].'</b><br>';
       $fathers[] = array($inx_person, $fat1[$i]);
     }
  }
  for ($i = 0; $i < count($fat2); $i++) { // father del
     $b = true;
     for ($j = 0; $j < count($fat1); $j++) {
       if(strlen($fat1[$j]) > 0 && $fat1[$j] == $fat2[$i]) {
         $b = false;
         break;
       }
     }
     if($b){
       for ($j = 0; $j < count($fathers); $j++) {
         if($fathers[$j][0] == $inx_person && $fathers[$j][1] == $fat2[$i]) {
//echo '<b>fatherDel='.$fathers[$j][0].';'.$inx_person.';;'.$fathers[$j][1].';'.$fat2[$i].'</b><br>';
           unset($fathers[$j]);
           break;
         }
       }
     }
  }

  // mothers
  $mot1 = array(); // mothers from form
  if(isset($_SESSION["mothera"])) $mother_key = $_SESSION["mothera"];
  if(strlen("$mother_key") == 0) $mother_key = $_POST['mothera'];
//echo 'mother_key='.$mother_key.'<br>';
  if($mother_key != ""){
    $moths = explode(",", $mother_key);
    for ($i = 0; $i < count($moths); $i++) {
      $mot1[] = $moths[$i];
    }
  }
  $mot2 = array(); // mothers from base
  for ($i = 0; $i < count($mothers); $i++) {
    if ($mothers[$i][0] == $inx_person) {
       $ii = $mothers[$i][1];
       $mot2[] = $ii;
    }
  }
  for ($i = 0; $i < count($mot1); $i++) { // mother add
     $b = false;
     for ($j = 0; $j < count($mot2); $j++) {
       if($mot2[$j] > 0 && $mot1[$i] == $mot2[$j]) {
         $b = true;
         break;
       }
     }
     if(!$b){
//echo '<b>motherAdd='.$inx_person.';'.$mot1[$i].'</b><br>';
       $mothers[] = array($inx_person, $mot1[$i]);
     }
  }
  for ($i = 0; $i < count($mot2); $i++) { // mother del
     $b = true;
     for ($j = 0; $j < count($mot1); $j++) {
       if(strlen($mot1[$j]) > 0 && $mot1[$j] == $mot2[$i]) {
         $b = false;
         break;
       }
     }
     if($b){
       for ($j = 0; $j < count($mothers); $j++) {
         if($mothers[$j][0] == $inx_person && $mothers[$j][1] == $mot2[$i]) {
//echo '<b>motherDel='.$mothers[$j][0].';'.$inx_person.';;'.$mothers[$j][1].';'.$mot2[$i].'</b><br>';
           unset($mothers[$j]);
           break;
         }
       }
     }
  }

  // spouse
  if(!empty($_POST["spouse"])){
    $inxs = $_POST["spouse"];
    $sps = explode(":", $inxs);
    $spouse_ind = $sps[0];
    $spouse_inx = $sps[1];
  }else{
    $spouse_ind = -1;
    $spouse_inx = -1;
  }
  $sps1 = array();
  if(isset($_SESSION["spousea"])) $spouse_key = $_SESSION["spousea"];
  if(strlen("$spouse_key") == 0) $spouse_key = $_POST['spousea'];
//echo 'spouse_key='.$spouse_key.'<br>';
  if($spouse_key != ""){
    $spths = explode(",", $spouse_key);
    for ($i = 0; $i < count($spths); $i++) {
      $spts = explode(":", $spths[$i]);
      $sps1[] = $spts[1];
//echo 'spouse_key1='.$spts[1].'<br>';
    }
  }
  $sps2 = array();
  for ($i = 0; $i < count($spouses); $i++) {
    if ($spouses[$i][$fldSPOUS1] == $id_person) {
       $ii = $spouses[$i][$fldSPOUS2];
       $sps2[] = $ii;
//echo 'spouse_key21='.$ii.'<br>';
    }else
    if ($spouses[$i][$fldSPOUS2] == $id_person) {
       $ii = $spouses[$i][$fldSPOUS1];
       $sps2[] = $ii;
//echo 'spouse_key22='.$ii.'<br>';
    }
  }
  for ($i = 0; $i < count($sps1); $i++) { // spouse add
     $b = false;
     for ($j = 0; $j < count($sps2); $j++) {
       if($sps2[$j] > 0 && $sps1[$i] == $sps2[$j]) {
         $b = true;
         break;
       }
     }
     if(!$b){ // add
//echo '<b>spouseAdd='.$inx_person.';'.$sps1[$i].'</b><br>';
       $spouses[] = array(count($spouses), $inx_person, $sps1[$i],$_POST['wedding'],$_POST['placew']);
     } else { // edit
       if($spouse_ind == $sps1[$i]){
//echo '<b>spouseEdit='.$inx_person.';'.$sps1[$i].'</b><br>';
         $spouses[$sps1[$i]][$fldWEDDIN] = $_POST['wedding'];
         $spouses[$sps1[$i]][$fldPLACEW] = $_POST['placew'];
       }
     }
  }
  for ($i = 0; $i < count($sps2); $i++) { // spouse del
     $b = true;
     for ($j = 0; $j < count($sps1); $j++) {
       if(strlen($sps1[$j]) > 0 && $sps1[$j] == $sps2[$i]) {
         $b = false;
         break;
       }
     }
     if($b){
//echo '<b>spouseDel0='.$inx_person.';'.$sps2[$i].'</b><br>';
       for ($j = 0; $j < count($spouses); $j++) {
         if($spouses[$j][$fldSPOUS1] == $id_person && $spouses[$j][$fldSPOUS2] == $sps2[$i]) {
//echo '<b>spouseDel1='.$spouses[$j][$fldSPOUS1].';'.$inx_person.';;'.$spouses[$j][$fldSPOUS2].';'.$sps2[$i].'</b><br>';
           unset($spouses[$j]);
           break;
         }else
         if($spouses[$j][$fldSPOUS2] == $id_person && $spouses[$j][$fldSPOUS1] == $sps2[$i]) {
//echo '<b>spouseDel2='.$spouses[$j][$fldSPOUS1].';'.$inx_person.';;'.$spouses[$j][$fldSPOUS2].';'.$sps2[$i].'</b><br>';
           unset($spouses[$j]);
           break;
         }
       }
     }
  }
  
  ///////////////////////////////////////////////////////////////////// save
  //$gedcom = Gedcom_Export();
  
  $jsonPerson = new stdClass(); 
  $jsonPerson->id = intval($id_person);
  $jsonPerson->gender = $_POST['genders'];
  $jsonPerson->person = $_POST['persona'];
  $jsonPerson->birthday->date = $_POST['birth'];
  $jsonPerson->birthday->place = $_POST['placeb'];
  $jsonPerson->deathday->date = $_POST['death'];
  $jsonPerson->deathday->place = $_POST['placed'];
  $jsonPerson->placel = $_POST['placel'];
  $jsonPerson->placet = $_POST['placet'];
  
// echo "<hr>father =$fat1=";
  if(!empty($fat1)) {
    $idf = -1;
    $fats = array();
    for ($i = 0; $i < count($fat1); $i++) {
      $idf = intval($persons[$fat1[$i]][$fldID]);
      $fats[$i] = array("id" => $idf);
    }
    if(count($fat1) > 0) $jsonPerson->fathers = $fats;
//print_r($fat1); echo count($idf).":".empty($fat1)."<br>";
  }

//  echo "<hr>mother =$mot1=";
  if(!empty($mot1)) {
    $idm = -1;
    $mots = array();
    for ($i = 0; $i < count($mot1); $i++) {
      $idm = intval($persons[$mot1[$i]][$fldID]);
      $mots[$i] = array("id" => $idm);
    }
    if(count($idm) > -1) $jsonPerson->mothers = $mots;
//print_r($fat1); echo count($idf).":".empty($fat1)."<br>";
  }

//  echo "<hr>spouse =$sps1=";print_r($sps1);
  if(!empty($sps1)) {
    $ids = -1;
    $spss = array();
    for ($i = 0; $i < count($sps1); $i++) {
      $ids = intval($persons[$sps1[$i]][$fldID]);
      $spss[$i] = array("id" => $ids);//add wedding palase map
    }
    if(count($ids) > -1) $jsonPerson->spouses = $spss;
//print_r($spss); echo count($ids)."<br>";
  }
//echo "<hr>";


  $jsonPerson->occupation = $_POST['occu'];
  $jsonPerson->national = $_POST['nati'];
  $jsonPerson->education = $_POST['educ'];
  $jsonPerson->relogion = $_POST['reli'];
  $jsonPerson->notes = $_POST['notes'];
  $jsonPerson->icon = $_POST['icon'];
  
  $timestamp = date('YmdHisu');
  $jsonPerson->stamp->timestamp = $timestamp;
  $jsonPerson->stamp->datetime = date('Y-m-d H:i:s.u');
  $jsonPerson->stamp->user = $userId;
  $jsonPerson->stamp->avtor = $userId;

  $jsonPersonvar = json_encode($jsonPerson);
 
  // Generate json file
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"

  //echo $number.":".$jsonPersonvar;
  file_put_contents("$number.card", $jsonPersonvar);

////////////////////////////////////////////////////////////
  //$timestamp = date('YmdHisu');
  file_put_contents("timestamp", $timestamp);
////////////////////////////////////////////////////////////

  echo '<script type="text/javascript">window.location = "https://dnadata.online/"</script>';

}else
if(isset($_POST['deleteperson'])) {

  // delete persone
  unset($persons[$inx_person]);
  ///////////////////////////////////////////////////// delete
  $number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"
  $file = __DIR__ ."/$number.card";
//echo $number.":".$file;
  unlink($file);

////////////////////////////////////////////////////////////
  $timestamp = date('YmdHisu');
  file_put_contents("timestamp", $timestamp);
////////////////////////////////////////////////////////////

  echo '<script type="text/javascript">window.location = "https://dnadata.online/"</script>';

}

////////////////////////////////////////////////////////////////////////////
  $inx_add = 0;
  if(isset($_POST['addFather'])) $inx_add = 1;
  if(isset($_POST['addMother'])) $inx_add = 2;
  if(isset($_POST['addSpouse'])) $inx_add = 3;
  $inx_del = 0;
  if(isset($_POST['delFather'])) $inx_del = 1;
  if(isset($_POST['delMother'])) $inx_del = 2;
  if(isset($_POST['delSpouse'])) $inx_del = 3;

  $_SESSION["birtha"]  = $_POST["birth"];
  $_SESSION["deatha"]  = $_POST["death"];
  $_SESSION["persona"] = $_POST["persona"];
  $_SESSION["gendera"] = $_POST["genders"];
  $_SESSION["placeb"] = $_POST["placeb"];
  $_SESSION["placed"] = $_POST["placed"];
  $_SESSION["placel"] = $_POST["placel"];
  $_SESSION["placet"] = $_POST["placet"];
  $_SESSION["occua"] = $_POST["occu"];
  $_SESSION["natia"] = $_POST["nati"];
  $_SESSION["educa"] = $_POST["educ"];
  $_SESSION["relia"] = $_POST["reli"];
  $_SESSION["notesa"] = $_POST["notes"];
  $_SESSION["icona"] = $_POST["icon"];

  if(@$_POST['selGender']) { // Если нажата кнопка
      $gendera = $_POST['genders'];
  }

  $addfather = "";
  $inxfather = -1;
  if(@$_POST['selFather']) { // Если нажата кнопка
      $inxfather = $_POST['father_sel'];
      $addfather = $persons[$inxfather][$fldPER];
  }

  $addmother = "";
  $inxmother = -1;
  if(@$_POST['selMother']) { // Если нажата кнопка
      $inxmother = $_POST['mother_sel'];
      $addmother = $persons[$inxmother][$fldPER];
  }

  $addspouse = "";
  $inxspouse = -1;
  if(@$_POST['selSpouse']) { // Если нажата кнопка
      $inxspouse = $_POST['spouse_sel'];
      $addspouse = $persons[$inxspouse][$fldPER];
  }

  $delfather = -1;
  $delmother = -1;
  $delspouse = -1;
  if(isset($_POST['delFather'])) if(isset($_POST['father'])) $delfather = $_POST['father'];
  if(isset($_POST['delMother'])) if(isset($_POST['mother'])) $delmother = $_POST['mother'];
  if(isset($_POST['delSpouse'])) if(isset($_POST['spouse'])){
     $delsp = explode(":", $_POST['spouse']);
     $delspouse = $delsp[1];
  }

  $father_key = "";
  if(strlen($_SESSION["fathera"]) > 0) $father_key = $_POST["fathera"]; else $father_key = $_SESSION["fathera"];
  if(strlen("$father_key") > 0){
   $n = 0;
   for ($i = 0; $i < count($fathers); $i++) {
     if ($fathers[$i][0] == $inx_person) {
       $ii = $fathers[$i][1];

       if($n == 0) $father_key = "".$ii; else $father_key .= ",".$ii;
       $n++;
     }
   }
  }

  $mother_key = "";
  if(strlen($_SESSION["mothera"]) > 0) $mother_key = $_POST["mothera"]; else $mother_key = $_SESSION["mothera"];
  if(strlen("$mother_key") > 0){
   $n = 0;
   for ($i = 0; $i < count($mothers); $i++) {
     if ($mothers[$i][0] == $inx_person) {
       $ii = $mothers[$i][1];

       if($n == 0) $mother_key = "".$ii; else $mother_key .= ",".$ii;
       $n++;
     }
   }
  }

  $spouse_key = "";
  if(strlen($_SESSION["spousea"]) > 0) $spouse_key = $_POST["spousea"]; else $spouse_key = $_SESSION["spousea"];
  if(strlen("$spouse_key") == 0){
   $n = 0;
   for ($i = 0; $i < count($spouses); $i++) {
     if ($spouses[$i][$fldSPOUS1] == $inx_person) {
       if($n == 0) $spouse_key = "".$spouses[$i][$fldINX].':'.$spouses[$i][$fldSPOUS2]; else $spouse_key .= ",".$spouses[$i][$fldINX].':'.$spouses[$i][$fldSPOUS2];
       $n++;
     }else
     if ($spouses[$i][$fldSPOUS2] == $inx_person) {
       if($n == 0) $spouse_key = "".$spouses[$i][$fldINX].':'.$spouses[$i][$fldSPOUS1]; else $spouse_key .= ",".$spouses[$i][$fldINX].':'.$spouses[$i][$fldSPOUS1];
       $n++;
     }
   }
  }

  if(empty($_SESSION["birtha"])) $birtha = $person[$fldBEG]; else $birtha = $_SESSION["birtha"];
  if(empty($_SESSION["deatha"])) $deatha = $person[$fldEND]; else $deatha = $_SESSION["deatha"];
  if(empty($_SESSION["persona"])) $persona = $person[$fldPER]; else $persona = $_SESSION["persona"];
  if(empty($_SESSION["gendera"])) $gendera = $person[$fldSEX]; else $gendera = $_SESSION["gendera"];
  if(empty($_SESSION["placeba"])) $placeba = $person[$fldPLB]; else $placeba = $_SESSION["placeba"];
  if(empty($_SESSION["placeda"])) $placeda = $person[$fldPLD]; else $placeda = $_SESSION["placeda"];
  if(empty($_SESSION["placela"])) $placela = $person[$fldPLL]; else $placela = $_SESSION["placela"];
  if(empty($_SESSION["placeta"])) $placeta = $person[$fldPLT]; else $placeta = $_SESSION["placeta"];
  if(empty($_SESSION["occua"])) $occua = $person[$fldOCCU]; else $occua = $_SESSION["occua"];
  if(empty($_SESSION["natia"])) $natia = $person[$fldNATI]; else $natia = $_SESSION["natia"];
  if(empty($_SESSION["educa"])) $educa = $person[$fldEDUC]; else $educa = $_SESSION["educa"];
  if(empty($_SESSION["relia"])) $relia = $person[$fldRELI]; else $relia = $_SESSION["relia"];
  if(empty($_SESSION["notesa"])) $notesa = $person[$fldNOTE]; else $notesa = $_SESSION["notesa"];
  if(empty($_SESSION["icona"])) $src_icon = $person[$fldICON]; else $src_icon = $_SESSION["icona"];

  header("Location: ".$_SERVER["HTTP_REFERER"]);


  if(!empty($_POST["spouse"])){
    $inxs = $_POST["spouse"];
    $sps = explode(":", $inxs);
    $spouse_ind = $sps[0];
    $spouse_inx = $sps[1];
  }else{
    $spouse_ind = 0;
    $spouse_inx = 0;
  }

  // spouse
  $aspouse = array();
  $apersone = array();
  $awedding = array();
  $aplasew = array();
  $amapsw = array();

  if(strlen("$spouse_key") > 0){
    $spths = explode(",", $spouse_key);
    for ($i = 0; $i < count($spths); $i++) {
      $spts = explode(":", $spths[$i]);
      $i0 = $spts[0];
      $i1 = $spts[1];
      if($i0 == $inx_person){
        $aspouse[] = $i0;
        $apersone[] = $i1;
        $aweeding[] = $spouses[$i1][$fldWEDDIN];
        $aplacew[] = $spouses[$i1][$fldPLACEW];
        $amapsw[] = spouses[$i1][$fldMAPSW];
      }
    }
  }
  if($inxspouse > -1){
     $aspouse[] = -1;
     $apersone[] = $inxspouse;
     $aweeding[] = "";
     $aplacew[] = "";
     $amapsw[] = "";

     if($n == 0) $spouse_key = '-1:'.$inxspouse; else $spouse_key .= '-1:'.$inxspouse;
  }
  //??$_SESSION["spousea"] = $spouse_key;

  $htm = "<div class='shadow' style='POSITION: absolute; LEFT: 10px; TOP: 60px; WIDTH: 1075px; HEIGHT: 765px'>";
  if ($gendera == "1")
  {
      $htm .= "<div class='blockm' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 1060px; HEIGHT: 750px'>";
  }
  else if ($gendera == "2")
  {
      $htm .= "<div class='blockw' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 1060px; HEIGHT: 750px'>";
  }
  else
  {
      $htm .= "<div class='blockn' style='POSITION: absolute; LEFT: 0px; TOP: 0px; WIDTH: 1060px; HEIGHT: 750px'>";
  }
  echo $htm;

//echo "inx=$inx_person ; id=$id_person ; father_key=$father_key ; mother_key=$mother_key ; spouse_key=$spouse_key<br>";
//echo "keys= ".$spouse_key." = ".$inxspouse." = ".$addspouse."<br>";
//echo $person[$fldPER].':'.$person[$fldFAT].':'.$person[$fldMOT]."<br>";
//echo 'SESSION='. $persona .'='. $gendera."<br>";
//echo "inx_person=".$inx_person." = ".$person_inx."<br>";
//echo "keys= ".$father_key." = ".$mother_key."<br>";


 ?>

 <form name="form1" action="" enctype="multipart/form-data" method="post">
 <input type="file" name="path" title="Фотография" />
 <input type="submit" name="addimage" title="Загрузить" value="+" />
 <input type="submit" name="delimage" title="Удалить" value="-" />
 </form>

<?php

// get details of the uploaded file 
//$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
//$fileName = $_FILES['uploadedFile']['name'];
//$fileSize = $_FILES['uploadedFile']['size'];
//$fileType = $_FILES['uploadedFile']['type'];
//$fileNameCmps = explode(".", $fileName);
//$fileExtension = strtolower(end($fileNameCmps));

  if(isset($_POST['addimage'])) {
    $file = __DIR__ ."/foto/".$_FILES['path']['name'];
    move_uploaded_file($_FILES['path']['tmp_name'], $file);
    if(isset($_FILES['path']['name'])==true)
    {
      $type = pathinfo($file, PATHINFO_EXTENSION);
      $data = file_get_contents($file);
      $base64 = base64_encode($data); // Replace with your Base64 image
      $src_icon = resizeBase64Image($base64, 64, 64);
      $src_image = "data:image/".$type.";base64,".$src_icon;
  
      $_SESSION["icona"] = $src_icon;
    }else{
      if(empty($_SESSION["icona"])) $src_icon = $person[$fldICON]; else $src_icon = $_SESSION["icona"];
      $src_image = "data:image/jpeg;base64,".$src_icon; 
    }
  }else{
      if(empty($_SESSION["icona"])) $src_icon = $person[$fldICON]; else $src_icon = $_SESSION["icona"];
      if(empty($src_icon)) $src_image = ""; else $src_image = "data:image/jpeg;base64,".$src_icon; 
  }

  if(isset($_POST['delimage'])) {
      $src_icon = "";
      $_SESSION["icona"] = $src_icon;
      unset($_SESSION['icona']);
      $src_image = $src_icon; 
  }
?>

 <form name="editperson" action="index.php?do=cpersone&inx=<?php echo $inx_person; ?>&edit=1" method="post">

 <table width="100%" align="left" border="0" cellpadding="2">
 <tr><td width=25%>

<?php
  if(!empty($src_image)){
    echo "<img src=$src_image width=64 height=64 align=left>"; 
  }else{
    $path = '';
    if($gendera=='1') {$path = "icons/Avatar64_Man.png";}
    else if($gendera=='2') {$path = "icons/Avatar64_Woman.png";}
    else {$path = "icons/Avatar64.png";}
    echo "<img src='$path' alt='$name' title='$name' width='64' heigth='64' align=left>";
  }
  echo '<input type="hidden" id="icon" name="icon" value="'.$src_icon.'">';
?>

 </td><td width=75%>
  <label for="genders"><?php echo $field_gender; ?></label>
  <select class="genders" name="genders">
<?php
  //genders
  if ($gendera == "0")  echo '<option value="0" selected>'.$gender_neutral.'</option>';
  else  echo '<option value="0">'.$gender_neutral.'</option>';
  if ($gendera == "1") echo '<option value="1" selected>'.$gender_male.'</option>';
  else echo '<option value="1">'.$gender_male.'</option>';
  if ($gendera == "2") echo '<option value="2" selected>'.$gender_female.'</option>';
  else echo '<option value="2">'.$gender_female.'</option>';
?>
  </select>
  <input type=submit name='selGender' value='-->'>

  </td>
 </tr>

 <tr style="outline: thin solid"><td width=25%><?php echo $field_name; ?></td>
  <td width=75%><input type="text" name="persona" size="60" value="<?php echo $persona; ?>"></td>
 </tr>

 <tr><td><?php echo $field_birth; ?></td>
  <td><input type="text" name="birth" size="25" value="<?php echo $birtha; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placeb; ?></td>
  <td><input type="text" name="placeb" size="60" value="<?php echo $placeba; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placel; ?></td>
  <td><input type="text" name="placel" size="60" value="<?php echo $placela; ?>"></td>
 </tr>

 <tr><td><?php echo $field_death; ?></td>
  <td><input type="text" name="death" size="25" value="<?php echo $deatha; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placed; ?></td>
  <td><input type="text" name="placed" size="60" value="<?php echo $placeda; ?>"></td>
 </tr>

 <tr><td><?php echo $field_placet; ?></td>
  <td><input type="text" name="placet" size="60" value="<?php echo $placeta; ?>"></td>
 </tr>

<?
  //fathers
  echo '<tr><td>'.$field_father.'</td>';
  echo '<td>';
  $spths = explode(",", $father_key);
//  echo "=$inxfather=".count($spths)."=[".$father_key."]===";
  echo '<select id="father" class="father" name="father">';
  $n = 0;
  if(strlen("$father_key") > 0){
   $faths = explode(",", $father_key);
   $father_key = "";
   for ($i = 0; $i < count($faths); $i++) {
     $ii = $faths[$i];
     if(strlen($ii) > 0 && $delfather != $ii){
       echo '<option value="'.$ii.'">'.$persons[$ii][$fldPER].'</option>';

       if($n == 0) $father_key = "".$ii; else $father_key .= ",".$ii;
       $n++;
     }
   }
  }else{
   $father_key = "";
   for ($i = 0; $i < count($fathers); $i++) {
     if ($fathers[$i][0] == $inx_person) {
       $ii = $fathers[$i][1];
       if($delfather != $ii){
         echo '<option value="'.$ii.'">'.$persons[$ii][$fldPER].'</option>';

         if($n == 0) $father_key = "".$ii; else $father_key .= ",".$ii;
         $n++;
       }
     }
   }
  }
  if($inxfather > -1){
       echo '<option value="'.$inxfather.'">'.$addfather.'</option>';

       if($n == 0) $father_key = "".$inxfather; else $father_key .= ",".$inxfather;
  }
  echo '</select>';
  //echo "=$inxfather==[".$father_key."]===";

  $_SESSION["fathera"] = $father_key;
  echo '<input type="hidden" id="fathera" name="fathera" value="'.$father_key.'">';
  echo "<input type=submit src='icons/ic_menu_add.png' witdh=24 height=24 name='addFather' value='+'>";
  echo "<input type=submit src='icons/ic_menu_delete.png' witdh=24 height=24 name='delFather' value='-'>";

  if ($inx_add == 1){
     echo "<select name='father_sel' size='1'>";
     $select="";
     for($i = 0; $i < count($persons); $i++) {
        $per = $persons[$i];
        $select .= "<option value='$per[$fldINX]'>$per[$fldPER]</option>";
     }
     echo $select."<input type=submit name='selFather' value='+'>";
     echo "</select>";
     echo "<input type=submit name='' value='<'>";
  } 
//print_r($fathers);
  echo '</td></tr>';

  // mothers
  echo '<tr><td>'.$field_mother.'</td>';
  echo '<td>';
  $spths = explode(",", $mother_key);
//  echo "=$inxmother=".count($spths)."=[".$mother_key."]===";
  echo '<select id="mother" class="mother" name="mother">';
  $n = 0;
  if(strlen("$mother_key") > 0){
   $moths = explode(",", $mother_key);
   $mother_key = "";
   for ($i = 0; $i < count($moths); $i++) {
     $ii = $moths[$i];
     if(strlen($ii) > 0 && $delmother != $ii){
       echo '<option value="'.$ii.'">'.$persons[$ii][$fldPER].'</option>';

       if($n == 0) $mother_key = "".$ii; else $mother_key .= ",".$ii;
       $n++;
     }
   }
  }else{
   $mother_key = "";
   for ($i = 0; $i < count($mothers); $i++) {
     if ($mothers[$i][0] == $inx_person) {
       $ii = $mothers[$i][1];
       if($delmother != $ii){
         echo '<option value="'.$ii.'">'.$persons[$ii][$fldPER].'</option>';

         if($n == 0) $mother_key = "".$ii; else $mother_key .= ",".$ii;
         $n++;
       }
     }
   }
  }
  if($inxmother > -1){
       echo '<option value="'.$inxmother.'">'.$addmother.'</option>';

       if($n == 0) $mother_key = "".$inxmother; else $mother_key .= ",".$inxmother;
  }
  echo '</select>';
//  echo "=$inxmother==[".$mother_key."]===";

  $_SESSION["mothera"] = $mother_key;
  echo '<input type="hidden" id="mothera" name="mothera" value="'.$mother_key.'">';
  echo "<input type=submit src='icons/ic_menu_add.png' witdh=24 height=24 name='addMother' value='+'>";
  echo "<input type=submit src='icons/ic_menu_delete.png' witdh=24 height=24 name='delMother' value='-'>";

  if ($inx_add == 2){
     echo "<select name='mother_sel' size='1'>";
     $select="";
     for($i = 0; $i < count($persons); $i++) {
        $per = $persons[$i];
        $select .= "<option value='$per[$fldINX]'>".$per[$fldPER]."</option>";
     }
     echo $select."<input type=submit name='selMother' value='+'>";
     echo "</select>";

     echo "<input type=submit name='' value='<'>";
  } 
  echo '</td></tr>';

  // spouses
  echo '<tr bgcolor="#ebdac7"><td>'.$field_spouse.'</td>';
  echo '<td>';
//echo "=".count($aspouse)."==".count($spths)."=[".$spouse_key."]=$delspouse=$apersone[0]=";
  echo '<select id="spouse" class="spouse" name="spouse" onchange="OnSelectionChange (this)">';
  $n = 0;
  $spouse_key = "";
  for ($i = 0; $i < count($aspouse); $i++) {
    if($delspouse != $apersone[$i]){
      echo '<option value="'.$aspouse[$i].':'.$apersone[$i].'">'.$persons[$apersone[$i]][$fldPER].'</option>';

      if($i == $spouse_ind){
        $weddinga = $spouses[$aspouse[$i]][$fldWEDDIN];
        $placewa = $spouses[$aspouse[$i]][$fldPLACEW];
        $mapswa = $spouses[$i][$flMAPSW];
      }

      if($n == 0) $spouse_key = "".$aspouse[$i].':'.$apersone[$i]; else $spouse_key .= ",".$aspouse[$i].':'.$apersone[$i];
      $n++;
    }
  }
  echo '</select>';
//echo "==spouse_key=[".$spouse_key."]===";

  $_SESSION["spousea"] = $spouse_key;
  echo '<input type="hidden" id="spouse_key" name="spousea" value="'.$spouse_key.'">';
  echo "<input type=submit src='icons/ic_menu_add.png' witdh=24 height=24 name='addSpouse' value='+'>";
  echo "<input type=submit src='icons/ic_menu_delete.png' witdh=24 height=24 name='delSpouse' value='-'>";

  if ($inx_add == 3){
     echo "<select name='spouse_sel' size='1'>";
     $select="";
     for($i = 0; $i < count($persons); $i++) {
        $per = $persons[$i];
        $select .= "<option value='$per[$fldINX]'>".$per[$fldPER]."</option>";
     }
     echo $select."<input type=submit name='selSpouse' value='+'>";
     echo "</select>";

     echo "<input type=submit name='' value='<'>";
  }
  echo '</td></tr>';

?>

 <!--<p id="p">selectedIndex: 0</p>-->
 <script>
     function OnSelectionChange (select) {
         const index = select.selectedIndex;
         var selectedOption = select.options[index];
         var options = selectedOption.value;
         var option = options.split(":");
         document.cookie = "inxspouse="+option[0]+"; path=/";
         //alert ("The selected option is " + option[0]);
         //const pElem = document.getElementById("p");
         //pElem.textContent = `selectedIndex: ${index}`;
     }
 </script>

 <script>
  const selectElem = document.getElementById("spouse");
  selectElem.addEventListener("change", () => {
    //const index = selectElem.selectedIndex;
    //document.cookie = "inxspouse="+index+"; path=/";

    //const pElem = document.getElementById("p");
    //pElem.textContent = `selectedIndex: ${index}`;

    const wedding = document.getElementById("wedding");
    wedding.value = "<?php echo $spouses[(int)$_COOKIE['inxspouse']][$fldWEDDIN]; ?>";
    const placew  = document.getElementById("placew");
    placew.value  = "<?php echo $spouses[(int)$_COOKIE['inxspouse']][$fldPLACEW]; ?>";
    //const mapsw  = document.getElementById("placew");
    //mapsw.value  = "<?php echo $spouses[(int)$_COOKIE['inxspouse']][$fldPLACEW]; ?>";
  });
 </script>


 <tr bgcolor="#ebdac7"><td><?php echo $field_wedding; ?></td>
  <td><input type="text" name="wedding" id="wedding" size="25" value="<?php echo $weddinga; ?>"></td>
 </tr>

 <tr bgcolor="#ebdac7"><td><?php echo $field_placew; ?></td>
  <td><input type="text" name="placew" id="placew" size="60" value="<?php echo $placewa; ?>"></td>
 </tr>


 <tr><td><?php echo $field_occu; ?></td>
  <td><input type="text" name="occu" size="60" value="<?php echo $occua; ?>"></td>
 </tr>

 <tr><td><?php echo $field_nati; ?></td>
  <td><input type="text" name="nati" size="60" value="<?php echo $natia; ?>"></td>
 </tr>

 <tr><td><?php echo $field_educ; ?></td>
  <td><input type="text" name="educ" size="60" value="<?php echo $educa; ?>"></td>
 </tr>

 <tr><td><?php echo $field_reli; ?></td>
  <td><input type="text" name="reli" size="60" value="<?php echo $relia; ?>"></td>
 </tr>

 <tr><td><?php echo $field_note; ?></td>
  <td><textarea name="notes" rows="5" cols="80"><?php echo $notesa; ?></textarea></td>
 </tr>

 <tr><td colspan="2" align="center">
  <input type="submit" name="saveperson" value="<?php echo $save; ?>">
<?php
  if($inx_person != -1) echo '<input type="submit" name="deleteperson" onclick="return confirm_delete()" value="'.$delete.'">'
?>

<script type="text/javascript">
    function confirm_delete() {
        return confirm("<?php echo $questdel; ?>");
    }
</script>

  </td>
 </tr>
 </table>
 </form>

 <?  

//if (!empty($_REQUEST)) {
//  print_r($_REQUEST);
//}

//if($_POST['father_key']) echo 'father_key='.$_POST['father_key'].'<br>';
//if($_POST['mother_key']) echo 'mother_key='.$_POST['mother_key'].'<br>';
//if($_POST['spouse_key']) echo 'spouse_key='.$_POST['spouse_key'].'<br>';

  echo "</div></div>";
  echo "<p><br></p>";
}

function resize_image($file, $w, $h, $crop=FALSE) {
echo $file;
    list($width, $height) = getimagesize($file);
    $r = $width / $height;
    if ($crop) {
        if ($width > $height) {
            $width = ceil($width-($width*abs($r-$w/$h)));
        } else {
            $height = ceil($height-($height*abs($r-$w/$h)));
        }
        $newwidth = $w;
        $newheight = $h;
    } else {
        if ($w/$h > $r) {
            $newwidth = $h*$r;
            $newheight = $h;
        } else {
            $newheight = $w/$r;
            $newwidth = $w;
        }
    }
    $src = imagecreatefromjpeg($file);
    $dst = imagecreatetruecolor($newwidth, $newheight);
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
echo $dst;
    return $dst;
}

function resizeBase64Image($base64_image, $new_width, $new_height) {
    $image_data = base64_decode($base64_image);
    $img = imagecreatefromstring($image_data);
    $resized_image = imagecreatetruecolor($new_width, $new_height);

    imagecopyresampled($resized_image, $img, 0, 0, 0, 0, $new_width, $new_height, imagesx($img), imagesy($img));

    ob_start();
    imagepng($resized_image);
    $resized_base64 = base64_encode(ob_get_clean());
    return $resized_base64;
}
// Usage
//$base64_image = '...'; // Replace with your Base64 image
//$new_width = 300;
//$new_height = 200;
//resizeBase64Image($base64_image, $new_width, $new_height);

//  echo deleteGET("http://mysite.ru/?view=category&amp;page=5&amp;id=5", "page");
function deleteGET($url, $name, $amp = true) {
  $url = str_replace("&amp;", "&", $url); // Заменяем сущности на амперсанд, если требуется
  list($url_part, $qs_part) = array_pad(explode("?", $url), 2, ""); // Разбиваем URL на 2 части: до знака ? и после
  parse_str($qs_part, $qs_vars); // Разбиваем строку с запросом на массив с параметрами и их значениями
  unset($qs_vars[$name]); // Удаляем необходимый параметр
  if (count($qs_vars) > 0) { // Если есть параметры
    $url = $url_part."?".http_build_query($qs_vars); // Собираем URL обратно
    if ($amp) $url = str_replace("&", "&amp;", $url); // Заменяем амперсанды обратно на сущности, если требуется
  }
  else $url = $url_part; // Если параметров не осталось, то просто берём всё, что идёт до знака ?
  return $url; // Возвращаем итоговый URL
}

function Redirect($url, $permanent = false)
{
    if (headers_sent() === false)
    {
        header('Location: ' . $url, true, ($permanent === true) ? 301 : 302);
    }

    exit();
}

?>

