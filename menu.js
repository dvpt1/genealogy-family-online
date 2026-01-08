<script language="javascript">
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

var langhref = Array()
langhref[0] = 'https://www.familytree.ru/ru/index.htm';
langhref[1] = 'https://www.familytree.ru/en/index.htm';
langhref[2] = 'https://www.familytree.ru/de/index.htm';
langhref[3] = 'https://www.familytree.ru/fr/index.htm';
langhref[4] = 'https://www.familytree.ru/it/index.htm';
langhref[5] = 'https://www.familytree.ru/es/index.htm';
langhref[6] = 'https://www.familytree.ru/ro/index.htm';
langhref[7] = 'https://www.familytree.ru/pt/index.htm';
langhref[8] = 'https://www.familytree.ru/ua/index.htm';

function buildLang( langsele ) { 
 document.write( '<form name=lang>' );
 document.write( '<b><font color=black>Язык:</font></b>' );
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
 document.write( '<a href=https://www.familytree.ru/ru/index.htm><IMG src="https://www.familytree.ru/icons/flag/ru.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/en/index.htm><IMG src="https://www.familytree.ru/icons/flag/en.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/de/index.htm><IMG src="https://www.familytree.ru/icons/flag/de.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/fr/index.htm><IMG src="https://www.familytree.ru/icons/flag/fr.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/it/index.htm><IMG src="https://www.familytree.ru/icons/flag/it.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/es/index.htm><IMG src="https://www.familytree.ru/icons/flag/es.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/ro/index.htm><IMG src="https://www.familytree.ru/icons/flag/ro.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/pt/index.htm><IMG src="https://www.familytree.ru/icons/flag/pt.gif" border=0></a>' );
} 
</script>

<script language="javascript">
function Copyright() { 
 document.write( "<cite><center><font color=black>")
 document.write( "Авторское право &copy; 2005-2023 Дмитрия Конюхова. Все права защищены.")
 document.write( "E-Mail: <a href=mailto:dvpt@narod.ru>dvpt@narod.ru</a><br>")
 document.write( '<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareType="link" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,friendfeed,lj"')
 document.write( "</font></center></cite>")
 document.write( "<hr width=70%>")
}
</script>

