<?php

include_once("ccfg.php");
include_once("cutils.php");
include_once("cvars.php");

//$user = _check_auth($_COOKIE);
//global $userId;
//$userId = $user['id'];

//$user = "admin@dnadata";//_check_user($_COOKIE);
$user = array();
$user['id'] = $_COOKIE['myfamilytree_userid'];
$user['name'] = $_COOKIE['myfamilytree_username'];

Gedcom_Import($user);

function Gedcom_Import($user)
{
  global $timestamp;

  global $https;
  $userId = $user['id'];
  $userName = $user['name'];

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
  global $getdir;
  global $page;

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
  global $listSpouse;
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
  $cur = -1;

echo "<br><br>=== GEDCOM User==".$userId."<br>";
//echo "=== GEDCOM File==".$getfile."<br>";

  if(!empty($gedcom)){
//echo "<br><br><br>=== GEDCOM gedcom==".$gedcom."<br>";

    $peoples = explode("\n", $gedcom);
    $cnt_persons = count($peoples);
    for ($l = 0; $l < $cnt_persons; $l++) {

        $line = $peoples[$l];
//echo "===line=".$line."<br>";
        $s = strtoupper(trim($line));
        
        $ok = true;
        if (empty($s))
        {
            $ok = false;
        }
        else
        {
            $ss = trim(substr($s, 1));
            if (substr($ss, 0, 1) == '_') $ok = false;
        }
        
        if ($ok)
        {
            if (substr($s, 0, 1) == "0")
            {
                $trlr = strpos($s,"TRLR");
                if ($trlr) break;
                $head = strpos($s,"HEAD");
                $indi = strpos($s,"INDI");
                if ($indi)
                {
        
                    $go_indi = true;
        
                    if (($cur > -1) && ($fn == -1) && (strlen($notes) > 0))
                    {// если примечание в теле INDI
                        $listNote[$cur] = $notes;
        
                        $notes = "";
                    }
        
                    $cur++;//echo "cur:".$cur."<br>";
                    $indi_inx[] = $cur;//индекс по порядку
                    $indi_id[] = strNumBetween(substr($s, 1));//индекс по gedcom
//echo $cur.":".strNumBetween(substr($s, 1))."<br>";
                    $indi_famc[] = -1;
                    $indi_fams[] = -1;
                    $indi_note[] = -1;
                    $listFamilyId[] = -1;
                    $listPerson[] = "";
                    $listBirth[] = "";
                    $listDeath[] = "";
                    $listGender[] = 0;
                    $listFather[] = "";
                    $listMother[] = "";
                    $listSpouse[] = "";
                    $listPlaceb[] = "";
                    $listPlaced[] = "";
                    $listPlacel[] = "";
                    $listPlacet[] = "";
                    $listMapsb[] = "";
                    $listMapsd[] = "";
                    $listMapsl[] = "";
                    $listMapst[] = "";
                    $listWife[] = "";
                    $listOccu[] = "";
                    $listNati[] = "";
                    $listEduc[] = "";
                    $listReli[] = "";
                    $listNote[] = "";
                    $listIcon[] = "";
                    $listChange[] = "";
        
                    $chan = false;
                    $birt = false;
                    $dead = false;
                    $buri = false;
                    $resi = false;
                    $obje = false;

                }
        
                $fam = strpos($s, "FAM");
                if ($fam)
                {
                    InsertSpouse();//добавляю супругов если есть
                    $fatherId = -1;
                    $motherId = -1;
                }
                $note = strpos($s, "NOTE");
                if ($note)
                {
                    if (($fn > -1) && (strlen($notes) > 0))
                    {
                        $listNote[$fn] = $notes;
        
                        $notes = "";
                    }
        
                    $fn = -1;
                    $ii = strNumBetween(substr($s,1));
                    for ($i = 0; $i < count($indi_inx); $i++)
                    {//ищу в Grid'e
                        if ($indi_note[$i] == $ii)
                        {
                            $fn = $indi_inx[$i];

                            break;
                        }
                    }
                }
        
            }
            else if (substr($s, 0, 1) == "1")
            {
                if ($head)
                {
                    if (strpos($s,"DATE"))
                    {
                        $i = strpos($s,"DATE");
                        if (strlen($line) > $i + 5)
                            $fd = substr($line, $i + 5);
                    }
                    else if (strpos($s,"CHAR"))
                    {
                        $i = strpos($s,"CHAR");
                        if (strlen($line) > $i + 5)
                            $code_char = strtoupper(trim(substr($line, $i + 5)));
                    }
                }
                else if ($indi)
                {
                    if ((strpos($s,"NAME")) && (strpos($s,"NAME") < 4))
                    {//игнорировать Name
                        $i = strpos($s,"NAME");
                        $person = substr($line, $i + 4);
        
                        $ss = "";
                        $i = strpos($person, "/");
                        if ($i)
                        {
                            $ss = trim(substr($person, $i + 1));
                            $ss = trim(strDeleteAll($ss, '/'));
                            if (strlen(trim($ss)) <= 0)
                            {
                                $person = trim(substr($person, 0, $i - 1));
                            }
                            else
                            {
                                $person = $ss." ".trim(substr($person, 0, $i - 1));
                            }
                        }
        
                        $listPerson[$cur] = $person;
//echo "=== current person = $indi_inx[$cur] = $indi_id[$cur] = $listPerson[$cur] <br>";
                        // переменные в ноль
                        $chan = false;
                        $birt = false;
                        $dead = false;
                        $resi = false;
                        $buri = false;
                        $obje = false;
                    }
                    else if (strpos($s,"SEX"))
                    {
                        $i = strpos($s,"SEX");
                        $ss = trim(substr($s, $i + 3));
                        if (strlen(trim($ss)) > 0)
                        {
                            if ($ss == "M")
                                $listGender[$cur] = "1";
                            else
                                if ($ss == "F") $listGender[$cur] = "2";
                            else
                                $listGender[$cur] = "0";
                        }
                    }
                    else if (strpos($s,"NATI"))
                    {
                        $i = strpos($s,"NATI");
                        if (strlen($line) > $i + 5)
                        {
                            $listNati[$cur] = substr($line, $i + 5);
                        }
                    }
                    else if (strpos($s,"OCCU"))
                    {
                        $i = strpos($s,"OCCU");
                        if (strlen($line) > $i + 5)
                        {
                            $listOccu[$cur] = substr($line, $i + 5);
                        }
                    }
                    else if (strpos($s,"EDUC"))
                    {
                        $i = strpos($s,"EDUC");
                        if (strlen($line) > $i + 5)
                        {
                            $listEduc[$cur] = substr($line, $i + 5);
                        }
                    }
                    else if (strpos($s,"RELI"))
                    {
                        $i = strpos($s,"RELI");
                        if (strlen($line) > $i + 5)
                        {
                            $listReli[$cur] = substr($line, $i + 5);
                        }
                    }
                    else if (strpos($s,"BIRT"))
                    {
                        $birt = true;
                        $chan = false;
                        $dead = false;
                        $buri = false;
                        $resi = false;
                        $obje = false;
                        $marr = false;
                    }
                    else if (strpos($s,"CHAN"))
                    {
                        $chan = true;
                        $birt = false;
                        $dead = false;
                        $buri = false;
                        $resi = false;
                        $obje = false;
                        $marr = false;
                    }
                    else if (strpos($s,"DEAT"))
                    {
                        $dead = true;
                        $birt = false;
                        $chan = false;
                        $buri = false;
                        $resi = false;
                        $obje = false;
                        $marr = false;
                    }
                    else if (strpos($s,"BURI"))
                    {
                        $buri = true;
                        $chan = false;
                        $birt = false;
                        $dead = false;
                        $resi = false;
                        $obje = false;
                        $marr = false;
                    }
                    else if (strpos($s,"RESI"))
                    {
                        $resi = true;
                        $chan = false;
                        $birt = false;
                        $dead = false;
                        $buri = false;
                        $obje = false;
                        $marr = false;
                    }
                    else if (strpos($s,"OBJE"))
                    {
                        $obje = true;
                        $birt = false;
                        $chan = false;
                        $dead = false;
                        $buri = false;
                        $resi = false;
                        $marr = false;
                    }
                    else if (strpos($s,"FAMC"))
                    {
                        $i = strpos($s,"FAMC");
                        $indi_famc[$cur] = strNumBetween(substr($s, $i + 5));
                    }
                    else if (strpos($s,"FAMS"))
                    {
                        $i = strpos($s,"FAMS");
                        $indi_fams[$cur] = strNumBetween(substr($s, $i + 5));
                    }
                    else if (strpos($s,"NOTE"))
                    {
                        $i = strpos($s,"NOTE");
                        $ss = trim(substr($s, $i + 4));
                        if (strlen(trim($ss)) > 0)
                        {//проверяю не пустая ли строка
                            $sss = substr($s, $i + 5);
                            if (strpos($sss, "@") > -1)
                            {
                                $indi_note[$cur] = strNumBetween(substr($s, $i + 5));
                            }
                            else
                            {
                                if (strlen($line) > $i + 5)
                                    $notes = substr($line, $i + 5)."\n";
                            }
                        }
                    }
                }
                else if ($fam)
                {
                    if (strpos($s,"HUSB"))
                    {
                        $i = strpos($s,"HUSB");
                        $fatherId = strNumBetween(substr($s, $i + 5));//indi
                    }
                    else if (strpos($s,"WIFE"))
                    {
                        $i = strpos($s,"WIFE");
                        $motherId = strNumBetween(substr($s, $i + 5));//indi
                    }
                    else if (strpos($s,"CHIL"))
                    {
                        $i = strpos($s,"CHIL");
                        $childrId = strNumBetween(substr($s, $i + 5));//indi
                        $b = false;
                        for ($id = 0; $id < count($indi_inx); $id++)
                        {//ищу ребенка в Grid'e
                            if ($indi_id[$id] == $childrId)
                            {
                                $b = true;
                                break;
                            }
                        }
                        if ($b)
                        {
                            $childrInx = $indi_inx[$id];
                            if ($fatherId > -1)
                            {
                                $b = false;
                                for ($id = 0; $id < count($indi_inx); $id++)
                                {//ищу отца в Grid'e
                                    if ($indi_id[$id] == $fatherId)
                                    {
                                        $b = true;
                                        break;
                                    }
                                }
                                if ($b)
                                {
                                    $b = true;//проверяю нет ли такого отца в списке
                                    for ($ind = 0; $ind < count($listFatherId); $ind++)
                                    {
                                        if ($listFChildId[$ind] == $childrInx && $listFatherId[$ind] == $indi_inx[$id])
                                        {
                                            $b = false;
                                            break;
                                        }
                                    }
                                    if ($b)
                                    {
                                        if($listFather[$childrInx] == "")
                                        {
                                            $listFather[$childrInx] = "".($indi_inx[$id]+1);
                                        }else{
                                            $listFather[$childrInx] = ",".($indi_inx[$id]+1);
                                        }

                                        $listFChildId[] = $childrInx;
                                        $listFatherId[] = $indi_inx[$id];
                                    }
                                }
                            }
                            if ($motherId > -1)
                            {
                                $b = false;
                                for ($id = 0; $id < count($indi_inx); $id++)
                                {//ищу мать в Grid'e
                                    if ($indi_id[$id] == $motherId)
                                    {
                                        $b = true;
                                        break;
                                    }
                                }
                                if ($b)
                                {
                                    $b = true;//проверяю нет ли такой матери в списке
                                    for ($ind = 0; $ind < count($listMotherId); $ind++)
                                    {
                                        if ($listMChildId[$ind] == $childrInx && $listMotherId[$ind] == $indi_inx[$id])
                                        {
                                            $b = false;
                                            break;
                                        }
                                    }
                                    if ($b)
                                    {
                                        if($listMother[$childrInx] == "")
                                        {
                                            $listMother[$childrInx] = "".($indi_inx[$id]+1);
                                        }else{
                                            $listMother[$childrInx] = ",".($indi_inx[$id]+1);
                                        }
        
                                        $listMChildId[] = $childrInx;
                                        $listMotherId[] = $indi_inx[$id];
                                    }
                                }
                            }
                        }
                    }
                    else if (strpos($s,"MARR"))
                    {
                        $marr = true;
                        $birt = false;
                        $chan = false;
                        $dead = false;
                        $buri = false;
                        $resi = false;
                        $obje = false;
                    }
                }
                else if ($note && $go_indi)
                {
                    if (strpos($s,"CONT") && strpos($s,"CONT") < 10)
                    {
                        $i = strpos($s,"CONT");
                        if (strlen($line) > $i + 5)
                           $notes .= substr($line, $i + 5)."\n";
                    }
                    else if (strpos($s,"CONC") && strpos($s,"CONC") < 10)
                    {
                        $i = strpos($s,"CONC");
                        if (strlen($line) > $i + 5)
                           $notes .= substr($line, $i + 5);
                    }
                }
            }
            else if (substr($s, 0, 1) == "2")
            {
                if ($indi)
                {
                    if ($birt)
                    {
                        if (strpos($s,"DATE"))
                        {
                            $i = strpos($s,"DATE");
                            $ss = substr($s, $i + 4);
                            if (!empty($ss))
                            {
                                $ss = str_replace("EST", "", $ss);//удаляю EST
                                $ss = str_replace("CIR", "", $ss);//удаляю CIR
                                $ss = str_replace("ABT", "", $ss);//удаляю ABT
                                if (strpos($ss,"BEF"))
                                {
                                    $i = strpos($ss,"BEF");
                                    $sss = substr($ss, $i + 3);
                                    $listBirth[$cur] = $code_gedcom_before + " " + DateFromStr($sss);
                                }
                                else if (strpos($ss,"AFT"))
                                {
                                    $i = strpos($ss,"AFT");
                                    $sss = substr($ss, $i + 3);
                                    $listBirth[$cur] = $code_gedcom_after + " " + DateFromStr($sss);
                                }
                                else if (strpos($ss,"BET"))
                                {
                                    $i = strpos($ss,"BET");
                                    $sss = substr($ss, $i + 3);
                                    if (strpos($sss,"AND"))
                                    {
                                        $i = strpos($sss,"AND");
                                        $ss1 = substr($sss, 1, $i);
                                        $ss2 = substr($ss, $i + 3);
                                        $listBirth[$cur] = $code_gedcom_between + " " + DateFromStr($ss1) + " " + $code_gedcom_and + " " + DateFromStr($ss2);
                                    }
                                    else
                                    {
                                        $listBirth[$cur] = $code_gedcom_between + " " + DateFromStr($sss);
                                    }
                                }
                                else
                                {
                                    $listBirth[$cur] = $ss;
                                }
                            }
                        }
                        else if (strpos($s,"PLAC"))
                        {
                            $i = strpos($s,"PLAC");
                            if (strlen($line) > $i + 5)
                            {
                                $listPlaceb[$cur] = substr($line, $i + 5);
                            }
                            //??birt = false;
                        }
                    }
                    else if ($dead)
                    {
                        if (strpos($s,"DATE"))
                        {
                            $i = strpos($s,"DATE");
                            $ss = substr($s, $i + 4);
                            if (!empty($ss))
                            {
                                $ss = str_replace("EST", "", $ss);//удаляю EST
                                $ss = str_replace("CIR", "", $ss);//удаляю CIR
                                $ss = str_replace("ABT", "", $ss);//удаляю ABT
                                if (strpos($ss,"BEF"))
                                {
                                    $i = strpos($ss,"BEF");
                                    $sss = substr($ss, $i + 3);
                                    $listDeath[$cur] = $code_gedcom_before + " " + DateFromStr($sss);
                                }
                                else if (strpos($ss,"AFT"))
                                {
                                    $i = strpos($ss,"AFT");
                                    $sss = substr($ss, $i + 3);
                                    $listDeath[$cur] = $code_gedcom_after + " " + DateFromStr($sss);
                                }
                                else if (strpos($ss,"BET"))
                                {
                                    $i = strpos($ss,"BET");
                                    $sss = substr($ss, $i + 3);
                                    if (strpos($sss,"AND"))
                                    {
                                        $i = strpos($sss,"AND");
                                        $ss1 = substr($sss, 1, $i);
                                        $ss2 = substr($ss, $i + 3);
                                        $listDeath[$cur] = $code_gedcom_between + " " + DateFromStr($ss1) + " " + $code_gedcom_and + " " + DateFromStr($ss2);
                                    }
                                    else
                                    {
                                        $listDeath[$cur] = $code_gedcom_between + " " + DateFromStr($sss);
                                    }
                                }
                                else
                                {
                                    $listDeath[$cur] = $ss;
                                }
                            }
                        }
                        else if (strpos($s,"PLAC"))
                        {
                            $i = strpos($s,"PLAC");
                            if (strlen($line) > $i + 5)
                            {
                                $listPlaced[$cur] = substr($line, $i + 5);
                            }
                            //??dead = false;
                        }
                    }
                    else if ($buri)
                    {
                        if (strpos($s,"PLAC"))
                        {
                            $i = strpos($s,"PLAC");
                            if (strlen($line) > $i + 5)
                            {
                                $listPlacet[$cur] = substr($line, $i + 5);
                            }
                            //??buri = false;
                        }
                    }
                    else if ($resi)
                    {
                        if (strpos($s,"PLAC"))
                        {
                            $i = strpos($s,"PLAC");
                            if (strlen($line) > $i + 5)
                            {
                                $listPlacel[$cur] = substr($line, $i + 5);
                            }
                            //??resi = false;
                        }
                    }
                    else if ($chan)
                    {
                        if (strpos($s,"DATE"))
                        {
                            $i = strpos($s,"DATE");
                            if (strlen($line) > $i + 5)
                            {
                                $changes = substr($line, $i + 5);
                                $listChange[$cur] = "[".$changes."|]";
                            }
                            //??chan = false;
                        }
                    }
                    else if ($obje)
                    {
                        if (strpos($s,"FILE"))
                        {
                            $i = strpos($s,"FILE");
                            if (strlen($line) > $i + 5)
                            {
                                $ss = substr($line, $i + 4);

                                if (!empty($ss))
                                {
                                    $listIcon[$cur] = substr($ss, 2);
                                }

                                $ss = "";
                            }

                            //??obje = false;
                        }
                    }
                }
                if ($fam)
                {
                    if ($marr)
                    {
                        if (strpos($s,"DATE"))
                        {
                            $i = strpos($s,"DATE");
                            $ss = substr($s, $i + 4);
                            if (!empty($ss))
                            {
                                $ss = str_replace("EST", "", $ss);//удаляю EST
                                $ss = str_replace("CIR", "", $ss);//удаляю CIR
                                $ss = str_replace("ABT", "", $ss);//удаляю ABT
                                if (strpos($ss,"BEF"))
                                {
                                    $i = strpos($ss,"BEF");
                                    $sss = ss.Substring($i + 3);
                                    $sWeddin = $code_gedcom_before + " " + DateFromStr($sss);
                                }
                                else if (strpos($ss,"AFT"))
                                {
                                    $i = strpos($ss,"AFT");
                                    $sss = ss.Substring($i + 3);
                                    $sWeddin = $code_gedcom_after + " " + DateFromStr($sss);
                                }
                                else if (strpos($ss,"BET"))
                                {
                                    $i = strpos($ss,"BET");
                                    $sss = ss.Substring($i + 3);
                                    if (strpos($sss,"AND") != -1)
                                    {
                                        $i = strpos($sss,"AND");
                                        $ss1 = substr($sss, 1, $i);
                                        $ss2 = substr($sss, $i + 3);
                                        $sWeddin = $code_gedcom_between + " " + DateFromStr($ss1) + " " + $code_gedcom_and + " " + DateFromStr($ss2);
                                    }
                                    else
                                    {
                                        $sWeddin = $code_gedcom_between + " " + DateFromStr($sss);
                                    }
                                }
                                else
                                {
                                    $sWeddin = $ss;
                                }
                            }
                        }
                        else if (strpos($s,"PLAC"))
                        {
                            $i = strpos($s,"PLAC");
                            if (strlen($line) > $i + 5)
                                $sPlacew = substr($line, $i + 5);
                        }
                    }
                }
                else
                if (strpos($s,"CONT") && strpos($s,"CONT") < 10 && $go_indi)
                {
                    $i = strpos($s,"CONT");
                    if ($i)
                        if (strlen($line) > $i + 5)
                            $notes .= substr($line, $i + 5)."\n";
                }
                else if (strpos($s,"CONC") && strpos($s,"CONC") < 10 && $go_indi)
                {
                    $i = strpos($s,"CONC");
                    if ($i)
                        if (strlen($line) > $i + 5)
                            $notes .= substr($line, $i + 5);
                }
        
            }
            else if (substr($s, 0, 1) == "3")
            {
                if (strpos($s,"MAP"))
                {
                    $sMapsb = "";
                    $sMapsl = "";
                    $sMapsd = "";
                    $sMapst = "";
                    $sMapsw = "";
                    
                    $maps = true;
                }
                else
                if (strpos($s,"TIME"))
                {
                    if ($chan)
                    {
                        $i = strpos($s,"TIME");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $ch = "[".$changes."|".substr($line, $i + 5)."]";
                                $listChange[$cur] = $ch;

                                $changes = "";
                            }
                    }
                }
        
            }
            else if (substr($s, 0, 1) == "4")
            {
                if ($maps)
                {
                    if ($birt)
                    {
                        $i = strpos($s,"LATI");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapsb = "[".strDelNotNumChrs($line, $i + 5)."";
                                $listMapsb[$cur] = $sMapsb;
                            }
                        $i = strpos($s,"LONG");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapsb .= "|".strDelNotNumChrs($line, $i + 5)."]";
//echo $i." : ".$line."<br>";
//echo $sMapsb."<br>";
                                $listMapsb[$cur] = $sMapsb;

                                $maps = false;
                            }
                    }
                    else if ($dead)
                    {
                        $i = strpos($s,"LATI");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapsd = "[".strDelNotNumChrs($line, $i + 5)."";
                                $listMapsd[$cur] = $sMapsd;
                            }
                        $i = strpos($s,"LONG");
                        if ($i)
                            if (line.Length > $i + 5)
                            {
                                $sMapsd .= "|".strDelNotNumChrs($line, $i + 5)."]";
                                $listMapsd[$cur] = $sMapsd;

                                $maps = false;
                            }
                    }
                    else if ($resi)
                    {
                        $i = strpos($s,"LATI");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapsl = "[".strDelNotNumChrs($line, $i + 5)."";
                                $listMapsl[$cur] = $sMapsl;
                            }
                        $i = strpos($s,"LONG");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapsl .= "|".strDelNotNumChrs($line, $i + 5)."]";
                                $listMapsb[$cur] = $sMapsl;

                                $maps = false;
                            }
                    }
                    else if ($buri)
                    {
                        $i = strpos($s,"LATI");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapst = "[".strDelNotNumChrs($line, $i + 5)."";
                                $listMapst[$cur] = $sMapst;
                            }
                        $i = strpos($s,"LONG");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapst .= "|".strDelNotNumChrs($line, $i + 5)."]";
                                $listMapst[$cur] = $sMapst;

                                $maps = false;
                            }
                    }
                    else if ($marr)
                    {
                        $i = strpos($s,"LATI");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapsw = "[".strDelNotNumChrs($line, $i + 5)."";
                                $listMapsw[$cur] = $sMapsw;
                            }
                        $i = strpos($s,"LONG");
                        if ($i)
                            if (strlen($line) > $i + 5)
                            {
                                $sMapsw .= "|".strDelNotNumChrs($line, $i + 5)."]";
                                $listMapsw[$cur] = $sMapsw;

                                $maps = false;
                            }
                    }
                }
            }
        }
    }
    InsertSpouse($cur);

    // update Note;
    if (!empty($notes))
    {
        if ($fn > -1)
        {
            $listNote[$fn] = $notes;
        }
        else if ($cur > -1)
        {
            $listNote[$cur] = $notes;
        }
    }

