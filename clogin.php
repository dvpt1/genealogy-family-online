<?php

session_start();
include_once("csub.php");
include_once("chtmls.php");
//_already_logged($_COOKIE);
//$user = _check_user($_COOKIE);

//echo "<br><br><br>clogin<br>";
//echo print_r($user); echo "<br>";
//echo "=id=".$user['id']."<br>";
//echo "=name=".$user['name']."<br>";

//Login();
//function Login()
//{
global $lang;
global $lgn1,$pwd3,$foglgn1,$registr,$fogpwd3,$enter1;

$six_digit_random_number = random_int(100000, 999999);
echo "six_digit_random_number = $six_digit_random_number<br>"; 

$msg = $GLOBALS["msg"];
if ($msg != "") echo "<br><font color='red'><b>$msg</b></font><br>";
echo time()."<br>";

$prm1 = '';
$prm2 = '';
if(isset($_POST['login'])) {

 if ($_POST['user']=="" && $_POST['pass']=="") { $msg = $login1; }
 else if ($_POST['user']=="") { $msg = $login2; }
 else if ($_POST['pass']=="") { $msg = $login3; }
 else if (strpos($_POST['user'],'@')==0 || strpos($_POST['user'],'.'==0))
 { $msg = $login4;  }
 if ($msg == "") { 
  $user_data = _check_database(fm($_POST['user']),fm($_POST['pass']));

  if($user_data == 0) {
    $msg = $login5;
  } else {
    $msg = $user_data.":".$_POST['user'].":".$_POST['pass'];
    _set_cookie($user_data,fm($_POST['rem']),session_id(),fm($_POST['user']));

    mail($_POST['user'], 'Activation TwoFactor', 'TwoFactor Number: '.random_int(100000, 999999));
  } 

 }
 $prm1 = $_POST['user'];
 $prm2 = $_POST['pass'];

 function_alert($msg);
}

//$user = array();
//$user['id'] = 1;
//_begin_html($user);
//_login_html();
//echo '<br><br>'.$lang.$lgn1.$pwd3.$foglgn1.$registr.$fogpwd3.$enter1;
 ?>
 <br><br><br><br>
 <center>
 <form action="clogin.php" method="post">
 <table width="350" align="center" border="0" cellpadding="2">
 <tr><td><?php echo $lgn1; ?></td>
   <td><input type="text" name="user" size="40" value="<?php echo $prm1; ?>"></td>
 </tr>
 <tr><td><?php echo $pwd3; ?></td>
  <td><input type="password" name="pass" size="20" value="<?php echo $prm2; ?>"></td>
 </tr>
 <tr><td colspan="2" align="center">
  <?php echo $foglgn1; ?><input type="checkbox" name="rem" value="1" checked>
  </td>
 </tr>   
 <tr><td colspan="2" align="center">
  <input type="submit" name="login" value="<?php echo $enter1; ?>">
  </td>
 </tr>
 <tr><td colspan="2" align="center">
  <p align="center"><b><a href=cregs.php><?php echo $registr; ?></a></b></p>
  <p align="center"><a href=cforgot.php><?php echo $fogpwd3; ?></a></p>
  </td>
 </tr>
 <tr><td><p><br><?php echo $prm1;?><br><?php echo $prm2;?><br></p></td></tr>
 </table>
 </form>
 </center>
 <br>
<?
//_end_html();
//}

function function_alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

?>