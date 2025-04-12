<?php

/* * */
function IdToInx($id)
{
  global $persons;
  global $fldINX;
  global $fldID;

  for ($i = 0; $i < count($persons); $i++)
  {
      if ($id == $persons[$i][$fldID]) return $persons[$i][$fldINX];
  }
  return -1;
}

/* * */
function InxToId($inx)
{
  global $persons;
  global $fldINX;
  global $fldID;

  for ($i = 0; $i < count($persons); $i++)
  {
      if ($inx == $persons[$i][$fldINX]) return $persons[$i][$fldID];
  }
  return 0;
}

/* * */
function getProgenitors()
{
  global $persons;
  global $fldFAT;
  global $fldMOT;
  global $fldPER;

  $progenitors = array();
  for ($i = 0; $i < count($persons); $i++) {
      if (empty($persons[$i][$fldFAT]) && empty($persons[$i][$fldMOT])) {
//echo $persons[$i][$fldPER]."<br>";
         $progenitors[] = $persons[$i];
      }
  }
  return $progenitors;
}

/* * */
function getParentsI($PersonId)
{
  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  $parents = Array();

  $ifathers = getFathers($PersonId);
  for ($i = 0; $i < count($ifathers); $i++)
  {
      $parents[] = $ifathers[$i][1];
  }

  $imothers = getMothers($PersonId);
  for ($i = 0; $i < count($imothers); $i++)
  {
      $parents[] = $imothers[$i][1];
  }

  return $parents;
}

/* * */
function getFathers($PersonId)//Inx
{
  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $persons;
  global $fathers;

  $ifathers = Array();
  for ($i = 0; $i < count($fathers); $i++)
  {
      if ($PersonId == $fathers[$i][$fldCHILD])
      {
          $ifathers[] = $fathers[$i];
      }
  }
  return $ifathers;
}

/* * */
function getMothers($PersonId)//Inx
{
  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $persons;
  global $mothers;

  $imothers = Array();
  for ($i = 0; $i < count($mothers); $i++)
  {
      if ($PersonId == $mothers[$i][$fldCHILD])
      {
          $imothers[] = $mothers[$i];
      }
  }
  return $imothers;
}

/* * */
function getFatherc($FatherId)//Inx
{
  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $persons;
  global $fathers;

  $childrs = Array();
  for ($i = 0; $i < count($fathers); $i++)
  {
      if ($FatherId == $fathers[$i][$fldFATHE])
      {
          $childrs[] = $fathers[$i];
      }
  }
  return $childrs;
}

/* * */
function getMotherc($MotherId)//Inx
{
  global $fldCHILD;
  global $fldFATHE;
  global $fldMOTHE;
  global $persons;
  global $mothers;

  $childrs = Array();
  for ($i = 0; $i < count($mothers); $i++)
  {
      if ($MotherId == $mothers[$i][$fldMOTHE])
      {
          $childrs[] = $mothers[$i];
      }
  }
  return $childrs;
}

/* * */
function getChildrensI($PersonId)
{
  $childerns = Array();

  $ifathers = getFatherc($PersonId);
  for ($i = 0; $i < count($ifathers); $i++)
  {
      $childerns[] = $ifathers[$i][0];
  }

  $imothers = getMotherc($PersonId);
  for ($i = 0; $i < count($imothers); $i++)
  {
      $childerns[] = $imothers[$i][0];
  }

  return $childerns;
}

?>