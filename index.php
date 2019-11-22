<html>

<head>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<style>
		.underlined{
			border-bottom: 3px solid white;
		}
		#homeLink{
			border-left: 5px solid white;
			font-weight: bold;
		}
	</style>
</head>

<body>
	<?php include('header.php')?>
	
	<div id="contentContainer">
		<div id="contentHeaders">
			<a class="contentHeader" id="popular" href="index.php">
				<h2> Popular </h2>
			</a>
			<a class="contentHeader" id="following" style="left: 33.33%" href="index.php?type=following">
				<h2> Following </h2>
			</a>
			<a class="contentHeader" id="search" style="left: 66.66%" href="homeSearch.php">
				<h2> Search </h2>
			</a>
		</div>
		
		<div id="content">
			<div id="contentFeed" class="contentSection">
			</div>
			
			<div id="contentFocus" class="contentSection">
				<div id="stickyDiv" style="display:none">
					<div id="contentFocusImgContainer">
						<img class="contentFocusImgVid" id="contentFocusImg" />
						<video class="contentFocusImgVid" id="contentFocusVid" style="display:none;" controls>
						</video>
					</div>
					<div id="contentFocusInfo">
						<div id="contentFocusTitling">
							<a id="contentFocusTitleLink" style="text-decoration:none; color:inherit;"><h1 id="contentFocusTitle">Content Title</h1></a>
							<div id="contentFocusAccount">
								<h3><a href="account.php" class="accountLink" id="contentFocusAccountLink">Account Name</a></h3>
								<i class="material-icons addPerson" id="contentFocusFollowing" onclick="followUser(this)">person_add</i>
							</div>
						</div>
						<div id="contentFocusLikes">
							<i class="material-icons" id="contentFocusLiked" onclick="likeContent(this)">favorite</i>
							<div id="numberOfLikes">100</div>
						</div>
					</div>
					<hr/>
					<div class="commentContainer" id="commentContainer">
						<h3>Comments</h3>
						<form id="commentForm" name="commentForm">
							<textarea id="commentTextArea" name="commentTextArea"></textarea>
							<input type="button" value="Submit" class="submitButton" onclick="postComment()"/>
						</form>
						<div id="commentSection">
						</div>
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
		var url = window.location.href;
		url = new URL(url);
		var type = url.searchParams.get("type");
		
		document.body.onload = function(){
			checkForToken();
			if (type == "following"){
				document.getElementById("following").classList.add("underlined");
				getFeed(true, true);
			}
			else{
				document.getElementById("popular").classList.add("underlined");
				getFeed(true);
			}
		}
		
		var debounce;
		window.onscroll = function(){
			if (!debounce && (window.innerHeight + window.scrollY) >= document.body.offsetHeight - 55) {
				debounce = true;
				if (type == "following"){
					document.getElementById("following").classList.add("underlined");
					getFeed(true, true);
				}
				else{
					document.getElementById("popular").classList.add("underlined");
					getFeed(true);
				}
				setTimeout(function(){
					debounce = false;
				}, 1000);
			}
		}
	</script>
	
</body>

</html>