///////////////////////////////////////////////////////////////////////
//echo "    // Add fathers <br>";
    for ($i = 0; $i < count($listFatherId); $i++)
    {
        $fathers[$i] = array($listFChildId[$i], $listFatherId[$i]);
    }

//echo "    // Add mothers <br>";
    for ($i = 0; $i < count($listMotherId); $i++)
    {
        $mothers[$i] = array($listMChildId[$i], $listMotherId[$i]);
    }

//echo "    // Add spouses <br>";
    for ($i = 0; $i < count($listSpouseId); $i++)
    {
        $b = true;
        for ($n = 0; $n < count($spouses); $n++)
        {
            if ($spouses[$n][$fldSPOUS1] == $listSChildId[$i] && $spouses[$n][$fldSPOUS2] == $listSpouseId[$i])
            {
                $b = false;
                break;
            }
            if ($spouses[$n][$fldSPOUS1] == $listSpouseId[$i] && $spouses[$n][$fldSPOUS2] == $listSChildId[$i])
            {
                $b = false;
                break;
            }
        }

        if ($b)// если такой пары нет, добавляем
        {
            $sMapsw = $listMapsw[$i];
            $sPlacew = $listPlacew[$i];
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

            $spouses[] = array($listSChildId[$i], $listSpouseId[$i], $listWedding[$i], $sPlacew, $sMapsw);
        }

     }

