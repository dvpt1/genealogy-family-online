<?php

echo '<meta http-equiv="content-type" content="text/html; charset=UTF-8">';

//session_start();
include_once("ccfg.php");
include_once("csub.php");
include_once("chtmls.php");

//??_already_logged($_COOKIE);

$msg='';
if(!empty($_GET['code']) && isset($_GET['code'])){

	$code = mysql_real_escape_string($_GET['code']);
	$c = mysql_query("SELECT id FROM users WHERE activation='$code'");
	if(mysqli_num_rows($c) > 0){
		$count = mysql_query("SELECT id FROM users WHERE activation='$code' and status='0'");
		if(mysql_num_rows($count) == 1){
			mysql_query("UPDATE users SET status='1' WHERE activation='$code'");
			$msg="Ваш аккаунт активирован"; 
		}else{
			$msg ="Ваш аккаунт уже активирован, нет необходимости активировать его снова.";
		}
	}else{
		$msg ="Неверный код активации. $code";
	}

}
?>

 <br><br>
 <h4><a href="index.php"><=</a></h4>

<?php echo $msg; ?>
