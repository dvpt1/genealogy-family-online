<?php

session_start();
include_once("csub.php");
include_once("chtmls.php");
_already_logged($_COOKIE);

$dir = TRUE;

//Regs();

//_begin_html($user);
//function Regs()
//{

$msg = "";
if(isset($_POST['submit'])) {
 $user_data = _check_datauser(fm($_POST['user']));
 if($user_data == 0) {

$password = md5($_POST['pass']); // encrypted password
$activation = md5($email.time()); // encrypted email+timestamp
$alink = "https://dnadata.online/cact.php?code=$activation";

   _adduser_database(fm($_POST['user']),fm($_POST['pass']),fm($_POST['fio']),fm($_POST['country']),fm($_POST['postcode']),fm($_POST['city']),fm($_POST['address']),fm($_POST['phone']),fm($_POST['http']),fm($_POST['notes']),$activation);
   $msg = $regs1;

echo "<br><br><br><br><br><br>";
echo $_POST['user']."Activation dnadata.online".$alink."<br>";

    mail($_POST['user'],"Activation - DNAdata.Online","$alink");


    $to      = 'dvpt@narod.ru';
    $subject = 'the subject';    
    $message = 'hello';    
    $headers = 'From:'. "\r\n" ."Reply-To:"."\r\n" .'X-Mailer: PHP/'.phpversion();    
    mail($to, $subject, $message, $headers);

//sleep(10);

   //_login_html();
   ///header("Location: clogin.php");
   return 0;
  }
 else {  
   $msg = $regs2;
  }
 }

//_regs_html();
 global $lang;

 $msg = $GLOBALS["msg"];
 global $hello, $txtreg1, $lgnmail, $pwd1, $pwd2, $fio, $country, $post, $city, $adres, $phone, $www, $note, $registr; 

 if ($msg != "") echo "<br><font color='red'><b>$msg</b></font>";
 ?>
 <br><br><br><br>
 <center>
 <form name="adduser" action="cregs.php" method="post">
 <table width="80%" align="left" border="0" cellpadding="2">
  <b><p align="center"><?php echo $hello; ?></p>
  <p align="left"><b><?php echo $txtreg1; ?></b></p>

 <tr><td width="30%"><?php echo $lgnmail; ?><font color=red>*</font>: </td>
  <td width="70%"><input type="text" name="user" size="40"></td>
 </tr>
 <tr><td><?php echo $pwd1; ?><font color=red>*</font>: </td>
  <td><input type="password" name="pass" size="20"></td>
 </tr>
 <tr><td><?php echo $pwd2; ?><font color=red>*</font>: </td>
  <td><input type="password" name="pass1" size="20"></td>
 </tr>
 <tr><td><?php echo $fio; ?></td>
  <td><input type="text" name="fio" size="60"></td>
 </tr>
 <tr><td><?php echo $country; ?></td>
  <td><input type="text" name="country" size="20"></td>
 </tr>
 <tr><td><?php echo $post; ?></td>
  <td><input type="text" name="postcode" size="10"></td>
 </tr>
 <tr><td><?php echo $city; ?></td>
  <td><input type="text" name="city" size="30"></td>
 </tr>
 <tr><td><?php echo $adres; ?></td>
  <td><input type="text" name="address" size="70"></td>
 </tr>
 <tr><td><?php echo $phone; ?></td>
  <td><input type="text" name="phone" size="20"></td>
 </tr>
 <tr><td><?php echo $www; ?></td>
  <td><input type="text" name="http" size="40"></td>
 </tr>
 <tr><td><?php echo $note; ?></td>
  <td><textarea name="notes" rows="5" cols="80"></textarea></td>
 </tr>
 <tr><td colspan="2" align="center">
  <input type="submit" name="submit" value="<?php echo $registr; ?>" onclick="javascript:return checkadduser()">
  </td>
 </tr>
 <tr><td><p><br><br><br></p></td></tr>
 </table>
 </form>
 <br><br><br><br>
 </center>
<?
//_end_html();

?>