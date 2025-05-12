<?php

include_once("ccfg.php");
include_once("cutils.php");
include_once("cvars.php");

//$user = _check_auth($_COOKIE);
//global $userId;
//$userId = $user['id'];

//$user = "admin@dnadata";//_check_user($_COOKIE);
$user = array();
$user['id']   = 1;

//Gedcom_Export();
function Gedcom_Export()
{
//echo "<br><br><br><br>Gedcom_Export()<br>";
  global $userId;

  GLOBAL $fldINX;
  GLOBAL $fldID;

  GLOBAL $fldBEG;
  GLOBAL $fldEND;
  GLOBAL $fldPER;
  GLOBAL $fldFAT;
  GLOBAL $fldMOT;
  GLOBAL $fldSEX;
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

  global $peoples;
  global $persons;
  global $fathers;
  global $mothers;
  global $spouses;
  global $page;

  GLOBAL $gedcoms;
  GLOBAL $gedcom;

  // массивы внутренние
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
  global $pfam_wife;
  global $pfam_husband;
  global $pfam_weddin;
  global $pfam_placew;
  global $pfam_mapsw;
  //
  global $pchi_id;
  global $pchi_childr;
  //
  $id = -1;
  $ido = 1;

//echo "<br><br>=== GEDCOM User==".$userId."<br>";
//echo "=== GEDCOM File==".$getfile."<br>";

  // заголовок
  $sss = "0 HEAD\n";
  $sss .= "1 SOUR Genealogical Data Online\n";
  $sss .= "2 VERS $https";
//  $sss .= "2 NAME " + App.owner_name + "\n";
//  $sss .= "2 ADDR " + App.owner_addr + "\n";
//  $sss .= "2 PHON " + App.owner_phone + "\n";
//  $sss .= "2 EMAIL " + App.owner_email + "\n";
  $sss .= "1 DEST FamilyTree\n";
  $sss .= "1 DATE DD MMM YYYY\n";
  $sss .= "1 CHAR utf-8\n";
  $sss .= "1 GEDC\n";
  $sss .= "2 VERS 5.5\n";

  $cnt_persons = count($persons);
  for ($l = 0; $l < $cnt_persons; $l++) {
      $person = $persons[$l];
//echo $person[$fldPER];
      
      $fatherss = getFathers($person[$fldINX]);
      $motherss = getMothers($person[$fldINX]);
      
      $fatherId = -1;
      $fatherInx = -1;
      $motherId = -1;
      $motherInx = -1;
      
      $sWeddin = "";
      $sPlacew = "";
      $sMapsw = "";
      
      if (count($fatherss) != 0 || count($motherss) != 0)
      {
          if (count($fatherss) > 0 && count($motherss) > 0)
          {
              for ($f = 0; $f < count($fatherss); $f++)
              {
                  $fatherInx = $fatherss[$f][$fldFATHE];
                  $fatherId = $persons[$fatherInx][$fldID];
      
                  for ($m = 0; $m < count($motherss); $m++)
                  {
                      $motherInx = $motherss[$m][$fldMOTHE];
                      $motherId = $persons[$motherInx][$fldID];
      
                      $b = false;
                      for ($n = 0; $n < count($pfam_id); $n++)
                      {
                          if (($pfam_father[$n] == $fatherId) && ($pfam_mother[$n] == $motherId))
                          {
                              $b = true;
                              break;
                          }
                      }
      
                      if (!$b)
                      {//если такой семьи в списке нет
                          $spousem = getsSpouses($fatherInx, $motherInx);
                          if (count($spousem) > 0)
                          {
                              $sWeddin = $spousem[0][$fldWEDDIN];//field_Wedding
                              $sPlacew = $spousem[0][$fldPLACEW];//field_Placew
                              $sMapsw  = $spousem[0][$fldMAPSW];//field_Mapsw 
                          }
                          else
                          {
                              $spousew = getsSpouses($motherInx, $fatherInx);
                              if (count($spousew) > 0)
                              {
                                  $sWeddin = $spousew[0][$fldWEDDIN];//field_Wedding
                                  $sPlacew = $spousew[0][$fldPLACEW];//field_Placew 
                                  $sMapsw  = $spousew[0][$fldMAPSW];//field_Mapsw  
                              }
                          }
      
                          $pfam_id[] = ($cnt_persons + count($pfam_id));
                          $pfam_father[] = $fatherId;
                          $pfam_mother[] = $motherId;
                          $pfam_childr[] = -1;
                          $pfam_wife[] = -1;
                          $pfam_husband[] = -1;
                          $pfam_weddin[] = $sWeddin;
                          $pfam_placew[] = $sPlacew;
                          $pfam_mapsw[] = $sMapsw;
                      }
                  }
              }
          }
          else if (count($fatherss) > 0)
          {
              for ($f = 0; $f < count($fatherss); $f++)
              {
                  $fatherInx = $fatherss[$f][$fldFATHE];
                  $fatherId = $persons[$fatherInx][$fldID];
      
                  $b = false;
                  for ($n = 0; $n < count($pfam_id); $n++)
                  {
                      if (($pfam_father[$n] == $fatherId) && ($pfam_mother[$n] == $motherId))
                      {
                          $b = true;
                          break;
                      }
                  }
      
                  if (!$b)
                  {//если такой семьи в списке нет
                     $pfam_id[] = ($cnt_persons + count($pfam_id));
                     $pfam_father[] = $fatherId;
                     $pfam_mother[] = -1;
                     $pfam_childr[] = -1;
                     $pfam_wife[] = -1;
                     $pfam_husband[] = -1;
                     $pfam_weddin[] = $sWeddin;
                     $pfam_placew[] = $sPlacew;
                     $pfam_mapsw[] = $sMapsw;
                  }
              }
          }
          else if (count($motherss) > 0)
          {
              for ($m = 0; $m < count($motherss); $m++)
              {
                  $motherInx = $motherss[$m][$fldMOTHE];
                  $motherId = $persons[$motherInx][$fldID];
      
                  $b = false;
                  for ($n = 0; $n < count($pfam_id); $n++)
                  {
                      if (($pfam_father[$n] == $fatherId) && ($pfam_mother[$n] == $motherId))
                      {
                          $b = true;
                          break;
                      }
                  }
      
                  if (!$b)
                  {//если такой семьи в списке нет
                     $pfam_id[] = ($cnt_persons + count($pfam_id));
                     $pfam_father[] = -1;
                     $pfam_mother[] = $motherId;
                     $pfam_childr[] = -1;
                     $pfam_wife[] = -1;
                     $pfam_husband[] = -1;
                     $pfam_weddin[] = $sWeddin;
                     $pfam_placew[] = $sPlacew;
                     $pfam_mapsw[] = $sMapsw;
                  }
              }
          }
      }
  }
  //дозаполняю элементы списка супругами
////echo "=== Save GEDCOM = дозаполняю элементы списка супругами<br>";
  for ($id = 0; $id < $cnt_persons; $id++)
  {
      $spouse = getSpouses($persons[$id][$fldINX]);
  
      if (count($spouse) > 0)
      {
          for ($n = 0; $n < count($spouse); $n++)
          {
              $b = false;
              $personInx = $spouse[$n][$fldSPOUS1];
              $spouseInx = $spouse[$n][$fldSPOUS2];
              if ($spouseInx > -1 && $personInx > -1)
              {
                  $spouseId = $persons[$spouseInx][$fldID];
                  $personId = $persons[$personInx][$fldID];
  
                  for ($i = 0; $i < count($pfam_id); $i++)
                  {
                      if (($pfam_husband[$i] == $personId) && ($pfam_wife[$i] == $spouseId))
                      {
                          $b = true;
                          break;
                      }
                      if (($pfam_husband[$i] == $spouseId) && ($pfam_wife[$i] == $personId))
                      {
                          $b = true;
                          break;
                      }
                  }
                  if (!$b)
                  {//если такой пары в списке нет
                      $pfam_id[] = ($cnt_persons + count($pfam_id));
                      $pfam_father[] = -1;
                      $pfam_mother[] = -1;
                      $pfam_wife[] = $spouseId;
                      $pfam_husband[] = $personId;
                      $pfam_childr[] = -1;
                      $pfam_weddin[] = $spouse[$n][$fldWEDDIN];//field_Wedding
                      $pfam_placew[] = $spouse[$n][$fldPLACEW]; //field_Placew 
                      $pfam_mapsw[]  = $spouse[$n][$fldMAPSW];   //field_Mapsw  
                  }
              }
          }
      }
  }
  // секция INDI
////echo "=== Save GEDCOM = секция INDI<br>";
  // семьи
  for ($id = 0; $id < $cnt_persons; $id++)
  {
      $sss .= "0 @I".$persons[$id][$fldID]."@ INDI\n";
      //$sss .= "1 NAME ".trim($persons[$id][$fldPER])."\n";
      $sss .= "1 NAME ".LastName($persons[$id][$fldPER])." /".FirstName($persons[$id][$fldPER])."/\n";
      //??$sss .= "1 FMSS @".$persons[$id][$fldFamilyId]."@\n";
      if ($persons[$id][$fldSEX] == 1)
      {
          $sss .= "1 SEX M\n";
      }
      else if ($persons[$id][$fldSEX] == 2)
      {
          $sss .= "1 SEX F\n";
      }

      if (strlen($persons[$id][$fldNATI]) > 0)
      {
          $sss .= "1 NATI ".$persons[$id][$fldNATI]."\n";
      }

      if (strlen($persons[$id][$fldOCCU]) > 0)
      {
          $sss .= "1 OCCU ".$persons[$id][$fldOCCU]."\n";
      }

      if (strlen($persons[$id][$fldEDUC]) > 0)
      {
          $sss .= "1 EDUC ".$persons[$id][$fldEDUC]."\n";
      }

      if (strlen($persons[$id][$fldRELI]) > 0)
      {
          $sss .= "1 RELI ".$persons[$id][$fldRELI]."\n";
      }

      if ((strlen($persons[$id][$fldBEG]) > 0) || (strlen($persons[$id][$fldPLB]) > 0) || (strlen($persons[$id][$fldMAPB]) > 0))
      {
          $sss .= "1 BIRT\n";
          if (strlen($persons[$id][$fldBEG]) > 0)
          {
              $sss .= "2 DATE ".trim($persons[$id][$fldBEG])."\n";
          }
          if (strlen($persons[$id][$fldPLB]) > 0)
          {
              $sss .= "2 PLAC ".$persons[$id][$fldPLB]."\n";
          }
          if (strlen($persons[$id][$fldMAPB]) > 0)
          {
              $maps = $persons[$id][$fldMAPB];
              $p1 = strpos($maps, "[");
              $p2 = strpos($maps, "|");
              $p3 = strpos($maps, "]");

              if ($p1 != -1 && $p2 != -1 && $p3 != -1 && $p1 < $p2 && $p2 < $p3)
              {
                  $sX = substr($maps, $p1 + 1, $p2 - $p1 - 1);
                  $sY = substr($maps, $p2 + 1, $p3 - $p2 - 1);

                  $sss .= "3 MAP"."\n";
                  $sss .= "4 LATI ".$sX."\n";
                  $sss .= "4 LONG ".$sY."\n";
              }
          }
      }

      if ((strlen($persons[$id][$fldEND]) > 0) || (strlen($persons[$id][$fldPLD]) > 0) || (strlen($persons[$id][$fldMAPD]) > 0))
      {
          $sss .= "1 DEAT \n";
          if (strlen($persons[$id][$fldEND]) > 0)
          {
              $sss .= "2 DATE ".trim($persons[$id][$fldEND])."\n";
          }
          if (strlen($persons[$id][$fldPLD]) > 0)
          {
              $sss .= "2 PLAC ".$persons[$id][$fldPLD]."\n";
          }
          if (strlen($persons[$id][$fldMAPD]) > 0)
          {
              $maps = $persons[$id][$fldMAPD];
              $p1 = strpos($maps, "[");
              $p2 = strpos($maps, "|");
              $p3 = strpos($maps, "]");

              if ($p1 != -1 && $p2 != -1 && $p3 != -1 && $p1 < $p2 && $p2 < $p3)
              {
                  $sX = substr($maps, $p1 + 1, $p2 - $p1 - 1);
                  $sY = substr($maps, $p2 + 1, $p3 - $p2 - 1);

                  $sss .= "3 MAP"."\n";
                  $sss .= "4 LATI ".$sX."\n";
                  $sss .= "4 LONG ".$sY."\n";
              }
          }
      }

      if ((strlen($persons[$id][$fldPLL]) > 0) || (strlen($persons[$id][$fldMAPL]) > 0))
      {
          $sss .= "1 RESI \n";
          if (strlen($persons[$id][$fldPLL]) > 0)
          {
              $sss .= "2 PLAC ".$persons[$id][$fldPLL]."\n";
          }
          if (strlen($persons[$id][$fldMAPL]) > 0)
          {
              $maps = $persons[$id][$fldMAPL];
              $p1 = strpos($maps, "[");
              $p2 = strpos($maps, "|");
              $p3 = strpos($maps, "]");

              if ($p1 != -1 && $p2 != -1 && $p3 != -1 && $p1 < $p2 && $p2 < $p3)
              {
                  $sX = substr($maps, $p1 + 1, $p2 - $p1 - 1);
                  $sY = substr($maps, $p2 + 1, $p3 - $p2 - 1);

                  $sss .= "3 MAP"."\n";
                  $sss .= "4 LATI ".$sX."\n";
                  $sss .= "4 LONG ".$sY."\n";
              }
          }
      }

      if ((strlen($persons[$id][$fldPLT]) > 0) || (strlen($persons[$id][$fldMAPT]) > 0))
      {
          $sss .= "1 BURI \n";
          if (strlen($persons[$id][$fldPLT]) > 0)
          {
              $sss .= "2 PLAC ".$persons[$id][$fldPLT]."\n";
          }
          if (strlen($persons[$id][$fldMAPT]) > 0)
          {
              $maps = $persons[$id][$fldMAPT];
              $p1 = strpos($maps, "[");
              $p2 = strpos($maps, "|");
              $p3 = strpos($maps, "]");

              if ($p1 != -1 && $p2 != -1 && $p3 != -1 && $p1 < $p2 && $p2 < $p3)
              {
                  $sX = substr($maps, $p1 + 1, $p2 - $p1 - 1);
                  $sY = substr($maps, $p2 + 1, $p3 - $p2 - 1);

                  $sss .= "3 MAP"."\n";
                  $sss .= "4 LATI ".$sX."\n";
                  $sss .= "4 LONG ".$sY."\n";
              }
          }
      }

      if (strlen($persons[$id][$fldCHAN]) > 0)
      {
          $sss .= "1 CHAN \n";

          $ch = $persons[$id][$fldCHAN];
          $p1 = strpos($ch, "[");
          $p2 = strpos($ch, "|");
          $p3 = strpos($ch, "]");

          if ($p1 != -1 && $p2 != -1 && $p3 != -1 && $p1 < $p2 && $p2 < $p3)
          {
              $dat = substr($ch, $p1 + 1, $p2 - $p1 - 1);
              $tim = substr($ch, $p2 + 1, $p3 - $p2 - 1);

              $sss .= "2 DATE ".$dat."\n";
              $sss .= "3 TIME ".$tim."\n";
          }
      }

      $person = $persons[$id];
      $fatherss = getFathers($person[$fldINX]);
      $motherss = getMothers($person[$fldINX]);

      $fatherId = -1;
      $fatherInx = -1;
      $motherId = -1;
      $motherInx = -1;

//echo "count=".count($fatherss)."'".count($motherss)."<br>";
      if (count($fatherss) > 0 && count($motherss) > 0)
      {
          for ($f = 0; $f < count($fatherss); $f++)
          {
              $fatherInx = $fatherss[$f][$fldFATHE];
              $fatherId = $persons[$fatherInx][$fldID];

              for ($m = 0; $m < count($motherss); $m++)
              {
                  $motherInx = $motherss[$m][$fldMOTHE];
                  $motherId = $persons[$motherInx][$fldID];

                  for ($i = 0; $i < count($pfam_id); $i++)
                  {
                      if (($pfam_father[$i] != -1) || ($pfam_mother[$i] != -1))
                      {
                          if (($pfam_father[$i] == $fatherId) && ($pfam_mother[$i] == $motherId))
                          {
                              $sss .= "1 FAMC @F".$pfam_id[$i]."@\n";
                              $pfam_childr[$i] = $persons[$id][$fldID];

                              $pchi_id[] = $pfam_id[$i];
                              $pchi_childr[] = $persons[$id][$fldID];
                              break;
                          }
                      }
                  }
              }
          }
      }
      else if (count($fatherss) > 0)
      {
          for ($f = 0; $f < count($fatherss); $f++)
          {
              $fatherInx = $fatherss[$f][$fldFATHE];
              $fatherId = $persons[$fatherInx][$fldID];

              for ($i = 0; $i < count($pfam_id); $i++)
              {
                  if (($pfam_father[$i] != -1) || ($pfam_mother[$i] != -1))
                  {
                      if (($pfam_father[$i] == $fatherId) && ($pfam_mother[$i] == $motherId))
                      {
                          $sss .= "1 FAMC @F".$pfam_id[$i]."@\n";
                          $pfam_childr[$i] = $persons[$id][$fldID];

                          $pchi_id[] = $pfam_id[$i];
                          $pchi_childr[] = $persons[$id][$fldID];
                          break;
                      }
                  }
              }
          }
      }
      else if (count($motherss) > 0)
      {
          for ($m = 0; $m < count($motherss); $m++)
          {
              $motherInx = $motherss[$m][$fldMOTHE];
              $motherId = $persons[$motherInx][$fldID];

              for ($i = 0; $i < count($pfam_id); $i++)
              {
                  if (($pfam_father[$i] != -1) || (pfam_mother[$i] != -1))
                  {
                      if (($pfam_father[$i] == $fatherId) && ($pfam_mother[$i] == $motherId))
                      {
                          $sss .= "1 FAMC @F".$pfam_id[$i]."@\n";
                          $pfam_childr[$i] = $persons[$id][$fldID];

                          $pchi_id[] = $pfam_id[$i];
                          $pchi_childr[] = $persons[$id][$fldID];
                          break;
                      }
                  }
              }
          }
      }

      for ($i = 0; $i < count($pfam_id); $i++)
      {
          if (($pfam_husband[$i] == -1) && ($pfam_wife[$i] == -1))
          {// родители
              if (($pfam_father[$i] == $persons[$id][$fldID]) || ($pfam_mother[$i] == $persons[$id][$fldID]))
              {
                  $sss .= "1 FAMS @F".$pfam_id[$i]."@\n";
              }
          }
          else if (($pfam_husband[$i] > -1) && ($pfam_wife[$i] > -1))
          {// супруги
              if ($persons[$id][$fldSEX] == 1)
              {
                  if ($pfam_husband[$i] == $persons[$id][$fldID])
                  {// если муж
                      $sss .= "1 FAMS @F".$pfam_id[$i]."@\n";
                  }
              }
              else if ($persons[$id][$fldSEX] == 2)
              {
                  if ($pfam_wife[$i] == $persons[$id][$fldID])
                  {// если жена
                      $sss .= "1 FAMS @F".$pfam_id[$i]."@\n";
                  }
              }
          }
      }

      if (strlen($persons[$id][$fldNOTE]) > 0)
      {
          $sss .= "1 NOTE @T".$persons[$id][$fldID]."@\n";
      }

      if (strlen($persons[$id][$fldICON]) > 1)
      {
          $sss .= "1 OBJE\n";
          $sss .= "2 FILE ".$persons[$id][$fldSEX].$persons[$id][$fldICON]."\n";
      }
  }
  // секция FAM
////echo "=== Save GEDCOM = секция FAM<br>";
  for ($id = 0; $id < count($pfam_id); $id++)
  {
      $sss .= "0 @F".$pfam_id[$id]."@ FAM\n";
      $marr = false;
      // отец - мать
      if (($pfam_father[$id] > -1) || ($pfam_mother[$id] > -1))
      {
          if ($pfam_father[$id] > -1) $sss .= "1 HUSB @I".$pfam_father[$id]."@\n";
          if ($pfam_mother[$id] > -1) $sss .= "1 WIFE @I".$pfam_mother[$id]."@\n";
      }
      else
      // муж - жена
      if (($pfam_wife[$id] > -1) && ($pfam_husband[$id] > -1))
      {
          $sss .= "1 WIFE @I".$pfam_wife[$id]."@\n";
          $sss .= "1 HUSB @I".$pfam_husband[$id]."@\n";

          $marr = true;
      }
      // дети
      if (($pfam_childr[$id] != -1))
      {
          for ($i = 0; $i < count($pchi_id); $i++)
          {
              if ($pchi_id[$i] == $pfam_id[$id])
              {
                  $sss .= "1 CHIL @I".$pchi_childr[$i]."@\n";
              }
          }
      }
      // дата и место свадьбы
      if ($marr)
      {
          $sss .= "1 MARR\n";

          $sWeddin = $pfam_weddin[$id];
          $sPlacew = $pfam_placew[$id];
          $sMapsw  = $pfam_mapsw[$id];
          if ($sWeddin != "") $sss .= "2 DATE ".$sWeddin."\n";
          if ($sPlacew != "" || $sMapsw != "") $sss .= "2 PLAC ".$sPlacew." ".$sMapsw."\n";
          if ($sMapsw != "")
          {
              $maps = $sMapsw;
              $p1 = strpos($maps, "[");
              $p2 = strpos($maps, "|");
              $p3 = strpos($maps, "]");

              if ($p1 != -1 && $p2 != -1 && $p3 != -1 && $p1 < $p2 && $p2 < $p3)
              {
                  $sX = substr($maps, $p1 + 1, $p2 - $p1 - 1);
                  $sY = substr($maps, $p2 + 1, $p3 - $p2 - 1);

                  $sss .= "3 MAP\n";
                  $sss .= "4 LATI ".$sX."\n";
                  $sss .= "4 LONG ".$sY."\n";
              }
          }
      }
  }
  // секция NOTE
////echo "=== Save GEDCOM = секция NOTE<br>";
  for ($id = 0; $id < $cnt_persons; $id++)
  {
      if (strlen($persons[$id][$fldNOTE]) > 0)
      {
          $sss .= "0 @T".$persons[$id][$fldID]."@ NOTE\n";
          $buf = str_replace("\r", "\n", $persons[$id][$fldNOTE]);
          $bufs = explode("\n", $buf);
          for ($i = 0; $i < count($bufs); $i++)
          {
              $sss .= "1 CONT ".$bufs[$i]."\n";
          }
      }
  }
  // конец
  $sss .= "0 TRLR\n";

////echo "<br><br><br><br>".$sss."<br>";
  $putfile = 'gedcom/test.ged';
  file_put_contents($putfile, $sss);

  //$gedcom = $sss;
  return $sss;
}

