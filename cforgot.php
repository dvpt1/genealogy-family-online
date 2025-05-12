<?php
echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

include_once("ccfg.php");
include_once("csub.php");
include_once("chtmls.php");
//_already_logged($_COOKIE);

$msg = "";
if(isset($_POST['forgot'])) {
 if ($_POST['user']=="")  { $msg = $forgot1;}
 else if (strpos($_POST['user'],'@')==0 || strpos($_POST['user'],'.'==0)) {
    $msg = $forgot2;}
 if ($msg == "") {
  $user_data = _check_datauser(fm($_POST['user']));
  if($user_data == 0) {
    $msg = $forgot3;
  } else {
    $subject = $forgot4;
    $letter = $forgot5."\n\n".$forgot6.$_POST['user']."\n".$forgot4.": ".$user_data['pass']."\n\n".$forgot7."\n$https\n";
    mail($_POST['user'],$subject,$letter);
    $msg = $forgot8.$_POST['user'];
  }
 }
 $prm1 = $_POST['user'];
 }

//_begin_html($user);
//_forgot_html();
 $msg = $GLOBALS["msg"];
 $prm1 = $GLOBALS["prm1"];
 global $lgn1,$fog1;

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";
 ?>
 <br><br><br><br>
 <center>
 <table width="350" align="center" border="0" cellpadding="2">
 <form action="cforgot.php" method="post">
 <tr><td><?php echo $lgn1; ?></td>
   <td><input type="text" name="user" size="40" value="<?php echo $prm1; ?>"></td>
 </tr>
 <tr><td colspan="2" align="center">
  <input type="submit" name="forgot" value="<?php echo $fog1; ?>">
  </td>
 </tr>
 </form>
 <br><br><br><br>
 </table>
 </center>
 <br>
<?
//_end_html();

?>