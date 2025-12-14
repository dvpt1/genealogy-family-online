<?php

include_once("cvars.php");
//include_once("cutils.php");
//$filter = "";
//if(isset($_GET['filter']) $filter = $_GET['filter'];

Gedcom_Import();

function Gedcom_Import()
{
  GLOBAL $fldINX;
  GLOBAL $fldID;

  GLOBAL $fldPER;
  GLOBAL $fldSEX;
  GLOBAL $fldBEG;
  GLOBAL $fldEND;
  GLOBAL $fldFAT;
  GLOBAL $fldMOT;
  GLOBAL $fldSPS;
  GLOBAL $fldPLB;
  GLOBAL $fldPLD;
  GLOBAL $fldPLL;
  GLOBAL $fldPLT;
  GLOBAL $fldMAPB;
  GLOBAL $fldMAPD;
  GLOBAL $fldMAPL;
  GLOBAL $fldMAPT;
  GLOBAL $fldOCCU;
  GLOBAL $fldNATI;
  GLOBAL $fldEDUC;
  GLOBAL $fldRELI;
  GLOBAL $fldNOTE;
  GLOBAL $fldICON;
  GLOBAL $fldCHAN;

  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $fldSPOUS1;
  global $fldSPOUS2;
  global $fldWEDDIN;
  global $fldPLACEW;
  global $fldMAPSW;

  global $fldTIMESTAMP;
  global $fldAVTOR;
  global $fldDATETIME;
  global $fldAVTORUP;
  global $fldDATETIMEUP;

  global $peoples;
  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;
  global $residences;
  global $getdir;
  global $page;
  global $filter;

  GLOBAL $gedcoms;
  GLOBAL $gedcom;

  // массивы внутренние
  global $listFamilyId;
  global $listFamily;
  global $listPerson;
  global $listBirth;
  global $listDeath;
  global $listGender;
  global $listFather;
  global $listMother;
  global $listPlaceb;
  global $listPlaced;
  global $listPlacel;
  global $listPlacet;
  global $listMapsb;
  global $listMapsd;
  global $listMapsl;
  global $listMapst;
  global $listWife;
  global $listOccu;
  global $listNati;
  global $listEduc;
  global $listReli;
  global $listNote;
  global $listIcon;
  global $listChange;
  //
  global $indi_inx;
  global $indi_id;
  global $indi_famc;
  global $indi_fams;
  global $indi_note;
  //
  global $pfam_id;
  global $pfam_father;
  global $pfam_mother;
  global $pfam_childr;
  //
  global $pchi_id;
  global $pchi_childr;
  //
  global $listFChildId;
  global $listFatherId;
  global $listMChildId;
  global $listMotherId;
  global $listSChildId;
  global $listSpouseId;
  global $listWedding;
  global $listPlacew;
  global $listMapsw;
  //
  global $go_indi;
  global $cur;
  global $fn;
  global $notes;
  global $maps;
  //
  global $changes;
  global $sWeddin;
  global $sPlacew;
  global $sMapsw;
  //
  global $birt;
  global $dead;
  global $marr;
  global $resi;
  global $buri;
  global $chan;

  global $childrId;
  global $fatherId;
  global $motherId;
  global $childrInx;
  global $fatherInx;
  global $motherInx;
 
  $id;
  $ok;

  // import persons
//echo "<br><br>IMPORT<br><br>";
  $mainPath = __DIR__ . '/cards/';
//echo "<br><br>$mainPath<br> $filter<br>";

  $fil = false;
  if(empty($filter)) $fil = true;

  $files = glob($mainPath."*.card");
  $ifat = 0;
  $imot = 0;
  $isps = 0;
  $inx = 0;
  foreach ($files as $fileName) {
    //echo "<hr width=50%>";
    //echo "$fileName size " . filesize($fileName) . "<br>\n";

    // The JSON file
    // Read the file into a variable
    $jsonData = file_get_contents("$fileName");
    // Decode the JSON data into a PHP associative array
    $dataPerson = json_decode($jsonData, true);
    //print_r($dataPerson);
    
    //$name0 = basename($fileName); // To get file name
    //$name1 = pathinfo($fileName, PATHINFO_EXTENSION); // To get extension
    //$name2 = pathinfo($fileName, PATHINFO_FILENAME); // File name without extension
    // Начинаем столбец
    $id = $dataPerson['id'];//pathinfo($fileName, PATHINFO_FILENAME); // File name without extension
    $person = $dataPerson['person'];
    $gender = $dataPerson['gender'];
    $birthday = $dataPerson['birthday']['date'];//date
    //$residay = $dataPerson['residay']['date'];
    $deathday = $dataPerson['deathday']['date'];
    $burialday = $dataPerson['burialday']['date'];
    $birthplace = $dataPerson['birthday']['place'];//place
    //$resiplace = $dataPerson['residay']['place'];
    $deathplace = $dataPerson['deathday']['place'];
    $burialplace = $dataPerson['burialday']['place'];
    $birthmaps = $dataPerson['birthday']['maps'];//map
    $deathmaps = $dataPerson['deathday']['maps'];
    //$resimaps = $dataPerson['residay']['maps'];
    $burialmaps = $dataPerson['burialday']['maps'];
    $father = $dataPerson['fathers'];
    $mother = $dataPerson['mothers'];
    $spouse = $dataPerson['spouses'];
    $residence = $dataPerson['residay'];
    $occupation = $dataPerson['occupation'];
    $national = $dataPerson['national'];
    $education = $dataPerson['education'];
    $religion = $dataPerson['religion'];
    $notes = $dataPerson['notes'];
    $icon = $dataPerson['icon'];

    $ftimestamp = $dataPerson['stamp']['timestamp'];
    $favtor     = $dataPerson['stamp']['avtor'];
    $fdatetime  = $dataPerson['stamp']['datetime'];
    $favtorup   = $dataPerson['stamp']['avtorup'];
    $fdatetimeup = $dataPerson['stamp']['datetimeup'];

    //echo "<hr width=50%>";
    //echo "id = ".$id."<br>";
    //echo "inx = ".$inx."<br>";
    //echo "gender = ".$gender."<br>";
    //echo "person = ".$person." =<br>";
    //echo "father = ".print_r($father)."=<br>";
    //echo "mother = ".print_r($mother)."=<br>";
    //echo "spouse = ".print_r($spouse)."=<br>";
    //echo "residence = ".print_r($residence)."=<br>";
    //echo "<hr width=75%>";

    // Add fathers
    //print_r($father); echo "== father ==<br>";
    $ft = "";
    for ($i = 0; $i < count($father); $i++){
      if($ft == "") {$ft = $father[$i]['id'];} else {$ft += ",".$father[$i]['id'];}
      $fathers[$ifat] = array($id, $father[$i]['id']);
      $ifat++;
    }
    //echo "ft = ".$ft."<br>";

    // Add mothers
    //print_r($mother); echo "== mother ==<br>";
    $mt = "";
    for ($i = 0; $i < count($mother); $i++){
      if($mt == "") {$mt = $mother[$i]['id'];} else {$mt += ",".$mother[$i]['id'];}
      $mothers[$imot] = array($id, $mother[$i]['id']);
      $imot++;
    }
    //echo "mt = ".$mt."<br>";

    // Add spouses
    //print_r($spouse); echo "== spouse ==<br>";
    $st = 0;
    for ($i = 0; $i < count($spouse); $i++)
    {
        $b = true;
        $sps = $spouse[$i]['id'];
        for ($n = 0; $n < count($spouses); $n++)
        {
            if ($spouses[$n][$fldSPOUS1] == $sps && $spouses[$n][$fldSPOUS2] == $id)
            {
                $b = false;
                break;
            }
            if ($spouses[$n][$fldSPOUS1] == $id && $spouses[$n][$fldSPOUS2] == $sps)
            {
                $b = false;
                break;
            }
        }

        if ($b)// если такой пары нет, добавляем
        {
            $sWedding = $spouse[$i]['wedding'];;
            $sPlacew = $spouse[$i]['place'];;
            $sMapsw = $spouse[$i]['maps'];;
            if (!empty($sPlacew))
            {
                $p1 = strpos($sPlacew, "[");
                $p2 = strpos($sPlacew, "|");
                $p3 = strpos($sPlacew, "]");
                if ($p1 && $p2 && $p3 && $p1 < $p2 && $p2 < $p3)
                {
                    $sMapsw = substr($sPlacew, $p1, $p3 - $p1 + 1);
                    $sPlacew = substr($sPlacew, 0, $p1 - 1);
                }
            }

            $spouses[] = array($id, $sps, $sWedding, $sPlacew, $sMapsw);
            $isps++;
            if($st == "") {$st = $spouse[$i]['id'];} else {$st += ",".$spouse[$i]['id'];}
        }
    }
    // Add residence
    //print_r($residence); echo "== residences ==<br>";
    for ($i = 0; $i < count($residence); $i++)
    {
        $sDatel = $residence[$i]['date'];;
        $sPlacel = $residence[$i]['place'];;
        $sMapsl = $residence[$i]['maps'];;
        $residences[] = array($id, $sDatel, $sPlacel, $sMapsl);
    }

    if(strpos($person, $filter) !== false || $fil)
    {
        $persons[$inx] = array
    	(                       
	    $inx,          
	    $id,           
	    $person,
	    $gender,                
	    $birthday,
	    $deathday,
	    $ft,
	    $mt,
	    $st,
	    $birthplace, 
	    $deathplace, 
	    //$resiplace,
	    $burialplace,
	    $birthmaps,
	    $deathmaps,
	    //$resimaps,
	    $burialmaps,
	    $occupation,
	    $national,
	    $education,
	    $religion,
	    $notes,
	    $icon,
	    "",//$listChange[$i]         
    	);

        $peoples[$inx] = array
    	(                       
            $ftimestamp,
            $favtor,
            $fdatetime,
            $favtorup,
            $fdatetimeup,
	    "",//$listChange[$i]         
    	);

        $inx++;
     }
  }

  // здесь надо перевести $fathers['id'] в индекс
  for ($i = 0; $i < count($fathers); $i++){
    for ($j = 0; $j < count($persons); $j++){
      if($fathers[$i][0] == $persons[$j][$fldID]){
        $fathers[$i][0] = $j;
        break;
      }
    }
  }
  for ($i = 0; $i < count($fathers); $i++){
    for ($j = 0; $j < count($persons); $j++){
      if($fathers[$i][1] == $persons[$j][$fldID]){
        $fathers[$i][1] = $j;
        break;
      }
    }
  }
  // здесь надо перевести $mothers['id'] в индекс
  for ($i = 0; $i < count($mothers); $i++){
    for ($j = 0; $j < count($persons); $j++){
      if($mothers[$i][0] == $persons[$j][$fldID]){
        $mothers[$i][0] = $j;
        break;
      }
    }
  }
  for ($i = 0; $i < count($mothers); $i++){
    for ($j = 0; $j < count($persons); $j++){
      if($mothers[$i][1] == $persons[$j][$fldID]){
        $mothers[$i][1] = $j;
        break;
      }
    }
  }
  // здесь надо перевести $spouses['id'] в индекс
  for ($i = 0; $i < count($spouses); $i++){
    for ($j = 0; $j < count($persons); $j++){
      if($spouses[$i][$fldSPOUS1] == $persons[$j][$fldID]){
        $spouses[$i][$fldSPOUS1] = $j;
        break;
      }
    }
  }
  for ($i = 0; $i < count($spouses); $i++){
    for ($j = 0; $j < count($persons); $j++){
      if($spouses[$i][$fldSPOUS2] == $persons[$j][$fldID]){
        $spouses[$i][$fldSPOUS2] = $j;
        break;
      }
    }
  }
  // здесь надо перевести $residences['id'] в индекс
  for ($i = 0; $i < count($residences); $i++){
    for ($j = 0; $j < count($persons); $j++){
      if($residences[$i][0] == $persons[$j][$fldID]){
        $residences[$i][0] = $j;
        break;
      }
    }
  }

//echo "<br><br><br><br>";
//for ($i = 0; $i < count($listPerson); $i++) echo "PERSON: ".$listBirth[$i].";".$listDeath[$i].";".$listPerson[$i].";".$father.";".$mother.";".$gender.";".$sPlaceb.";".$sPlaced.";".$spouse."<br>";
//for ($i = 0; $i < count($persons); $i++) echo "PERSON: ".$persons[$i][0]."|".$persons[$i][1]."|".$persons[$i][2]."|".$persons[$i][3]."|".$persons[$i][4]."|".$persons[$i][5]."|".$persons[$i][6]."|".$persons[$i][7]."|".$persons[$i][8]."|".$persons[$i][9]."<br>";
//for ($i = 0; $i < count($persons); $i++) echo "PERSON: ".$persons[$i][$fldINX]."|".$persons[$i][$fldID]."|".$persons[$i][$fldPERL]."|".$persons[$i][$fldPERF]."|".$persons[$i][$fldPERS]."|".$persons[$i][$fldFAT]."|".$persons[$i][$fldMOT]."|".$persons[$i][$fldSEX]."<br>";//"|".$persons[$i][$fldICON]."|".
//for ($i = 0; $i < count($listFather); $i++) echo "FATHER: ".$listFather[$i]."<br>";
//for ($i = 0; $i < count($listMother); $i++) echo "MOTHER: ".$listMother[$i]."<br>";
//for ($i = 0; $i < count($fathers); $i++) echo "FATHER: ".$fathers[$i][0]."|".$fathers[$i][1]."<br>";
//for ($i = 0; $i < count($mothers); $i++) echo "MOTHER: ".$mothers[$i][0]."|".$mothers[$i][1]."<br>";
//for ($i = 0; $i < count($spouses); $i++) echo "SPOUSE $i: ".$spouses[$i][$fldSPOUS1]." | ".$spouses[$i][$fldSPOUS2]." | ".$spouses[$i][$fldWEDDIN]." | ".$spouses[$i][$fldPLACEW]." | ".$spouses[$i][$fldMAPSW]." |<br>";
//for ($i = 0; $i < count($listFChildId); $i++) {echo "CHILDFATHER=".$listFChildId[$i].";".$listFatherId[$i]."<br>";}
//for ($i = 0; $i < count($listMChildId); $i++) {echo "CHILDMOTHER=".$listMChildId[$i].";".$listMotherId[$i]."<br>";}
//for ($i = 0; $i < count($listSpouseId); $i++) {echo "SPOUSEID=".$listSChildId[$i].";".$listSpouseId[$i]."<br>";}
//for ($i = 0; $i < count($peoples); $i++) echo "PEOPLES: ".$peoples[$i][0]." | ".$peoples[$i][1]." | ".$peoples[$i][2]." | ".peoples[$i][3]." | ".peoples[4]." | "."<br>";
//for ($i = 0; $i < count($residences); $i++){
 //if($residences[$i][0] == 0){
//  echo "RESIDENCE: ".$residences[$i][0]." | ".$residences[$i][1]." | ".$residences[$i][2]." | "."<br>";
 //}
//}
//echo "persons=".count($persons)."<br>";
//echo "fathers=".count($fathers)."<br>";
//echo "mothers=".count($mothers)."<br>";
//echo "spouses=".count($spouses)."<br>";
//echo "residences=".count($residences)."<br>";

}
  
  

?>
