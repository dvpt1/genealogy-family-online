<?php
  $useremail = $_COOKIE['myfamilytree_username'];
  if(empty($useremail)){
    redirect("clogin.php");
  }

  $fp = fopen("chat.db", 'w');
  fwrite($fp, "");
  fclose($fp);
?>