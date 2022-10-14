function fHoliday(y,m,d) {
	var rE=fGetEvent(y,m,d), r=null;

	if (m==1&&d==1)
		r=[" Jan 1, "+y+" \n Happy New Year! ",gsAction,"skyblue","red"];
	else if (m==12&&d==25)
		r=[" Dec 25, "+y+" \n Merry X'mas! ",gsAction,"skyblue","red"];
	else if (m==7&&d==1)
		r=[" Jul 1, "+y+" \n Canada Day ",gsAction,"skyblue","red"];
	else if (m==7&&d==4)
		r=[" Jul 4, "+y+" \n Independence Day ",gsAction,"skyblue","red"];
	else if (m==11&&d==11)
		r=[" Nov 11, "+y+" \n Veteran's Day ",gsAction,"skyblue","red"];
	else if (m==1&&d<25) {
		var date=fGetDateByDOW(y,1,3,1);	
		if (d==date) r=[" Jan "+d+", "+y+" \n Martin Luther King, Jr. Day ",gsAction,"skyblue","red"];
	}
	else if (m==2&&d<20) {
		var date=fGetDateByDOW(y,2,3,1);	
		if (d==date) r=[" Feb "+d+", "+y+" \n President's Day ",gsAction,"skyblue","red"];
	}
	else if (m==9&&d<15) {
		var date=fGetDateByDOW(y,9,1,1);	
		if (d==date) r=[" Sep "+d+", "+y+" \n Labor Day ",gsAction,"skyblue","red"];
	}
	else if (m==10&&d<15) {
		var date=fGetDateByDOW(y,10,2,1);	
		if (d==date) r=[" Oct "+d+", "+y+" \n Thanksgiving Day (Canada) ",gsAction,"skyblue","red"];
	}
	else if (m==11&&d>15) {
		var date=fGetDateByDOW(y,11,4,4);	
		if (d==date) r=[" Nov "+d+", "+y+" \n Thanksgiving Day (U.S.) ",gsAction,"skyblue","red"];
	}
	else if (m==5&&d>20) {
		var date=fGetDateByDOW(y,5,5,1);	
		if (d==date) r=[" May "+d+", "+y+" \n Memorial Day ",gsAction,"skyblue","red"];
	}

	
	return rE?rE:r;	
}


