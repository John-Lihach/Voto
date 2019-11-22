<html>

<head>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" type="text/css" href="accountStylesheet.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<style>
		#contentContainer{
			flex-direction: column;
			margin-left: 1em;
		}
		.contentSide{
			height: auto;
			width: 100%;
			margin: 0;
		}
		.contentItem{
			width: 35em;
			margin: .5em;
			background-color: darkgrey;
		}
		#contentFeed{
			max-height: none;
			display: flex;
			flex-wrap: wrap;
			padding: 1em;
			align-items: center;
			justify-content: flex-start;
			align-content: flex-start;
		}
		@media only screen and (max-width: 50em){
			.contentSide{
				align-items: center;
			}
			#contentFeed{
				justify-content: center;
			}
			.contentItem{
				width: 100%;
			}
		}
	</style>
</head>

<body>
	<?php include('header.php')?>
	
	<div id="contentContainer">
		<div class="contentSide">
			<h1 id="accountTitle">
				<span><span id="accountTitleSpan"><?php echo($_GET["searchQuery"]); ?></span><i class="material-icons addPerson" onclick="followUser(this)" id="followButton">person_add</i><span>
			</h1>
		</div>
		
		<div class="contentSide">
			<h2>Posted Content</h2>
			<div id="contentFeed" class="contentSection">
			</div>
		</div>
	</div>
	
	<script src="headerScript.js"></script>
	<script src="feedScript.js"></script>
	<script src="followAndLike.js"></script>
	<script>
		var accountName;
	
		document.body.onload = function(){
			setMenuSize();
			checkForToken();
			accountName = document.getElementById("accountTitleSpan").innerHTML;
			getFeed(true, null, null, null, accountName);
			if (sessionToken){
				checkIfFollowing(accountName);
			}
		}
		
		function checkIfFollowing(accountName){
			function checkIfFollowingReturn(xmlhttp){
				var responseObject = JSON.parse(xmlhttp.responseText);
				if (responseObject){
					document.getElementById("followButton").classList.toggle("userFollowing");
				}
			}
			
			var data = "token=" + sessionToken + "&followingUserName=" + accountName;
			var responseObject = ajaxCall("checkIfFollowing.php", data, checkIfFollowingReturn);
		}
		
		var debounce;
		window.onscroll = function(){
			if (!debounce && (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 55) {
				debounce = true;
				getFeed(true, null, null, null, accountName);
				setTimeout(function(){
					debounce = false;
				}, 1000);
			}
		}
		
	</script>
	
</body>

</html>