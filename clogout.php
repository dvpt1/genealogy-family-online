<?php
echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

include_once("ccfg.php");
include_once("csub.php");
include_once("chtmls.php");

$user = _check_auth($_COOKIE);
_already_logged($_COOKIE);
_logout_user($_COOKIE);
$user = _check_user($_COOKIE);

echo "<br><br><br><br>";
echo "<h4><a href=\"index.php\"><img src=\"icons/ic_menu_back.png\"></a></h4>";

//echo print_r($user); echo "<br>";
//echo "=id=".$user['id']."<br>";
//echo "=name=".$user['name']."<br>";

//_begin_html($user);
//_logout_html();
//Logout($user);

 global $lang;
 global $do;
 global $error14;
 $msg = $GLOBALS["msg"];

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";

// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
    foreach($cookies as $cookie) {
        $parts = explode('=', $cookie);
        $name = trim($parts[0]);
        setcookie($name, '', time()-1000);
        setcookie($name, '', time()-1000, '/');
    }
}

$user = _check_user($_COOKIE);

//echo "<br><br><br>clogout2<br>";
//echo print_r($user); echo "<br>";
//echo "=id=".$user['id']."<br>";
//echo "=name=".$user['name']."<br>";

//_end_html();

?>