function getFathers($PersonInx){
    // list father //
    GLOBAL $fathers;
    $fat = array();
    for ($i = 0; $i < count($fathers); $i++) {
      if ($fathers[$i][0] == $PersonInx) {
        $fat[] = array($fathers[$i][0], $fathers[$i][1]);
      }
    }
    return $fat;
}
     
function getMothers($PersonInx){
    // list mother //
    GLOBAL $mothers;
    $mot = array();
    for ($i = 0; $i < count($mothers); $i++) {
      if ($mothers[$i][0] == $PersonInx) {
        $mot[] = array($mothers[$i][0], $mothers[$i][1]);
      }
    }
    return $mot;
}

function getsSpouses($PersonInx, $SpouseInx){
    // list spouse //
    GLOBAL $spouses;
    $spouse = array();
    for ($i = 0; $i < count($spouses); $i++)
    {
        if (($PersonInx == spouses[$i][$fldSPOUS1]) && ($SpouseInx == $spouses[$i][$fldSPOUS2]))
        {
            $spouse[] = $spouses[$i];
        }
    }

    return spouse;
}

function getSpouses($PersonInx){
    // list spouse //
    GLOBAL $spouses;
    $spouse = array();

    for ($i = 0; $i < count($spouses); $i++)
    {
        if ($PersonInx == $spouses[$i][$fldSPOUS1])
        {
            $spouse[] = $spouses[$i];
        }else
        if ($PersonInx == $spouses[$i][$fldSPOUS2])
        {
            $spouse[] = $spouses[$i];
        }
    }

    return $spouse;
}

// фамилия
function FirstName($Nama) {
    $p = strpos($Nama," ");
    if ($p > -1)
    {
        return trim(substr($Nama, 0, $p));
    }
    else
    {
        return $Nama;
    }
}
// имя и отчество
function LastName($Nama) {
    $p = strpos($Nama," ");
    if ($p > -1)
    {
        return trim(substr($Nama, $p + 1));
    }
    else
    {
        return "";
    }
}

?>
