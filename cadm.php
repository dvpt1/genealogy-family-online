<?php


//session_start();
include_once("csub.php");
//include_once("chtmls.php");
//_already_logged($_COOKIE);

$user = _check_user($_COOKIE);
//echo print_r($user); echo "<br>";
echo $user['name']."<br>";
if($user['id'] != 1) return;

?>
<h4><a href="index.php"><img src="icons/ic_menu_home.png"></a></h4>

<table cellpadding="10">
<tr>
<td>ID</td>
<td>Name</td>
<td>Pass</td>
<td>FIO</td>
</tr>

<?php

$result = _check_datausers();

while ($row=mysql_fetch_array($result)){
echo ("<tr><td>$row[id]</td>");
echo ("<td>$row[name]</td>");
echo ("<td>$row[pass]</td>");
echo ("<td>$row[fio]</td>");
echo ("<td><a href=\"cuser.php?name=$row[name]\">Edit</a></td></tr>");
}
echo "</table>";

?>