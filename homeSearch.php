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
		#searchBar{
			padding: 2em 1em;
			color: white;
			background-color: lightgrey;
			text-align: center;
		}
		#searchBar form{
			margin: 0;
		}
		#searchBar input{
			margin: .1em;
		}
		#searchBarText{
			width: 50%;
		}
		.accountContentItemInfo{
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			width: 100%;
		}
		.accountContentFocusInfo{
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-content: center;
		}
		.accountContentFocusInfo h1{
			display: flex;
			flex-direction: row;
			align-items: center;
		}
		.accountContentFocusInfo i{
			margin: .5em;
			font-size: 1.2em;
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
			<a class="contentHeader underlined" id="search" style="left: 66.66%" href="homeSearch.php">
				<h2> Search </h2>
			</a>
		</div>
		
		<div id="content">
			<div id="contentFeed" class="contentSection">
				<div id="searchBar">
					<form name="searchForm">
						<b>Search </b><input type="text" id="searchBarText" name="searchBarText"/>
						<b> in </b>
						<select name="searchCategory">
							<option name="Content" value="Content">Content</option>
							<option name="User" value="User">User</option>
						</select>
						<input type="button" value="Submit" onclick="search()"/>
					</form>
				</div>				
			</div>
			
			<div id="contentFocus" class="contentSection">
				<div id="stickyDiv" style="display:none">
					<div id="contentFocusImgContainer">
						<img class="contentFocusImgVid" id="contentFocusImg" />
						<video controls class="contentFocusImgVid" id="contentFocusVid" style="display:none;">
							<source id="contentFocusVidSource" type="video/mp4"/>
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
							<div class="comment">
								<a href="account.php" class="accountLink"><b>AccountName</b></a>
								<p>Awesome picture!</p>
							</div>
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
		document.body.onload = function(){
			setMenuSize();
			checkForToken();
		}
		
		var searchCategory;
		var searchBarText;
		
		function search(){
			var searchForm = document.forms["searchForm"];
			searchBarText = searchForm["searchBarText"].value;
			searchCategory = searchForm["searchCategory"].value;
			
			clearSearch();
						
			getFeed("reset", null, searchCategory, searchBarText);
		}
		
		var debounce;
		window.onscroll = function(){
			if (!debounce && (window.innerHeight + window.scrollY) >= document.body.offsetHeight) {
				debounce = true;
				getFeed(true, null, searchCategory, searchBarText);
				setTimeout(function(){
					debounce = false;
				}, 1000);
			}
		}
		
		function clearSearch(){
			contentFeed.innerHTML = `<div id="searchBar">
										<form name="searchForm">
											<b>Search </b><input type="text" id="searchBarText" name="searchBarText"/>
											<b> in </b>
											<select name="searchCategory">
												<option name="Content" value="Content">Content</option>
												<option name="User" value="User">User</option>
											</select>
											<input type="button" value="Submit" onclick="search()"/>
										</form>
									</div>`
		}
	</script>
	
	
</body>

</html>