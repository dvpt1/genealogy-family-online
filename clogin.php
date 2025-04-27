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

//$six_digit_random_number = random_int(100000, 999999);
//echo "six_digit_random_number = $six_digit_random_number<br>"; 

$msg = $GLOBALS["msg"];
if ($msg != "") echo "<br><font color='red'><b>$msg</b></font><br>";
//echo time()."<br>";

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
    $msg = $user_data.":".$_POST['user'].":".$_POST['pass'];

	$Q = mysql_query("SELECT id,status FROM users WHERE name='".$_POST['user']."'");
	if($Q){
		$vars = mysql_fetch_array($Q);
		$status = $vars['status'];
		if($status == 1){
			//$msg="Ваш аккаунт активирован $status"; 
			//$msg="Ваш аккаунт активирован $status".$_POST['user'].":".$user_data['two_factor_code']." ". $_POST['code']; 

			$b = true;
			$twotime = time();
			$user_data = _check_useract(fm($_POST['user']));
			if($user_data == 0) {
				//$msg = $forgot3;
			} else {
				if(trim($user_data['two_factor_code']) == trim($_POST['code'])){
					$b = false;
					_set_cookie($user_data,fm($_POST['rem']),session_id(),fm($_POST['user']));
				}
			}

			if($b){
				$twonumber = random_int(100000, 999999);
				_savetwo_database($_POST['user'], $twonumber, $twotime);
				mail($_POST['user'], 'Activation TwoFactor', 'TwoFactor Number: '.$twonumber);
			}
		}else{
			$msg="Ваш аккаунт не активирован $status"; 

			$password = md5($_POST['pass']); // encrypted password
			$activation = md5($email.time()); // encrypted email+timestamp
			$alink = "https://dnadata.online/cact.php?code=$activation";

			_saveact_database(fm($_POST['user']), $activation);
			//$msg = $regs1;

			echo "<br><br><br><br>";
			echo '<h4><a href="index.php"><img src="icons/ic_menu_home.png"></a></h4>';
			echo $_POST['user']."Activation dnadata.online".$alink."<br>";
			mail($_POST['user'],"Activation - DNAdata.Online","$alink");
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
 <tr><td><?php echo $pwd3; ?></td>
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