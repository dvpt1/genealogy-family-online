<?php

echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

//session_start();

include_once("ccfg.php");
include_once("csub.php");
include_once("cvars.php");

global $questdel;

//_already_logged($_COOKIE);
$user = _check_user($_COOKIE);
//echo print_r($user); echo "<br>";
if($user['id'] != 1) return;
echo $user['name']."<br>";

if(isset($_GET['action'])) {
	//echo "action = ".$_GET['id'].":".$_GET['action']."<br>";
	$c = mysql_query("DELETE FROM cusers WHERE id=".$_GET['id']);
	//echo $c."<br>";
}

?>

<h4><a href="index.php"><img src="icons/ic_menu_home.png"></a></h4>

<script type="text/javascript">
    function confirm_delete() {
        return confirm("<?php echo $questdel; ?>");
    }
</script>

<table cellpadding="10">
<tr>
<td>ID</td>
<td>Name</td>
<td>Pass</td>
<td>FIO</td>
<td>Activation</td>
<td>Status</td>
<td>Access</td>
</tr>

<?php

$result = _check_datausers();

while ($row=mysql_fetch_array($result)){
echo ("<tr>");
echo ("<td>$row[id]</td>");
echo ("<td>$row[name]</td>");
echo ("<td>$row[pass]</td>");
echo ("<td>$row[fio]</td>");
echo ("<td>$row[activation]</td>");
echo ("<td>$row[status]</td>");
echo ("<td>$row[acces]</td>");
echo ("<td><a href=\"cusea.php?name=$row[name]\"><img src=\"icons/ic_menu_edit.png\" height=30 width=30></a></td>");
echo ("<td><a href=\"cadm.php?name=$row[name]&action=delete&id=$row[id]\" onclick='return confirm_delete()'><img src=\"icons/ic_menu_delete.png\" height=30 width=30></a></td>");
echo ("</tr>");
}
echo "</table>";

?>