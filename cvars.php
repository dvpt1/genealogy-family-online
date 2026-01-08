<?php

//const
  $CntCol = 48; // количество колонок

  $timestamp = "";//date('YmdHisu');

//surname	фамилия
//primaryname	фамилия
//firstname	имя
//middlename	отчество

  $fldINX  =  0; // INX
  $fldID   =  1; // ID
  $fldPER  =  2; // ФИО
  $fldSEX  =  3; // Пол
  $fldBEG  =  4; // ПРИШЕЛ
  $fldEND  =  5; // УШЕЛ
  $fldFAT  =  6; // Отец
  $fldMOT  =  7; // Мать
  $fldSPS  =  8; // Муж/жена
  $fldPLB  =  9; // Место рождения
  $fldPLD  = 10; // Место смерти
  //$fldPLL  = 11; // Место жизни
  $fldPLT  = 11; // Место захоронения
  $fldMAPB = 12;
  $fldMAPD = 13;
  //$fldMAPL = 14;
  $fldMAPT = 14;
  $fldOCCU = 15;// род занятий
  $fldNATI = 16;// религия
  $fldEDUC = 17;// образование
  $fldRELI = 18;// религия
  $fldNOTE = 19;
  $fldICON = 20;
  $fldCHAN = 21;

  $fldNULL   = 0; // номер колонки "0"
  $fldCHILD  = 0; // номер колонки "Ребенок"
  $fldPAREN  = 1; // номер колонки "Родитель"
  $fldFATHE  = 1; // номер колонки "Отец"
  $fldMOTHE  = 1; // номер колонки "Мать"
  $fldSORT   = 2; // номер колонки "Sort"
  $fldSPOUS1 = 0; // номер колонки "Супруг/а"
  $fldSPOUS2 = 1; // номер колонки "Супруг/а"
  $fldWEDDIN = 2; // номер колонки date wedding
  $fldPLACEW = 3; // номер колонки place wedding
  $fldMAPSW  = 4; // номер колонки maps wedding

  $fldTIMESTAMP  = 0;
  $fldAVTOR      = 1;
  $fldDATETIME   = 2;
  $fldAVTORUP    = 3;
  $fldDATETIMEUP = 4;

  $gender_neutral = "neutral";
  $gender_male = "Male";
  $gender_female = "Female";

  $rzd1 = ';';
  $rzd2 = ':';
  $rzd3 = '±';
  $rzd4 = '/';
  
  $getfile = "familytree.csv";
  $getdir = "foto/";

  $inx_person = 0;
  $cnt_persons = 0;

  $user = array();
  $users = array();

  $peoples = array();
  $gedcoms = array();
  $persons = array();
  $fathers = array();
  $mothers = array();
  $spouses = array();
  $residences = array();

  $langi = 0;
  $langs = '';
  //$page = '';
  $person = "";
  $gedcom = "";
  $chang = "";
  $page="24";// кол-во на странице
  $cellw="250";// кол-во на странице
  $cellh="250";// кол-во на странице
  $filter = "";

  // массивы GEDCOM
  $listFamilyId = array();
  $listFamily = array();
  $listPerson = array();
  $listBirth = array();
  $listDeath = array();
  $listGender = array();
  $listFather = array();
  $listMother = array();
  $listSpouse = array();
  $listPlaceb = array();
  $listPlaced = array();
  $listPlacet = array();
  $listMapsb = array();
  $listMapsd = array();
  $listMapst = array();
  $listWife = array();
  $listOccu = array();
  $listNati = array();
  $listEduc = array();
  $listReli = array();
  $listNote = array();
  $listFoto = array();
  $listChange = array();
  //
  $indi_inx = array();
  $indi_id = array();
  $indi_famc = array();
  $indi_fams = array();
  $indi_note = array();
  //
  $pfam_id = array();
  $pfam_father = array();
  $pfam_mother = array();
  $pfam_childr = array();
  $pfam_wife = array();
  $pfam_husband = array();
  $pfam_weddin = array();
  $pfam_placew = array();
  $pfam_mapsw = array();
  //
  $pchi_id = array();
  $pchi_childr = array();
  //
  $listFChildId = array();
  $listFatherId = array();
  $listMChildId = array();
  $listMotherId = array();
  $listSChildId = array();
  $listSpouseId = array();
  $listWedding = array();
  $listPlacew = array();
  $listMapsw = array();
  //
  $listLiveId = array();
  $listDatel = array();
  $listPlacel = array();
  $listMapsl = array();
  //
  $go_indi = false;
  $cur = -1;
  $fn = -1;
  $notes = "";
  $maps = false;
  //
  $changes = "";
  $sWeddin = "";
  $sPlacew = "";
  $sMapsw = "";
  //
  $birt = false;
  $dead = false;
  $marr = false;
  $resi = false;
  $buri = false;
  $chan = false;

  $childrId = -1;
  $fatherId = -1;
  $motherId = -1;
  $childrInx = -1;
  $fatherInx = -1;
  $motherInx = -1;
 
  // TMens = record Tree
  $aPerson = array();
  $aFather = array();
  $aMother = array();
  $aSpouse = array();

  $aBougth = array();

  $aX1 = array();
  $aY1 = array();
  $aX2 = array();
  $aY2 = array();
  //end;

  // Константы и типы для постороения древа
  $Bougth = 0;//номер ветви
  $maxX = 0;
  $maxY = 0;
  $XmaxL = 0;
  $YmaxL = 10;
  $XmaxR = 0;
  $YmaxR = 10;
  $iX2 = 0;
  $iY2 = 0;
  $cntL = 0;
  $cntR = 0;
  $curL = 0;
  $curR = 0;
  $LeftRight = true;
  $level = 0;
  $shadow = 5;// тень
  $bH = 80;
  $bW = 230;
  $tH = 65;
  $tW = 220;
  $cH = 35; //80/2
  $cW = 115;//230/2

  //$summary = "";
  //$html = "";

?>
