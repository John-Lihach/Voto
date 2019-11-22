var feedIndex = 0;
var endOfFeed;
var contentFeed = document.getElementById("contentFeed");
var commentSection = document.getElementById("commentSection");
var contentTable = {};

function addToFeed(responseObject, accountPage){
	var clickFunction;
	var thumbnail;
	if (accountPage){
		clickFunction = `"location.href='content.php?searchQuery=` + responseObject.ContentId + `'"`;
	}
	else{
		clickFunction = `"displayFocus(this)"`;
	}
	if (responseObject.Type == "mp4"){
		thumbnail = `<video id="` + responseObject.ContentId + "Img" + `" class="thumbnail" controls/>
						<source src="` + "uploads/" + responseObject.ContentId + "." + responseObject.Type + `" type="video/mp4" />
					</video>`		
	}
	else{
		thumbnail = `<img id="` + responseObject.ContentId + "Img" + `" src="` + "uploads/" + responseObject.ContentId + "." + responseObject.Type + `" class="thumbnail"/>`
	}
	
	var contentItem = 	`<div class="contentItem" id="` + responseObject.ContentId + "Id" + `" onclick=` + clickFunction + `>
							<div class="contentImgContainer">`
								+ thumbnail +
							`</div>
							<div class="contentItemInfo">
								<h1>` + responseObject.Name + `</h1>
								<h3 id="` + responseObject.ContentId + "Following" + `" class="` + responseObject.UserName + `">` + responseObject.UserName + `</h3>
								<div class="contentItemLikes">
									<i class="material-icons" id="` + responseObject.ContentId + "Liked" + `">favorite</i><b>` + responseObject.Likes + `</b>
								</div>
							</div>
						</div>`
	contentFeed.innerHTML += contentItem;
	if (responseObject.IsLiked){
		document.getElementById(responseObject.ContentId + "Liked").classList.add("userLiked");
	}
	if (responseObject.IsFollowing){
		document.getElementById(responseObject.ContentId + "Following").classList.add("userFollowing");
	}
	let ro = responseObject;
	let contentId = ro.ContentId;
	contentTable[contentId] = {ContentId:contentId, Type:ro.Type, UserName:ro.UserName, Likes:ro.Likes, IsFollowing:ro.IsFollowing, IsLiked:ro.IsLiked, Name:ro.Name};
}

function addToUserFeed(responseObject){
	var contentItem = 	`<div class="accountContentFocusInfo">
							<h1><a href="account.php?searchQuery=` + responseObject.UserName + `" class="accountLink">` + responseObject.UserName + `</a><i class="material-icons addPerson searchFollow" id="` + responseObject.UserName + "Following" + `" onclick="followUser(this)">person_add</i></h1>
							<h3><a href="account.php?searchQuery=` + responseObject.UserName + `" class="accountLink">Visit Profile Page</a></h3>
						</div>`
	contentFeed.innerHTML += contentItem;
	if (responseObject.IsFollowing){
		document.getElementById(responseObject.UserName + "Following").classList.add("userFollowing");
	}
}

function getFeed(indexed, followingOnly, searchCategory, searchQuery, uploadedBy){	
	var data = ""
	if (indexed){
		if (indexed=="reset"){
			feedIndex = 0;
			endOfFeed = false;
		}
		data += "index=" + feedIndex;
	}
	if (endOfFeed){
		return;
	}
	if (sessionToken){
		data += "&token=" + sessionToken
	}
	if (followingOnly){
		data += "&following=" + followingOnly;
	}
	if (searchCategory && searchQuery){
		data +="&searchCategory=" + searchCategory + "&searchQuery=" + searchQuery;
	}
	if (uploadedBy){
		data +="&uploadedBy=" + uploadedBy;
	}

	function getFeedReturn(xmlhttp){
		responseObject = JSON.parse(xmlhttp.responseText);
		if (typeof(responseObject) == "undefined"){
			return;
		}
		if (!searchQuery || searchCategory != "User"){
			for(var i=0; i < responseObject.length; i++){
				addToFeed(responseObject[i], uploadedBy);
			}
		}
		else{
			//user results
			for(var i=0; i < responseObject.length; i++){
				addToUserFeed(responseObject[i]);
			}
		}
		feedIndex += responseObject.length;
		setMenuSize();
		if (responseObject.length == 3){
			var documentScroll = document.body.clientHeight < document.body.scrollHeight; //55
			var contentScroll = contentFeed.clientHeight < contentFeed.scrollHeight;
			if (!contentScroll && !documentScroll){
				getFeed(indexed, followingOnly, searchCategory, searchQuery, uploadedBy);
			}
		}
		else{
			endOfFeed = true;
		}
	}
	var responseObject = ajaxCall("getFeed.php", data, getFeedReturn);
}


function displayFocus(contentItem){
	contentId = contentItem.id.slice(0, -2);
	var contentPiece = contentTable[contentId];
	var stickyDiv = document.getElementById("stickyDiv");
	stickyDiv.style.display = "block";
	
	if (contentPiece.Type == "mp4"){
		document.getElementById("contentFocusVid").innerHTML = `<source src="` + "uploads/" + contentPiece["ContentId"] + "." + contentPiece.Type + `" id="contentFocusVidSource" type="video/mp4" />`
		document.getElementById("contentFocusVid").style.display = "inline-block";
		document.getElementById("contentFocusImg").style.display = "none";
	}
	else{
		document.getElementById("contentFocusImg").src = "uploads/" + contentPiece["ContentId"] + "." + contentPiece.Type;
		document.getElementById("contentFocusVid").style.display = "none";
		document.getElementById("contentFocusImg").style.display = "inline-block";
	}
	
	document.getElementById("contentFocusTitle").dataset.contentId = contentPiece["ContentId"];
	document.getElementById("contentFocusTitle").innerHTML = contentPiece.Name;
	document.getElementById("contentFocusTitleLink").href = "content.php?searchQuery="+contentPiece.ContentId;
	document.getElementById("contentFocusAccountLink").innerHTML = contentPiece.UserName;
	document.getElementById("contentFocusAccountLink").href = "account.php?searchQuery="+contentPiece.UserName;
	if (contentPiece["IsFollowing"]){
		document.getElementById("contentFocusFollowing").classList.add("userFollowing");
	}
	else{
		document.getElementById("contentFocusFollowing").classList.remove("userFollowing");
	}
	if (contentPiece["IsLiked"]){
		document.getElementById("contentFocusLiked").classList.add("userLiked");
	}
	else{
		document.getElementById("contentFocusLiked").classList.remove("userLiked");
	}
	document.getElementById("numberOfLikes").innerHTML = contentPiece.Likes;
	
	//comments
	function getCommentReturn(xmlhttp){
		responseObject = JSON.parse(xmlhttp.responseText);
		responseObject.forEach(function(element){
			commentSection.innerHTML += addComment(element);				
		});
	}
	var data = "contentId=" + contentId;
	commentSection.innerHTML = "";
	var responseObject = ajaxCall("getComments.php", data, getCommentReturn);
}

function addComment(data){
	var comment = 	`<div class="comment">
						<a href="account.php?searchQuery=` + data.UserName + `" class="accountLink"><b>` + data.UserName + `</b></a>
						<p>` + data.CommentText + `</p>
					</div>`
	return comment;
}