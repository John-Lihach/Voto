<html>

<head>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" type="text/css" href="accountStylesheet.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<style>
		#contentContainer{
			max-height: calc(100% - 5em);
		}
		#mainColumn{
			margin-top: 10px;
			display: flex;
			flex-direction: column;
			width: 70%;
		}
		#contentFocusInfo{
			padding: 1em;
			height: 4em;
		}
		#contentFocusTitling h1{
			margin: 0;
		}
		#imgArea{
			height: calc(100% - 5em);
			width: 100%;
			overflow: hidden;
			display: flex;
			flex-direction: row;
			justify-content: center;
			align-items: center;
		}
		.imgAreaImgVid{
			width: auto;
			height: 100%;
		}
		#commentColumn{
			margin-left: 1em;
			width: 30%;
			max-height: calc(95vh - 5em);
			overflow-y: auto;
			
		}
		#commentSection{
			max-height: none;
			height: 100%;
			width: 100%;
			overflow-y: auto;
			background-color: rgb(120,120,120);
		}
		@media only screen and (max-width: 50em){
			#contentContainer{
				max-height: none;
				margin: .2em;
			}
			#mainColumn{
				width: 100%;
			}
			#imgArea{
				height: auto;
				overflow: display;
			}
			#imgArea img{
				width: 100%;
				height: auto;
			}
			#commentColumn{
				margin: 0;
				width: auto;
				max-height: none;
			}
		}
	</style>
</head>

<body>
	<?php include('header.php')?>
	
	<div id="contentContainer">
		<div id="mainColumn">
			<div id="imgArea">
				<img id="imgImg" class="imgAreaImgVid"/>
				<video controls class="imgAreaImgVid" id="vidVid" style="display:none;">
					<source id="vidVidSource" type="video/mp4"/>
				</video>
			</div>
			<div id="contentFocusInfo">
				<div id="contentFocusTitling">
					<h1 id="contentTitle">Content Title</h1>
					<div id="contentFocusAccount">
						<h3><a href="account.php" class="accountLink" id="accountName">Account Name</a></h3>
						<i class="material-icons addPerson" id="followingButton" onclick="followUser(this)">person_add</i>
					</div>
				</div>
				<div id="contentFocusLikes">
					<i class="material-icons" id="likeButton" onclick="likeContent(this)">favorite</i>
					<div id="numberOfLikes">100</div>
				</div>
			</div>
		</div>
		
		<div id="commentColumn">
			<h2>Comments</h2>
			<div class="commentContainer">
				<form id="commentForm" name="commentForm">
					<textarea id="commentTextArea" name="commentTextArea"></textarea>
					<input type="button" value="Submit" class="submitButton" id="commentSubmit" onclick="postComment()"/>
				</form>
				<div id="commentSection">
					<div class="comment">
						<a href="account.php" class="accountLink"><b>AccountName</b></a>
						<p>Awesome picture!</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<script src="headerScript.js"></script>
	<script src="feedScript.js"></script>
	<script src="commentPosting.js"></script>
	<script src="followAndLike.js"></script>
	
	<script>
		document.body.onload = function(){
			setMenuSize();
			checkForToken();
			setupPage();
			setupComments();
		}
		
		var url = window.location.href;
		url = new URL(url);
		var searchQuery = url.searchParams.get("searchQuery");
		document.getElementById("commentSubmit").onclick = function(){postComment(searchQuery)};
		document.getElementById("contentFocusTitling").dataset.contentId = searchQuery;
		
		function setupPage(){			
			function setupPageReturn(xmlhttp){
				responseObject = JSON.parse(xmlhttp.responseText)[0];
				
				if (responseObject.Type == "mp4"){
					document.getElementById("vidVid").innerHTML = `<source src="` + "uploads/" + responseObject["ContentId"] + "." + responseObject.Type + `" id="vidVidSource" type="video/mp4" />`
					document.getElementById("vidVid").style.display = "inline-block";
					document.getElementById("imgImg").style.display = "none";
				}
				else{
					document.getElementById("imgImg").src = "uploads/" + responseObject.ContentId + "." + responseObject.Type;
					document.getElementById("vidVid").style.display = "none";
					document.getElementById("imgImg").style.display = "inline-block";
				}
				
				document.getElementById("contentTitle").innerHTML = responseObject.Name;
				document.getElementById("accountName").innerHTML = responseObject.UserName;
				document.getElementById("accountName").href = "account.php?searchQuery="+responseObject.UserName;
				document.getElementById("numberOfLikes").innerHTML = responseObject.Likes;
				if (responseObject.IsLiked){
					document.getElementById("likeButton").classList.add("userLiked");
				}
				if (responseObject.IsFollowing){
					document.getElementById("followingButton").classList.add("userFollowing");
				}
			}
			
			data = "contentId=" + searchQuery;
			if (sessionToken){
				data +=  "&token=" + sessionToken;
			}
			var responseObject = ajaxCall("getFeed.php", data, setupPageReturn);
		}
		
		function setupComments(){
			function getCommentReturn(xmlhttp){
				responseObject = JSON.parse(xmlhttp.responseText);
				responseObject.forEach(function(element){
					commentSection.innerHTML += addComment(element);				
				});
			}
			commentSection.innerHTML = ""
			
			var data = "contentId=" + searchQuery;
			var responseObject = ajaxCall("getComments.php", data, getCommentReturn);
		}
	</script>
	
</body>

</html>