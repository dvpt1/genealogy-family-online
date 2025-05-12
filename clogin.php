<?php
echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

session_start();

include_once("ccfg.php");
include_once("csub.php");
include_once("chtmls.php");
//_already_logged($_COOKIE);
//$user = _check_user($_COOKIE);

//Login();
//function Login()
//{
global $https;
global $lang;
global $lgn1,$pwd3,$cod3,$foglgn1,$registr,$fogpwd3,$enter1,$login6,$login7,$login8;

$msg = $GLOBALS["msg"];
if ($msg != "") echo "<br><font color='red'><b>$msg</b></font><br>";

$prm1 = '';
$prm2 = '';
$prm3 = '';
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
    $msg = $login8.$_POST['user'];

	$Q = mysql_query("SELECT id,status FROM users WHERE name='".$_POST['user']."'");
	if($Q){
		$vars = mysql_fetch_array($Q);
		$status = $vars['status'];
		if($status == 1){
			$b = true;
			$twotime = time();
			$user_data = _check_useract(fm($_POST['user']));
			if($user_data == 0) {
				$msg = $login5;
			} else {
				if(trim($user_data['two_factor_code']) == trim($_POST['code'])){
					if($user_data['two_factor_expires_at']+600 > $twotime){//10minut
						$b = false;
			//$msg="Ваш аккаунт активирован $status".$_POST['user'].":".$_POST['pass'].":".$user_data['two_factor_code']." ". $_POST['code']; 
						_set_cookie($user_data,fm($_POST['rem']),session_id(),fm($_POST['user']));
					}else{
						$msg=$login7; 
					}
				}
			}

			if($b){
				$twonumber = random_int(100000, 999999);
				_savetwo_database($_POST['user'], $twonumber, $twotime);
				mail($_POST['user'], 'Activation TwoFactor', 'TwoFactor Number: '.$twonumber);
			}
		}else{
			$msg = $login6; 

			$password = md5($_POST['pass']); // encrypted password
			$activation = md5($email.time()); // encrypted email+timestamp
			$alink = "$https/cact.php?code=$activation";

			_saveact_database(fm($_POST['user']), $activation);
			//$msg = $regs1;

			echo "<br><br><br><br>";
			echo '<h4><a href="index.php"><img src="icons/ic_menu_home.png"></a></h4>';
			echo $_POST['user']."Activation $https".$alink."<br>";
			mail($_POST['user'],"Activation - $https","$alink");
		}
	}

  } 

 }
 $prm1 = $_POST['user'];
 $prm2 = $_POST['pass'];
 $prm3 = $_POST['code'];

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
 <tr><td><?php echo $cod3; ?></td>
  <td><input type="text" name="code" size="10" value="<?php echo $prm3; ?>"></td>
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