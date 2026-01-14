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
 document.write( '<b><font color=black>Язык:</font><br></b>' );
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
 document.write( '<a href=https://www.familytree.ru/ru/index.htm><IMG src="https://www.familytree.ru/icons/flag/ru.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/en/index.htm><IMG src="https://www.familytree.ru/icons/flag/en.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/de/index.htm><IMG src="https://www.familytree.ru/icons/flag/de.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/fr/index.htm><IMG src="https://www.familytree.ru/icons/flag/fr.gif" border=0></a><br>' );
 document.write( '<a href=https://www.familytree.ru/it/index.htm><IMG src="https://www.familytree.ru/icons/flag/it.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/es/index.htm><IMG src="https://www.familytree.ru/icons/flag/es.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/ro/index.htm><IMG src="https://www.familytree.ru/icons/flag/ro.gif" border=0></a>' );
 document.write( '<a href=https://www.familytree.ru/pt/index.htm><IMG src="https://www.familytree.ru/icons/flag/pt.gif" border=0></a>' );
} 

var menuname = Array()
menuname[0] = ' FamilyTree   ';
menuname[1] = ' Скриншоты    ';
menuname[2] = ' Описание     ';
menuname[3] = ' Загрузить    ';
menuname[4] = ' Купить       ';
menuname[5] = ' Библиотека   ';
menuname[6] = ' Ссылки       ';
menuname[7] = ' Другое ПО    ';
menuname[8] = ' Новости      ';
menuname[9] = ' Услуги       ';
menuname[10]= ' Фамилии      ';
menuname[11]= ' Карты        ';
menuname[12]= ' Мои доски    ';
menuname[13]= ' Домовой      ';
menuname[14]= ' Шифровальщик ';
menuname[15]= ' Мультибаза   ';
menuname[16]= ' Макрокоманды ';
menuname[17]= ' Списки мест  ';
menuname[18]= ' Справочники  ';
menuname[19]= ' Переписи     ';
menuname[20]= ' Метрики      ';
menuname[21]= ' Книги        ';
menuname[22]= ' Календарь    ';
menuname[23]= ' Церкви Храмы ';
menuname[24]= ' ЗАГС         ';
menuname[25]= ' Конфеденциальность';
menuname[26]= ' GEDCOM       ';

var menuhref = Array()
menuhref[0] = 'https://www.familytree.ru/ru/index.htm';
menuhref[1] = 'https://www.familytree.ru/ru/scrshot.htm';
menuhref[2] = 'https://www.familytree.ru/ru/guide.htm';
menuhref[3] = 'https://www.familytree.ru/ru/download.htm';
menuhref[4] = 'https://www.familytree.ru/ru/buy.htm';
menuhref[5] = 'https://www.familytree.ru/ru/lib.htm';
menuhref[6] = 'https://www.familytree.ru/ru/links.htm';
menuhref[7] = 'https://www.familytree.ru/ru/other.htm';
menuhref[8] = 'https://www.familytree.ru/ru/whatsnew.htm';
menuhref[9] = 'https://www.familytree.ru/ru/service.php';
menuhref[10]= 'https://www.familytree.ru/ru/dbf.htm';
menuhref[11]= 'https://www.familytree.ru/ru/maps.htm';
menuhref[12]= 'https://www.familytree.ru/ru/myboards.htm';
menuhref[13]= 'https://www.familytree.ru/ru/brownie.htm';
menuhref[14]= 'https://www.familytree.ru/ru/cipher.htm';
menuhref[15]= 'https://www.familytree.ru/ru/dbs.htm';
menuhref[16]= 'https://www.familytree.ru/ru/msystem.htm';
menuhref[17]= 'https://www.familytree.ru/ru/place.htm';
menuhref[18]= 'https://www.familytree.ru/ru/addr.htm';
menuhref[19]= 'https://www.familytree.ru/ru/list.htm';
menuhref[20]= 'https://www.familytree.ru/ru/metr.htm';
menuhref[21]= 'https://www.familytree.ru/ru/book.htm';
menuhref[22]= 'https://www.familytree.ru/ru/eventsday.htm';
menuhref[23]= 'https://www.familytree.ru/ru/kult.php';
menuhref[24]= 'https://www.familytree.ru/ru/zags.php';
menuhref[25]= 'https://www.familytree.ru/privacy/privacy_policy.html';
menuhref[26]= 'https://www.familytree.ru/gedcom/index.php';