//echo "    // Add persons count = ".count($listPerson)."<br>";;
//for ($i = 0; $i < count($spouses); $i++) echo "SPOUSE $i: ".$spouses[$i][$fldSPOUS1]." | ".$spouses[$i][$fldSPOUS2]." | ".$spouses[$i][$fldWEDDIN]." | ".$spouses[$i][$fldPLACEW]." | ".$spouses[$i][$fldMAPSW]." |<br>";

    for ($i = 0; $i < count($listPerson); $i++)
    {
	$id_person = $indi_inx[$i]+1;
echo "person = $indi_inx[$i] = $id_person = $listPerson[$i] <br>";

        $sPlaceb = $listPlaceb[$i];
        $p1 = strpos($sPlaceb, "[");
        $p2 = strpos($sPlaceb, "|");
        $p3 = strpos($sPlaceb, "]");
        if ($p1 && $p2 && $p3 && $p1 < $p2 && $p2 < $p3)
        {
            $sMapsb = substr($sPlaceb, $p1, $p3 - $p1 + 1);
            $sPlaceb = substr($sPlaceb, 0, $p1 - 1);
        }
        else
        {
            $sMapsb = $listMapsb[$i];
        }

        $sPlacel = $listPlacel[$i];
        $p1 = strpos($sPlacel, "[");
        $p2 = strpos($sPlacel, "|");
        $p3 = strpos($sPlacel, "]");
        if ($p1 && $p2 && $p3 && $p1 < $p2 && $p2 < $p3)
        {
            $sMapsl = substr($sPlacel, $p1, $p3 - $p1 + 1);
            $sPlacel = substr($sPlacel, 0, $p1 - 1);
        }
        else
        {
            $sMapsl = $listMapsl[$i];
        }

        $sPlaced = $listPlaced[$i];
        $p1 = strpos($sPlaced, "[");
        $p2 = strpos($sPlaced, "|");
        $p3 = strpos($sPlaced, "]");
        if ($p1 && $p2 && $p3 && $p1 < $p2 && $p2 < $p3)
        {
            $sMapsd = substr($sPlaced, $p1, $p3 - $p1 + 1);
            $sPlaced = substr($sPlaced, 0, $p1 - 1);
        }
        else
        {
            $sMapsd = $listMapsd[$i];
        }

        $sPlacet = $listPlacet[$i];
        $p1 = strpos($sPlacet, "[");
        $p2 = strpos($sPlacet, "|");
        $p3 = strpos($sPlacet, "]");
        if ($p1 && $p2 && $p3 && $p1 < $p2 && $p2 < $p3)
        {
            $sMapst = substr($sPlacet, $p1, $p3 - $p1 + 1);
            $sPlacet = substr($sPlacet, 0, $p1 - 1);
        }
        else
        {
            $sMapst = $listMapst[$i];
        }

        $gender = "";
        if (strlen(trim($listGender[$i])) == 0)
        {
            $gender = 0;
        }
        else
        {
            $gender = $listGender[$i];
        }

        $persons[$i] = array
		(
		$indi_inx[$i],
		$id_person,
		$listPerson[$i],
		$gender,
		$listBirth[$i],
		$listDeath[$i],
		$listFather[$i],
		$listMother[$i],
		$listSpouse[$i],
		$sPlaceb,
		$sPlaced,
		$sPlacel,
		$sPlacet,
		$listMapsb[$i],
		$listMapsd[$i],
		$listMapsl[$i],
		$listMapst[$i],
		$listOccu[$i],
		$listNati[$i],
		$listEduc[$i],
		$listReli[$i],
		$listNote[$i],
		$listIcon[$i],
		$listChange[$i]
	);

	// save card
	$jsonPerson = new stdClass(); 
	$jsonPerson->id = $id_person;
	$jsonPerson->gender = $gender;
	$jsonPerson->person = $listPerson[$i];

	$jsonPerson->birthday->date = $listBirth[$i];
	$jsonPerson->birthday->place = $sPlaceb;
	$jsonPerson->birthday->maps = $listMapsb[$i];

	$jsonPerson->deathday->date = $listDeath[$i];
	$jsonPerson->deathday->place = $sPlaced;
	$jsonPerson->deathday->maps = $listMapsd[$i];

	//$jsonPerson->residay->date = "";
	//$jsonPerson->residay->place = $sPlacel;
	//$jsonPerson->residay->maps = "";
        $rpss = array();
        if(!empty($sPlacel)){
           $rpss[] = array("resibeg" => @"", "resiend" => @"", "place" => $sPlacel, "maps" => @"");
           $jsonPerson->residay = $rpss;
        }

	$jsonPerson->burialday->date = "";
	$jsonPerson->burialday->place = $sPlacet;
	$jsonPerson->burialday->maps = "";

//echo "=== $listFather[$i] : listfathers<br>";
	if($listFather[$i] != ""){
	    $idf = -1;
	    $fats = array();
	    $fthrs = explode(",", $listFather[$i]);
	    for ($ii = 0; $ii < count($fthrs); $ii++)
	    {
	      $idf = intval($fthrs[$ii]);
	      $fats[$ii] = array("id" => $idf);
	    }
	    $jsonPerson->fathers = $fats;
	}

//echo "=== $listMother[$i] : listmothers<br>";
	if($listMother[$i] != ""){
	    $idm = -1;
	    $mots = array();
	    $mthrs = explode(",", $listMother[$i]);
	    for ($ii = 0; $ii < count($mthrs); $ii++)
	    {
	      $idm = intval($mthrs[$ii]);
	      $mots[$ii] = array("id" => $idm);
	    }
	    $jsonPerson->mothers = $mots;
	}

//echo "=== $listSpouse[$i] : listspouses<br>";
        $spss = array();
        for ($ii = 0; $ii < count($spouses); $ii++)
        {
           if($spouses[$ii][$fldSPOUS1] == $i){
              $inx_per = 0 + intval($spouses[$ii][$fldSPOUS2]);
              $id_per = $indi_inx[$inx_per] + 1;//$persons[$inx_per][$fldID];
              $spss[] = array("id" => $id_per, "wedding" => $spouses[$ii][$fldWEDDIN], "place" => $spouses[$ii][$fldPLACEW], "maps" => $spouses[$ii][$fldMAPSW]);
//echo "=== spss1 = $i = $inx_per == spss<br>";
              //break;
           }
        }
        for ($ii = 0; $ii < count($spouses); $ii++)
        {
           if($spouses[$ii][$fldSPOUS2] == $i){
              $inx_per = 0 + intval($spouses[$ii][$fldSPOUS1]);
              $id_per = $indi_inx[$inx_per] + 1;//$persons[$inx_per][$fldID];
              $spss[] = array("id" => $id_per, "wedding" => $spouses[$ii][$fldWEDDIN], "place" => $spouses[$ii][$fldPLACEW], "maps" => $spouses[$ii][$fldMAPSW]);
//echo "=== spss2 = $i = $inx_per == spss<br>";
              //break;
           }
        }
        if(count($spss) > 0){
           $jsonPerson->spouses = $spss;
//print_r($spss); echo " == spss<br>";
        }

	$jsonPerson->occupation = $listOccu[$i];
	$jsonPerson->national = $listNati[$i];
	$jsonPerson->education = $listEduc[$i];
	$jsonPerson->religion = $listReli[$i];
	$jsonPerson->notes = $listNote[$i];
	$jsonPerson->icon = $listIcon[$i];

	$timestamp = date('YmdHisu');
	$jsonPerson->stamp->timestamp = $timestamp;
	$jsonPerson->stamp->avtor = $userName;
	$jsonPerson->stamp->datetime = date('Y-m-d H:i:s.u');
	$jsonPerson->stamp->avtorup = "";
	$jsonPerson->stamp->datetimeup = "";

	$jsonPersonvar = json_encode($jsonPerson);
 
	////////////////////////////////////////////////// save
	$number = str_pad($id_person, 6, '0', STR_PAD_LEFT); // "000001"
/*echo "number = ".$number." : ".$jsonPersonvar." : gender = ".$gender."<br>";*/

	// Generate json file
	file_put_contents("cards/$number.card", $jsonPersonvar);
    }
