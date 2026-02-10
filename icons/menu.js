var langname = Array()
langname[0] = 'Русский      ';
langname[1] = 'Английский   ';
langname[2] = 'Немецкий     ';
langname[3] = 'Французкий   ';
langname[4] = 'Итальянский  ';
langname[5] = 'Испанский    ';
langname[6] = 'Румынский    ';
langname[7] = 'Португальский';
langname[8] = 'Украинский   ';

function buildLang( langsele ) { 
 document.write( '<form name=lang>' );
 document.write( '<select name="fieldname" onChange="openDir( this.form )" style="background-color: rgb(255,238,255); font-weight: bold">' );
 document.write( '' );
 for (i=0; i< langname.length; i++) {
  if (i==langsele) {
   document.write( '<OPTION value='+langhref[i]+' SELECTED>'+langname[i]+'</OPTION>' );
  } else {
   document.write( '<OPTION value='+langhref[i]+'>'+langname[i]+'</OPTION>' );
  }
 }
 document.write( '</select>' );
 document.write( '</form>' );
} 


function Copyright() { 
 document.write( "<cite><center><font color=black>")
 document.write( "Авторское право &copy; 2005-2023 Дмитрия Конюхова. Все права защищены.")
 document.write( "E-Mail: <a href=mailto:dvpt@narod.ru>dvpt@narod.ru</a><br>")
 document.write( '<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareType="link" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,friendfeed,lj"')
 document.write( "</font></center></cite>")
 document.write( "<hr width=70%>")
}
