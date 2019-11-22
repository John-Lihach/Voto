function setCookie(name, value, days){
	var date = new Date();
	date.setTime(date.getTime() + (days*24*60*60*1000));
	var expires = "expires=" + date.toUTCString();
	document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

function getCookie(name){
	var name = name + "=";
	var decodedCookie = decodeURIComponent(document.cookie);
	var cookieArray = decodedCookie.split(";");
	for(var i=0; i<cookieArray.length; i++){
		var cookie = cookieArray[i];
		while (cookie.charAt(0) == ' '){
			cookie = cookie.substring(1);
		}
		if (cookie.indexOf(name) == 0){
			return cookie.substring(name.length, cookie.length);
		}
	}
	return "";
}