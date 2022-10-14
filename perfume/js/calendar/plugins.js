function fOnload() {
	fInitLayer();
}

function popup(url,framename) {	
	var w=parent.open(url,framename,"top=200,left=200,width=400,height=200,scrollbars=1,resizable=1");
	if (w&&url.split(":")[0]=="mailto") w.close();
	else if (w&&!framename) w.focus();
}

gsBottom=(NN4?"":"<DIV class='BottomDiv'>")+"<A class='BottomAnchor' href='javascript:void(0)' onclick='if(this.blur)this.blur();fClearSelected();return false;' onmouseover='return true;'>Clear All</A>"+(NN4?"":"</DIV>");


var _startc,_endc;
function fStartPop(startc,endc) {
  _startc=startc;
  _endc=endc;
  var sd=fParseInput(endc.value); 
  if (!sd) sd=gEnd;
  fPopCalendar(startc, [gBegin,sd,sd]);
}

function fEndPop(startc,endc) {
  _startc=startc;
  _endc=endc;
  var sd=fParseInput(startc.value);
  if (!sd) sd=gBegin; 
  fPopCalendar(endc, [sd,gEnd,sd]);
}

function fClearSelected() { 
  _startc.value="";
  _endc.value="";
  fUpdSelect(0,0,0);
  gRange=[gBegin,gEnd];
  gdBegin=new Date(gBegin[0],gBegin[1]-1,gBegin[2]);
  gdEnd=new Date(gEnd[0],gEnd[1]-1,gEnd[2]);
  fRepaint();
}

var _highlite_background="black";	
var _highlite_fontColor="white";	
var _pop_length=7;	
var _pop_width=80;	

gsCalTitle="fGetCalTitle()";
function fGetCalTitle() {
	return "&nbsp;<a class='PopAnchor' href='javascript:void(0);' onclick='if(this.blur)this.blur();fPopMenu(this,event);return false;'>"+gMonths[gCurMonth[1]-1]+(NN4?" ":"</a> <a id='yearAnchor' class='PopAnchor' href='javascript:void(0)' onclick='fToggleLayer(1,true);fGetById(document,\"yearInput\").focus();return false;'>")+gCurMonth[0]+"</a>";
}
if(NN4)_nn4_css.push("YearBox"); 
giFreeDiv=2;
function fInitLayer() { 
	if (NN4) return;
	var lyr=fGetById(document,"freeDiv1");
	lyr.style.top=(SA?2:IE&&!MAC?0:6)+"px"; lyr.style.left=(SA?63:65)+"px"; lyr.style.border=0;
	fDrawLayer(1,"<input class='YearBox' id='yearInput' value='' maxlength=4 size=4 onkeyup='if(this.value.length==4){if(!isNaN(this.value))fSetCal(this.value,gCurMonth[1],0,true,event);this.select();this.blur()}' onblur='fToggleLayer(1,false);if(SA)this.blur()' onfocus='this.value=gCurMonth[0];this.select()' onclick='this.select()' onselectstart='event.cancelBubble=true'>");
}


function fPopMenu(dc,e) {
	var lyr=NN4?document.freeDiv0:fGetById(document,"freeDiv0");
	var bv=NN4?lyr.visibility=="show":lyr.style.visibility=="visible";
	if (bv) { fToggleLayer(0,false); return; }
	fSetDPop(gCurMonth[0],gCurMonth[1]);
	if (NN4) with (lyr) {
		left=25;
		top=22;
	} else with (lyr.style) {
		left=25+"px";
		top=4+"px";
	}
	fToggleLayer(0,true);
}

var _tmid=null;
function fSetDPop(y,m) {
	var mi=_pop_length;
	var wd=_pop_width;
	var sME=NN4||IE4?"":" onmouseover='fToggleColor(this,0)' onmouseout='fToggleColor(this,1)' ";	
	var padstr="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	var cm=fCalibrate(y,m);
	var a=[NN4||IE4||IE&&MAC?"<table border=1 cellspacing=0 cellpadding=0><tr><td>":"","<div onmouseover='clearTimeout(_tmid)' onmouseout='_tmid=setTimeout(\"fToggleLayer(0,false)\",100)'><table class='PopMenu' border=0 cellspacing=0 cellpadding=0>"];
	if(!fBfRange(cm[0],cm[1]))a.push("<tr><td align='center' class='PopMenuItem' nowrap width=",wd,sME," onclick='fSetDPop(",cm[0],",",cm[1]-mi,")'><a class='PopMenuItem' href='javascript:void(0)' onclick='if(NN4)fSetDPop(",cm[0],",",cm[1]-mi,");return false;'>",padstr,"-",padstr,"</a></td></tr>");
	for (var i=0;i<mi;i++) {
		var lm=fCalibrate(cm[0],cm[1]+i);
		if (!fIsOutRange(lm[0],lm[1]))
			a.push("<tr><td align='center' class='PopMenuItem' nowrap width=",wd,sME," onclick='fToggleLayer(0,false);fSetCal(",lm[0],",",lm[1],",0,true,event);'><a class='PopMenuItem' href='javascript:void(0)' onclick='if(NN4)fSetCal(",lm[0],",",lm[1],",0,true,event);return false;'>",gMonths[lm[1]-1]," ",lm[0],"</a></td></tr>");
	}
	if(!fAfRange(lm[0],lm[1]))a.push("<tr><td align='center' class='PopMenuItem' nowrap width=",wd,sME," onclick='fSetDPop(",cm[0],",",cm[1]+mi,")'><a class='PopMenuItem' href='javascript:void(0)' onclick='if(NN4)fSetDPop(",cm[0],",",cm[1]+mi,");return false;'>",padstr,"+",padstr,"</a></td></tr>")
	a.push("</table></div>",NN4||IE4||IE&&MAC?"</td></tr></table>":"");
	fDrawLayer(0,a.join(''));
}

var _cPair=[];
function fToggleColor(obj,n) {
	if (NN4||IE4) return;
	if (n==0) { 
		_cPair[0]=obj.style.backgroundColor;
		obj.style.backgroundColor=_highlite_background;
		_cPair[1]=obj.firstChild.style.color;
		obj.firstChild.style.color=_highlite_fontColor;
	} else {
		obj.style.backgroundColor=_cPair[0];
		obj.firstChild.style.color=_cPair[1];
	}
}

function fToggleLayer(id,bShow) {
	var lyr=NN4?eval("document.freeDiv"+id):fGetById(document,"freeDiv"+id);
	if (NN4) lyr.visibility=bShow?"show":"hide";
	else lyr.style.visibility=bShow?"visible":"hidden";
}

function fDrawLayer(id,html) {
	var lyr=NN4?eval("document.freeDiv"+id):fGetById(document,"freeDiv"+id);
	if (IE4||IE&&MAC) lyr.style.border="0px";
	if (NN4) with (lyr.document) {
		clear(); open();
		write(html);
		close();
	} else {
		lyr.innerHTML=html+"\n";
	}
}