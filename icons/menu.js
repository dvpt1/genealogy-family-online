function buildLang( langsele ) { 
 document.write( '<a href=http://dnadata.online/ru/><IMG src="http://dnadata.online/icons/flag/ru.gif" border=0></a>' );
 document.write( '<a href=http://dnadata.online/en/><IMG src="http://dnadata.online/icons/flag/en.gif" border=0></a>' );
 document.write( '<a href=http://dnadata.online/de/><IMG src="http://dnadata.online/icons/flag/de.gif" border=0></a>' );
 document.write( '<a href=http://dnadata.online/fr/><IMG src="http://dnadata.online/icons/flag/fr.gif" border=0></a>' );
 document.write( '<a href=http://dnadata.online/es/><IMG src="http://dnadata.online/icons/flag/es.gif" border=0></a>' );
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
 document.write( "<SCRIPT>d3('GENEALOGICAL TREE APPS SOFTWARE', 250, 0,'green',35,900,'sans-serif')</SCRIPT>")
} 

