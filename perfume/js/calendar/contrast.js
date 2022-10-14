var gsSplit="/";	
var giDatePos=1;	
var gbPadZero=true;	
var giMonthMode=0;	
var gbShortYear=false;   
var gbAutoPos=true;	
var gbPopDown=true;	
var gbAutoClose=true;	
var gPosOffset=[0,0];	
var gbFixedPos=false;	


var gMonths=["JAN","FEB","MAR","APR","MAY","JUN","JUL","AUG","SEP","OCT","NOV","DEC"];
var gWeekDay=["S","M","T","W","T","F","S"];	

var gBegin=[1980,1,1];	
var gEnd=[2030,12,31];	
var gsOutOfRange="Sorry, you may not go beyond the designated range!";	
var guOutOfRange="bigCross.gif";	

var giFirstDOW=0;	

var gcCalBG="white";	
var guCalBG=null;	
var gcCalFrame="white";	
var gsInnerTable="border=0 cellpadding=1 cellspacing=0";	
var gsOuterTable=NN4?"border=1 cellpadding=3 cellspacing=0":"border=0 cellpadding=0 cellspacing=1";	

var gbHideTop=false;	
var giDCStyle=1;	
var gsCalTitle="gMonths[gCurMonth[1]-1]+' '+gCurMonth[0]";	
var gbDCSeq=true;	
var gsYearInBox="i";	
var gsNavPrev="<IMG id='navPrev' class='MonthNav' src='arrowl.gif' width='18' height='18' border='0' alt='' onmousedown='showPrevMon()' onmouseup='stopShowMon()' onmouseout='stopShowMon();if(this.blur)this.blur()'>";	
var gsNavNext="<IMG id='navNext' class='MonthNav' src='arrowr.gif' width='18' height='18' border='0' alt='' onmousedown='showNextMon()' onmouseup='stopShowMon()' onmouseout='stopShowMon();if(this.blur)this.blur()'>";	

var gbHideBottom=false;	
var gsBottom=(NN4?"":"<DIV class='BottomDiv'>")+"<A class='BottomAnchor' href='javascript:void(0)' onclick='if(this.blur)this.blur();if(!fSetDate(gToday[0],gToday[1],gToday[2]))alert(\"You cannot select today!\");return false;' onmouseover='return true;' >Today</A>"+(NN4?"":"</DIV>");	

var giCellWidth=16;	
var giCellHeight=14;	
var giHeadHeight=16;	
var giWeekWidth=22;	
var giHeadTop=0;	
var giWeekTop=0;	

var gcCellBG="white";	
var gsCellHTML="";	
var guCellBGImg="";	
var gsAction=" ";	
var gsDays="dayNo";	

var giWeekCol=-1;	
var gsWeekHead="#";	
var gsWeeks="weekNo";	

var gcWorkday="black";	
var gcSat="black";	
var gcSatBG=null;	
var gcSun="black";	
var gcSunBG=null;	

var gcOtherDay="gainsboro";	
var gcOtherDayBG=gcCellBG;	
var giShowOther=4+8;	

var gbFocus=true;	
var gcToggle="#D4D0C8";	

var gcFGToday="white";	
var gcBGToday="#800000";	
var guTodayBGImg="";	
var giMarkToday=2; 
var gsTodayTip="Today";	

var gcFGSelected="white";	
var gcBGSelected=gcToggle;	
var guSelectedBGImg="";	
var giMarkSelected=1;	
var gsSelectedTip="";	

var gbBoldAgenda=true;	
var gbInvertBold=false;	
var gbShrink2fit=true;	
var gdSelect=[0,0,0];	
var giFreeDiv=1;	
var gAgendaMask=[-1,-1,gcCellBG,"black",-1,false,null];	

var giResizeDelay=KO3?150:50;	
var gbFlatBorder=false;	
var gbInvertBorder=false;	
var gbShareAgenda=false;	
var gsAgShared="gContainer._cxp_agenda";	
var gbCacheAgenda=false;	
var giShowInterval=250;	
