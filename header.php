<script src="cookieHandling.js"></script>
<script>
	var sessionToken;
	
	function toggleLoggedInDisplay(status){
		var accountButton = document.getElementById("accountButton");
		if (status){
			accountButton.innerHTML = "Log-out";
			accountButton.onclick = function() {logout();};
		}
		else{
			accountButton.innerHTML = "Log-in";
			accountButton.onclick = function() {openAccountInfo()};
		}
	}
	
	function checkForToken(){
		var tokenCookie = getCookie("token");
		if (tokenCookie != ""){
			sessionToken = tokenCookie;
			toggleLoggedInDisplay(true);
		}
	}
	
	function signupReturn(xmlhttp){
		if (JSON.parse(xmlhttp.responseText)){
			signupMessage.innerHTML = "Successfully Created Account";
		}
		else{
			signupMessage.innerHTML = "Username Already Taken!";
		}
	}
	
	function signup(username, password){
		var signupForm = document.forms["signupForm"];
		var usernameField = signupForm["usernameInput"];
		var passwordField = signupForm["passwordInput"];
		var signupMessage = document.getElementById("signupMessage");
		
		if (usernameField.value != "" && passwordField.value != ""){
			var data = "username=" + usernameField.value  + "&password=" + passwordField.value;
			var responseObject = ajaxCall("signup.php", data, signupReturn);
		}
	}
	
	function login(username, password){
		var loginForm = document.forms["loginForm"];
		var usernameField = loginForm["usernameInput"];
		var passwordField = loginForm["passwordInput"];
		
		function loginReturn(xmlhttp){
			var responseObject = JSON.parse(xmlhttp.responseText);
			if (responseObject.success){
				setCookie("token", responseObject.token, 365);
				sessionToken = responseObject.token;
				toggleLoggedInDisplay(true);
				openAccountInfo();
				location.reload();
			}
			else{
				var loginMessage = document.getElementById("loginMessage");
				loginMessage.innerHTML = "Error: Wrong Username/Password";
			}
		}
		
		if (usernameField.value != "" && passwordField.value != ""){
			var data = "username=" + usernameField.value  + "&password=" + passwordField.value;
			var responseObject = ajaxCall("login.php", data, loginReturn);
		}
	}
	
	function logout(){
		function empty(){}
		ajaxCall("logout.php", sessionToken, empty);
		document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
		sessionToken = null;
		toggleLoggedInDisplay();
		location.reload();
	}
	
	function ajaxCall(filename, data, returnFunction){
		var xmlhttp;
		xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function(){
			if (this.readyState == 4 && this.status == 200){
				returnFunction(this);
			}
		};
		xmlhttp.open("POST", filename, true);
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send(data);
	}
</script>

<div id="accountWindow">
	<div id="accountHeadingsContainer">
		<h2 id="accountHeadingsLogIn" style="border-bottom: .25em solid white" onclick="openLogIn()"> Log-in </h2>
		<h2 id="accountHeadingsSignUp" onclick="openSignUp()"> Sign-up </h2>
	</div>
	<div id="accountContentContainer">
		<div id="accountContentLogIn" class="accountContent">
			<form class="accountForm" name="loginForm">
				<div class="inputContainer">
					Username <input type="text" name="usernameInput" id="loginUsernameInput"/>
				</div>
				<div class="inputContainer">
					Password <input type="password" name="passwordInput" id="loginPasswordInput"/>
				</div>
				<input type="button" value="Log-in" class="submitButton" onclick="login()"/>
			</form>
			</br>
			<p id="loginMessage"></p>
		</div>
		<div id="accountContentSignUp" class="accountContent" style="display:none" >
			<form class="accountForm" name="signupForm">
				<div class="inputContainer">
					Username <input type="text" name="usernameInput" id="signupUsernameInput"/>
				</div>
				<div class="inputContainer">
					Password <input type="password" name="passwordInput" id="signupPasswordInput"/>
				</div>
				<input type="button" value="Sign-up" class="submitButton" onclick="signup()"/>
			</form>
			</br>
			<p id="signupMessage"></p>
		</div>
	</div>
</div>

<div id="header">
	<div id="titleBar">
		<h1> Voto </h1>
	</div>
	
	<div id="menuButton" class="menuButton" onclick="openMenu()">
	</div>
	
	<div id="accountButton" class="accountButton" onclick="openAccountInfo()">
		Log-in
	</div>
</div>

<div id="menuContainer">
	<div id="menu" style="display: none">
		<a href="index.php" id="homeLink">Home</a>
		<a href="yourAccount.php" id="accountLink">Profile Page</a>
		<a href="aboutUs.php" id="aboutLink">About Us</a>
		<a href="contactUs.php" id="contactLink">Contact Us</a>
	</div>
</div>