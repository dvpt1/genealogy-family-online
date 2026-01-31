<?php

function strDelNotNumChar($s)
{
//echo $s."<br>";
    $retVal = "";
    for ($i = 0; $i < strlen($s); $i++)
    {
        $c = substr($s,$i,1);
        if (
            $c == '0' ||
            $c == '1' ||
            $c == '2' ||
            $c == '3' ||
            $c == '4' ||
            $c == '5' ||
            $c == '6' ||
            $c == '7' ||
            $c == '8' ||
            $c == '9'
            )
        {
            $retVal .= $c;
        }
    }
    if (strlen($retVal) <= 0) $retVal = "0";
    return $retVal;
}

function strDelNotNumChr($s)
{
    $retVal = "";
    for ($i = 0; $i < strlen($s); $i++)
    {
        $c = $s[$i];
        if (
            $c == '0' ||
            $c == '1' ||
            $c == '2' ||
            $c == '3' ||
            $c == '4' ||
            $c == '5' ||
            $c == '6' ||
            $c == '7' ||
            $c == '8' ||
            $c == '9' ||
            $c == ',' ||
            $c == '.'
            )
        {
            $retVal .= $c;
        }
    }
    if (strlen($retVal) <= 0) $retVal = "0";
    return $retVal;
}

function strDelNotNumChrs($ss, $nn)
{
    $s = substr($ss, $nn-1);
    $retVal = "";
    for ($i = 0; $i < strlen($s); $i++)
    {
        $c = $s[$i];
        if (
            $c == '0' ||
            $c == '1' ||
            $c == '2' ||
            $c == '3' ||
            $c == '4' ||
            $c == '5' ||
            $c == '6' ||
            $c == '7' ||
            $c == '8' ||
            $c == '9' ||
            $c == ',' ||
            $c == '.'
            )
        {
            $retVal .= $c;
        }
    }
    if (strlen($retVal) <= 0) $retVal = "0";
    return $retVal;
}

function strBetween($s, $c)
{
    $p1 = strpos($s, $c);
    $p2 = strrpos($s, $c);
    if ($p2 > $p1) return substr($s, $p1 + 1, $p2 - 1);
    return $s;
}

function strNumBetween($s)
{
    return strDelNotNumChar(strBetween($s, "@"));
}

function strDeleteAll($s, $c)
{
    $retVal = "";
    for ($i = 0; $i < strlen($s); $i++)
    {
        if ($s[$i] != $c)
        {
            $retVal .= $s[$i];
        }
    }
    return $retVal;
}

function DateFromStr($ss)
{
    $Result = "";
    $dmy = explode(" ", $ss);
    $n = count($dmy);
    $ii = 0;
    if ($n == 1)
    {
        $Result = $dmy[0];
    }
    else if ($n == 2)
    {
        $ii = GetMonth($dmy[0]);
        if ($ii > 9)
        {
            $dmy[0] = $ii;
        }
        else
        {
            $dmy[0] = "0" + ii;
        }
        $Result = DateDMY("01", $dmy[0], $dmy[1], $DateFormat);
    }
    else if (n == 3)
    {
        $ii = GetMonth($dmy[1]);
        if ($ii > 9)
        {
            $dmy[1] = $ii;
        }
        else
        {
            $dmy[1] = "0" + ii;
        }
        $Result = DateDMY($dmy[0], $dmy[1], $dmy[2], $DateFormat);
    }
    else
    {
        $Result = $dmy[0] + $dmy[1] + $dmy[2] + $dmy[3];
    }

    return $Result;
}

function GetMonth($month)
{
    $retVal = 0;
    switch ($month)
    {
        case "JAN":
            $retVal = 1;
            break;
        case "FEB":
            $retVal = 2;
            break;
        case "MAR":
            $retVal = 3;
            break;
        case "APR":
            $retVal = 4;
            break;
        case "MAY":
            $retVal = 5;
            break;
        case "JUN":
            $retVal = 6;
            break;
        case "JUL":
            $retVal = 7;
            break;
        case "AUG":
            $retVal = 8;
            break;
        case "SEP":
            $retVal = 9;
            break;
        case "OCT":
            $retVal = 10;
            break;
        case "NOV":
            $retVal = 11;
            break;
        case "DEC":
            $retVal = 12;
            break;
    }
    return $retVal;
}

FUNCTION DateDMY($D, $M, $Y, $DateFormat)
{
    $Result = "";
    $d_i = strpos($DateFormat, "d");
    $M_i = strpos($DateFormat, "M");
    $y_i = strpos($DateFormat, "y");
    if (($d_i < $M_i) && ($M_i < $y_i))
    {//если ddMMyyyy
        $Result = $D + $DateSeparate + $M + $DateSeparate + $Y;
    }
    else if (($M_i < $d_i) && ($d_i < $y_i))
    {//если MMddyyyy
        $Result = $M + $DateSeparate + $D + $DateSeparate + $Y;
    }
    else if (($y_i < $M_i) && ($M_i < $d_i))
    {//если yyyyMMdd
        $Result = $Y + $DateSeparate + $M + $DateSeparate + $D;
    }
    else if (($y_i < $d_i) && ($d_i < $M_i))
    {//если yyyyddMM
        $Result = $Y + $DateSeparate + $D + $DateSeparate + $M;
    }
    return $Result;
}

/*function validateForm() {
 var x = document.getElementById('sifOS').value;
 if (x == null || x == 0 || x == "0") {
     return false;
 } else {
     document.form.submit();
     window.close();

 }
}*/

//array_sort_by_column($array, 'order');
function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

// * * //
function deleteFile($s, $c)
{
    $retVal = "";
    for ($i = 0; $i < strlen($s); $i++)
    {
        if ($s[$i] != $c)
        {
            $retVal .= $s[$i];
        }
    }
    return $retVal;
}

// * * //
function deleteFolder($folder) {
   if (!is_dir($folder)) {
       return false;
   }
   foreach (scandir($folder) as $item) {
       if ($item === '.' || $item === '..') {
           continue;
       }
       $itemPath = $folder . DIRECTORY_SEPARATOR . $item;
       if (is_dir($itemPath)) {
           deleteFolder($itemPath); // Recursive call for subdirectories
       } else {
           unlink($itemPath); // Delete file
       }
   }
   return rmdir($folder); // Remove the now-empty folder
}
// Usage
//$folder = "path/to/folder_with_contents";
//if (deleteFolder($folder)) {
//   echo "successfully";
//} else {
//   echo "filed";
//}

// Параметр $number - сообщает число символов в пароле
//echo generate_password(intval($_POST['number']));
function generate_password($number)
{
  $arr = array('a','b','c','d','e','f',
               'g','h','i','j','k','l',
               'm','n','o','p','r','s',
               't','u','v','x','y','z',
               'A','B','C','D','E','F',
               'G','H','I','J','K','L',
               'M','N','O','P','R','S',
               'T','U','V','X','Y','Z',
               '1','2','3','4','5','6',
               '7','8','9','0','.',',',
               '(',')','[',']','!','?',
               '&','^','%','@','*','$',
               '<','>','/','|','+','-',
               '{','}','`','~');
  // Генерируем пароль
  $pass = "";
  for($i = 0; $i < $number; $i++)
  {
    // Вычисляем случайный индекс массива
    $index = rand(0, count($arr) - 1);
    $pass .= $arr[$index];
  }
  return $pass;
}

?>
