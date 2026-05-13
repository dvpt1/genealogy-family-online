<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Chat</title>
<style>
#wrapper,#loginform {
    margin: 0 auto;
    padding-bottom: 25px;
    width: 100%;
    border: 1px solid #142e3d;
}
#chatbox {
    font:12px calibry;
    text-align: left;
    margin: 0 auto;
    margin-bottom: 25px;
    padding: 10px;
    height: 270px;
    width: 95%;
    border: 1px solid #0AC875;
    overflow: auto;
}
#usermsg {
    width: 80%;
    border: 1px solid #ACD8F0;
}
#submit {
    width: 60px;
}
.msgchat {
    margin: 0 0 2px 0;   font:12px calibry;
}
</style>

<br>
<?php
  $useremail = $_COOKIE['myfamilytree_username'];
  if(empty($useremail)){
    redirect("clogin.php");
  }
  echo "<b>$useremail</b><br>";
?>
<br>
<div id="wrapper">
<div id="chatbox">
<?php
if (file_exists ( "chat/chat.db" ) && filesize ( "chat/chat.db" ) > 0) {
    $handle = fopen ( "chat/chat.db", "r" );
    $contents = fread ( $handle, filesize ( "chat/chat.db" ) );
    fclose ( $handle );
    
    echo $contents;
}
?>
</div>
<center>
<form name="message" action="">
    <input name="usermsg" type="text" id="usermsg" size="63" />
    <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
    <br><button onclick="clearMessages()">Clear</button>
</form>
</center>
</div>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
// jQuery Document

//If user submits the form
$("#submitmsg").click(function(){
        var clientmsg = $("#usermsg").val();
        $.post("chat/post.php", {text: clientmsg});               
        $("#usermsg").attr("value", "");
        loadChat;
    return false;
});

function loadChat(){       
    var oldscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height before the request
    $.ajax({
        url: "chat/chat.db",
        cache: false,
        success: function(html){       
            $("#chatbox").html(html); //Insert chat into the #chatbox div   
            
            //Auto-scroll           
            var newscrollHeight = $("#chatbox").attr("scrollHeight") - 20; //Scroll height after the request
            if(newscrollHeight > oldscrollHeight){
                $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
            }               
          },
    });
}
function clearMessages() {
    let userResponse = confirm("Are you sure?");
    if (userResponse) {
	var xhr = new XMLHttpRequest();
	xhr.open('POST', 'chat/clr.php', true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.send();
    }
}

setInterval (loadChat, 2500);
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.3/jquery.min.js"></script>
<script type="text/javascript">
