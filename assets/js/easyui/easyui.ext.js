if ($.fn.datebox){	
	$.fn.datebox.defaults.editable=false;
	$.fn.datebox.defaults.formatter=function(date) {
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		var d = date.getDate();
		return  y+ '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d);
	};
}

if ($.fn.datetimebox){	
	$.fn.datebox.defaults.editable=false;
	$.fn.datebox.defaults.formatter=function(date) {
		var y = date.getFullYear();
		var m = date.getMonth() + 1;
		var d = date.getDate();
		return  y+ '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d);
	};
	$.fn.datebox.defaults.parser = function(s){
			var ss = s.split('-');
			var y = parseInt(ss[0],10);
			var m = parseInt(ss[1],10);
			var d = parseInt(ss[2],10);
			if (!isNaN(y) && !isNaN(m) && !isNaN(d)){
					return new Date(y,m-1,d);
			} else {
					return new Date();
			}
	};
	
}

function formatURL(value)
{
	return '<a href="'+value+'" target="_blank">'+value+'</a>';
}

function formatStatus(value)
{
	if(value==1)
	{
		return '<img src="'+base_url+'assets/icons/tick.png"/>';
	}
	return '<img src="'+base_url+'assets/icons/cross.png"/>';
}