////////////////////////////////////////////////////////////
    $timestamp = date('YmdHisu');
    file_put_contents("timestamp", $timestamp);
////////////////////////////////////////////////////////////
  }

//echo "<br><br><br><br>";
//for ($i = 0; $i < count($listPerson); $i++) echo "PERSON: ".$listBirth[$i].";".$listDeath[$i].";".$listPerson[$i].";".$father.";".$mother.";".$gender.";".$sPlaceb.";".$sPlaced.";".$spouse."<br>";
//for ($i = 0; $i < count($persons); $i++) echo "PERSON: ".$persons[$i][0]."|".$persons[$i][1]."|".$persons[$i][2]."|".$persons[$i][3]."|".$persons[$i][4]."|".$persons[$i][5]."|".$persons[$i][6]."|".$persons[$i][7]."|".$persons[$i][8]."|".$persons[$i][9]."<br>";
//for ($i = 0; $i < count($persons); $i++) echo "PERSONS: ".$persons[$i][$fldINX]."|".$persons[$i][$fldID]."|".$persons[$i][$fldSEX]."|".$persons[$i][$fldPER]."|".$persons[$i][$fldBEG]."|".$persons[$i][$fldEND]."|".$persons[$i][$fldFAT]."|".$persons[$i][$fldMOT]."|".$persons[$i][$fldSPS]."|"."<br>";
//for ($i = 0; $i < count($listFather); $i++) echo "FATHER: ".$listFather[$i]."<br>";
//for ($i = 0; $i < count($listMother); $i++) echo "MOTHER: ".$listMother[$i]."<br>";
//for ($i = 0; $i < count($listSpouse); $i++) echo "SPOUSE: ".$listSpouse[$i]."<br>";
//for ($i = 0; $i < count($fathers); $i++) echo "FATHER: ".$fathers[$i][0]."|".$fathers[$i][1]."<br>";
//for ($i = 0; $i < count($mothers); $i++) echo "MOTHER: ".$mothers[$i][0]."|".$mothers[$i][1]."<br>";
//for ($i = 0; $i < count($spouses); $i++) echo "SPOUSES: ".$spouses[$i][$fldSPOUS1]." | ".$spouses[$i][$fldSPOUS2]." | ".$spouses[$i][$fldWEDDIN]." | ".$spouses[$i][$fldPLACEW]." | ".$spouses[$i][$fldMAPSW]." |<br>";
//for ($i = 0; $i < count($listFChildId); $i++) {echo "CHILDFATHER=".$listFChildId[$i].";".$listFatherId[$i]."<br>";}
//for ($i = 0; $i < count($listMChildId); $i++) {echo "CHILDMOTHER=".$listMChildId[$i].";".$listMotherId[$i]."<br>";}
//for ($i = 0; $i < count($listSpouseId); $i++) {echo "SPOUSEID=".$listSChildId[$i].";".$listSpouseId[$i]."<br>";}
//echo "persons=".count($persons)."<br>";
//echo "fathers=".count($fathers)."<br>";
//echo "mothers=".count($mothers)."<br>";

}


