<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<?php
  $useremail = $_COOKIE['myfamilytree_username'];
  if(empty($useremail)){
    redirect("clogin.php");
  }
    
  $text = $_POST['text'];
  $fp = fopen("chat.db", 'a');
  fwrite($fp, "<div class='msgchat'>(".date("g:i A").") <b>".$useremail."</b>: ".stripslashes($text)."<br></div>\n");
  fclose($fp);

?>