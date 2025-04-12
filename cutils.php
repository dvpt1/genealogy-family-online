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

?>
