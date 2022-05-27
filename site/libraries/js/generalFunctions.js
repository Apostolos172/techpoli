
//redirection to page in time 
function redirectionTo_In(url, time)
{
	window.setTimeout(function(){redirectionTo(url);},time);
}

//redirection to page 
function redirectionTo(url){
	window.location.replace(url);
}