function InsertSpouse()
{
    global $listPerson;
    global $listSpouse;
    global $listWife;
    global $cur;
    global $marr;
    global $sWeddin;
    global $sPlacew;
    global $sMapsw;
    global $fatherId;
    global $motherId;
    global $indi_id;
    global $indi_inx;
    global $listSChildId;
    global $listSpouseId;
    global $listWedding;
    global $listPlacew;
    global $listMapsw;

    if (!$marr) return;

    $ifather = -1;
    $imother = -1;
    $i = array_search($fatherId, $indi_id);//индекс в gedcom
    if ($i > -1)
    {
        $ifather = $indi_inx[$i];//реальный индекс
    }
    else
    {
        $ifather = -1;
    }
    $i = array_search($motherId, $indi_id);//индекс в gedcom
    if ($i > -1)
    {
        $imother = $indi_inx[$i];//реальный индекс
    }
    else
    {
        $imother = -1;
    }

//global $persons;
//global $fldPER;
//echo "=== ".$fatherId.":".$motherId."<br>";
//echo "=== ".$ifather.":".$imother."<br>";
//echo "=== ".$persons[$ifather][$fldPER].":".$persons[$imother][$fldPER]."<br>";
//echo "=== ".$sWeddin.":".$sPlacew.":".$sMapsw."<br>";

    if (($ifather > -1) && ($imother > -1))
    {
        if (!empty($sWeddin) || !empty($sPlacew) || !empty($sMapsw))
        {
            $ss = "/".$sWeddin."/".$sPlacew."/".$sMaps;
        }
        else
        {
            $ss = "";
        }
        // вставляю жену мужчине
        $wife = $listWife[$ifather];
        if ($listPerson[$imother] != $listPerson[$ifather])
        {
//echo "=== InsertSpouse wife ==($wife)<br>";
            if (!empty($wife))
            {
                if (!strpos($wife, $listPerson[$imother]))
                {
                    $listWife[$ifather] = $wife.":".$listPerson[$imother].$ss;

                    $listSChildId[] = $ifather;
                    $listSpouseId[] = $imother;
                    $listWedding[] = $sWeddin;
                    $listPlacew[] = $sPlacew;
                    $listMapsw[] = $sMapsw;
                }
            }
            else
            {
                $listWife[$ifather] = $listPerson[$imother].$ss;

                $listSChildId[] = $ifather;
                $listSpouseId[] = $imother;
                $listWedding[] = $sWeddin;
                $listPlacew[] = $sPlacew;
                $listMapsw[] = $sMapsw;
            }
        }
        // вставляю мужа женщине
        $husband = $listWife[$imother];
        if ($listPerson[$ifather] != $listPerson[$imother])
        {
//echo "=== InsertSpouse husband ==($husband)<br>";
            if (!empty($husband))
            {
                if (!strpos($husband, $listPerson[$ifather]))
                {
                    $listWife[$imother] = $husband.":".$listPerson[$ifather].$ss;

                    $listSChildId[] = $imother;
                    $listSpouseId[] = $ifather;
                    $listWedding[] = $sWeddin;
                    $listPlacew[] = $sPlacew;
                    $listMapsw[] = $sMapsw;
                }
            }
            else
            {
                $listWife[$imother] = $listPerson[$ifather].$ss;

                $listSChildId[] = $imother;
                $listSpouseId[] = $ifather;
                $listWedding[] = $sWeddin;
                $listPlacew[] = $sPlacew;
                $listMapsw[] = $sMapsw;
            }
        }

    }

    $sWeddin = "";
    $sPlacew = "";
    $sMapsw = "";
    $marr = false;

    return;
}

?>
