var menuButton = document.getElementById("menuButton");
var menu = document.getElementById("menu");
var accountButton = document.getElementById("accountButton");
var accountWindow = document.getElementById("accountWindow");
var accountHeadingsLogIn = document.getElementById("accountHeadingsLogIn");
var accountHeadingsSignUp = document.getElementById("accountHeadingsSignUp");
var accountContentLogIn = document.getElementById("accountContentLogIn");
var accountContentSignUp = document.getElementById("accountContentSignUp");
var contentContainer = document.getElementById("contentContainer");

function openMenu(){
	menuButton.classList.toggle("menuButtonSelected");
	if(menu.style.display == "inline-block"){
		menu.style.display = "none";
	}
	else{
		menu.style.display = "inline-block";
	}
}

function openAccountInfo(){
	accountButton.classList.toggle("accountButtonSelected");
	if(accountWindow.style.display == "block"){
		accountWindow.style.display = "none";
	}
	else{
		accountWindow.style.display = "block";
	}
}

function openLogIn(){
	accountHeadingsLogIn.style["border-bottom"] = ".25em solid white";
	accountHeadingsSignUp.style["border-bottom"] = "";
	accountContentLogIn.style.display = "block";
	accountContentSignUp.style.display = "none";
}

function openSignUp(){
	accountHeadingsSignUp.style["border-bottom"] = ".25em solid white";
	accountHeadingsLogIn.style["border-bottom"] = "";
	accountContentSignUp.style.display = "block";
	accountContentLogIn.style.display = "none";
}

function setMenuSize(){
	var height = contentContainer.offsetHeight || "calc(100vh - 5em)";
	menu.style.height = height;
}

document.body.onresize = function(){setMenuSize()};