function buildMenu( menusele ) { 
 document.write( '<b><font color=black>Меню:</font><br></b>' );
 document.write( '<form name=menu>' );
 document.write( '<select name="fieldname" onChange="openDir( this.form )" style="background-color: rgb(255,238,255); font-weight: bold">' );
 document.write( '' );
 for (i=0; i< menuname.length; i++) {
  if (i==menusele) {
   document.write( '<OPTION value='+menuhref[i]+' SELECTED>'+menuname[i]+'</OPTION>' );
  } else {
   document.write( '<OPTION value='+menuhref[i]+'>'+menuname[i]+'</OPTION>' );
  }
 }
 document.write( '</select>' );
 document.write( '</form>' );
 document.write( '<a href=https://www.familytree.ru/ru/tree.htm><img src="https://www.familytree.ru/icons/folders.gif" border=0><b>Карта сайта</b></a></a>' );
} 

function openDir( form ) { 
 var newIndex = form.fieldname.selectedIndex; 
 cururl = form.fieldname.options[ newIndex ].value; 
 window.location.assign( cururl ); 
} 

function ReadFile( filepath ) {
 var fso = new ActiveXObject("Scripting.FileSystemObject");
 var myfile = fso.OpenTextFile( filepath , 1 );
 var s = myfile.ReadAll();
 document.write( s );
 myfile.Close();
} 

/*<SCRIPT>d3("Hello!", 50,15,'red',40,800,'times')</SCRIPT>*/
function d3(text, x, y, tcolor, fsize, fweight, ffamily, zind) {
 if (!text) return null;
 if (!ffamily) ffamily='arial';
 if (!fweight) fweight=800;
 if (!fsize) fsize=36;
 if (!tcolor) tcolor='00aaff';
 if (!y) y=0;
 if (!x) x=0;
 var sd=4, hd=2;
 var xzind="";
 if (zind) xzind=";z-Index:"+zind;
 var xstyle='font-family:'+ffamily+';font-size:'+fsize+';font-weight:'+fweight+';'
 var xstr='<DIV STYLE="position:absolute; top:'+(y+sd)+'; left:'+(x+sd)+xzind+'">'
 xstr+='<P style="'+xstyle+'color:darkred">'+text+'</P></DIV>'
 xstr+='<DIV STYLE="position:absolute; top:'+y+'; left:'+x+xzind+'">'
 xstr+='<P style="'+xstyle+'color:silver">'+text+'</P></DIV>'
 xstr+='<DIV STYLE="position:absolute; top:'+(y+hd)+'; left:'+(x+hd)+xzind+'">'
 xstr+='<P style="'+xstyle+'color:'+tcolor+'">'+text+'</P></DIV>'
 document.write(xstr)
}

