<?php
echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

include_once("ccfg.php");
include_once("csub.php");
include_once("chtmls.php");

$msg = "";

if(isset($_GET[name])){
  $user = _check_datauser($_GET[name]);
}
if(isset($_POST[name])){
  $user = _check_datauser($_POST[name]);
}

if(isset($_POST['saveuser'])) {
  _saveadmin_database($user['name'],fm($_POST['fio']),fm($_POST['country']),fm($_POST['postcode']),fm($_POST['city']),fm($_POST['address']),fm($_POST['phone']),fm($_POST['http']),fm($_POST['status']),fm($_POST['access']),fm($_POST['notes']));
  $msg = $user7;
}
if(isset($_POST['savepass'])) {
 if ($_POST['pass'] == "") { $msg = $user1; }
 else if ($_POST['pass'] != $user['pass']) { $msg = $user2; }
 else if ($_POST['pass1'] == "") { $msg = $user3; }
 else if ($_POST['pass2'] == "") { $msg = $user4; }
 else if ($_POST['pass1'] != $_POST['pass2']) { $msg = $user5; }
 if ($msg == "") { 
  _savepass_database($user['name'],$_POST['pass1']);
  $msg = $user6;
  }
 }
 $user = _check_datauser($user['name']);

 $msg = $GLOBALS["msg"];
 global $edtt, $lgnmail, $pwdold, $pwdnew1, $pwdnew2, $pwdizm, $fio, $country, $post, $city, $adres, $phone, $www, $note, $registr, $save, $access, $status; 

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";

 ?>
 <h4><a href="cadm.php"><img src="icons/ic_menu_back.png"></a></h4>

 <form name="adduser" action="cusea.php" method="post">
 <table width="350" border="0" cellpadding="2">
 <b><?php echo $edtt; ?></b>
 <tr><td><?php echo $lgnmail; ?></td>
  <td><input type="text" name="name" size="60" value="<?php echo $user['name']; ?>" readonly></b></td>
 </tr>
 <tr><td><?php echo $fio; ?></td>
  <td><input type="text" name="fio" size="60" value="<?php echo $user['fio']; ?>"></td>
 </tr>
 <tr><td><?php echo $country; ?></td>
  <td><input type="text" name="country" size="20" value="<?php echo $user['country']; ?>"></td>
 </tr>
 <tr><td><?php echo $post; ?></td>
  <td><input type="text" name="postcode" size="10" value="<?php echo $user['postcode']; ?>"></td>
 </tr>
 <tr><td><?php echo $city; ?></td>
  <td><input type="text" name="city" size="30" value="<?php echo $user['city']; ?>"></td>
 </tr>
 <tr><td><?php echo $adres; ?></td>
  <td><input type="text" name="address" size="80" value="<?php echo $user['address']; ?>"></td>
 </tr>
 <tr><td><?php echo $phone; ?></td>
  <td><input type="text" name="phone" size="20" value="<?php echo $user['phone']; ?>"></td>
 </tr>
 <tr><td><?php echo $www; ?></td>
  <td><input type="text" name="http" size="40" value="<?php echo $user['http']; ?>"></td>
 </tr>
 <tr><td><?php echo $status; ?></td>
  <td><input type="text" name="status" size="40" value="<?php echo $user['status']; ?>"></td>
 </tr>
 <tr><td><?php echo $access; ?></td>
  <td><input type="text" name="access" size="40" value="<?php echo $user['acces']; ?>"></td>
 </tr>
 <tr><td><?php echo $note; ?></td>
  <td><textarea name="notes" rows="5" cols="80"><?php echo $user['notes']; ?></textarea></td>
 </tr>
 <tr><td colspan="2" align="center">
  <input type="submit" name="saveuser" value="<?php echo $save; ?>">
  </td>
 </tr>
 <tr><td><p><br><br><br></p></td></tr>
 </table>
 </form>
 
 <p><br><br><br><br></p>
 <?

//_end_html();

?>