function buildLogo() { 
 document.write( "<SCRIPT>d3('Генеалогическое древо семьи', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
 document.write( "<SCRIPT>d3('- FamilyTree -', 350,30,'green',35,800,'times')</SCRIPT>")
} 

function buildLogoDBS() { 
 document.write( "<SCRIPT>d3('Мульти-база данных', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
 document.write( "<SCRIPT>d3('- DBS -', 350,50,'green',25,800,'times')</SCRIPT>")
} 

function buildLogoBoards() { 
 document.write( "<SCRIPT>d3('Мои доски объявлений', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
 document.write( "<SCRIPT>d3('- MyBoards -', 350,50,'green',25,800,'times')</SCRIPT>")
} 

function buildLogoCipher() { 
 document.write( "<SCRIPT>d3('Шифровальщик', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
 document.write( "<SCRIPT>d3('- Cipher -', 350,50,'green',25,800,'times')</SCRIPT>")
} 

function buildLogoBrownie() { 
 document.write( "<SCRIPT>d3('Умный домовой', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
 document.write( "<SCRIPT>d3('- Brownie -', 350,50,'green',25,800,'times')</SCRIPT>")
} 

function buildLogoMSystem() { 
 document.write( "<SCRIPT>d3('Система макрокоманд', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
 document.write( "<SCRIPT>d3('- MacroSystem -', 350,50,'green',25,800,'times')</SCRIPT>")
} 

function buildLogoEvents() { 
 document.write( "<SCRIPT>d3('Календарь семейных событий', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
 document.write( "<SCRIPT>d3('- EventsDay -', 350,50,'green',25,800,'times')</SCRIPT>")
} 

function Copyright() { 
 document.write( "<cite><center><font color=black>")
 document.write( "Авторское право &copy; 2005-2023 Дмитрия Конюхова. Все права защищены.")
 document.write( "E-Mail: <a href=mailto:dvpt@narod.ru>dvpt@narod.ru</a><br>")
 document.write( '<script type="text/javascript" src="//yandex.st/share/share.js" charset="utf-8"></script><div class="yashare-auto-init" data-yashareType="link" data-yashareQuickServices="yaru,vkontakte,facebook,twitter,odnoklassniki,moimir,friendfeed,lj"')
 document.write( "</font></center></cite>")
 document.write( "<hr width=70%>")
}

function view(id){
 window.open(id, "goodsinfo", "width=620, height=480, scrollbars=yes, resizable=yes");
}

function colortxt(color){
 event.srcElement.style.color = color;
}

function MenuLeft() { 
document.write("<div id=\"menu\">")
document.write("<h2>Платформа</h2>")
document.write("<div><a href=\"index.html#START1\">О платформе</a></div>")
document.write("<div><a href=\"mission.html#START1\">Миссия</a></div>")
document.write("<div><a href=\"descript.html#START2\">Описание платформы</a></div>")
document.write("<div><a href=\"descript.html#START3\">Технические требования</a></div>")
document.write("<div class=\"line\"></div>")
document.write("<h2>Установка</h2>")
document.write("<div><a href=\"install.html#INSTALL1\">Скачивание архива</a></div>")
document.write("<div><a href=\"install.html#INSTALL2\">Установка на сайт</a></div>")
document.write("<div><a href=\"install.html#INSTALL2\">Настройки сайта</a></div>")
document.write("<div class=\"line\"></div>")
document.write("<h2>Приложения</h2>")
document.write("<div><a href=\"apps.html#MACOS\">MacOS, iOS</a></div>")
document.write("<div><a href=\"apps.html#ANDROID\">Android</a></div>")
document.write("<div><a href=\"apps.html#WINDOWS\">Windows</a></div>")
document.write("<div class=\"line\"></div>")
document.write("<h2>Документация</h2>")
document.write("<div><a href=\"guide.html#GUIDE1\">Введение</a></div>")
document.write("<div><a href=\"guide.html#GUIDE2\">Список членов семьи</a></div>")
document.write("<div><a href=\"guide.html#GUIDE3\">Создание новой и обновление карточки</a></div>")
document.write("<div><a href=\"guide.html#GUIDE4\">Ввод поля Мать/Отец</a></div>")
document.write("<div><a href=\"guide.html#GUIDE5\">Ввод поля Супруг</a></div>")
document.write("<div class=\"line\"></div>")
document.write("<h2>Лицензия</h2>")
document.write("<div><a href=\"privacy.html#PRIVACY\">Политика конфеденциальности</a></div>")
document.write("<div><a href=\"donate.html#DONATE\">Донаты</a></div>")
document.write("</div>")
}

