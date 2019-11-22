function followUser(element){
	var userName;
	function getFollowReturn(xmlhttp){
		element.classList.toggle("userFollowing");
		var usernameInstances = document.getElementsByClassName(userName);
		for(var i=0; i < usernameInstances.length; i++){
			usernameInstances[i].classList.toggle("userFollowing");
		}
	}
	
	var data = "action=follow&token=" + sessionToken;
	
	var contentFocusAccountLink = document.getElementById("contentFocusAccountLink");
	var accountTitleSpan = document.getElementById("accountTitleSpan");
	var accountName = document.getElementById("accountTitleSpan");
	
	if (element.classList.contains("searchFollow")){
		var userName = element.id.slice(0, -9);
	}
	else if (contentFocusAccountLink){
		var userName = contentFocusAccountLink.innerHTML;
	}
	else if (accountTitleSpan){
		var userName = accountTitleSpan.innerHTML;
	}
	else if (accountName){
		var userName = accountName.innerHTML;
	}
	
	data += "&followingUserName=" +  userName;	
	var responseObject = ajaxCall("followAndLike.php", data, getFollowReturn);
}

function likeContent(element){
	var contentId;
	function likeContentReturn(xmlhttp){
		element.classList.toggle("userLiked");
		var feedLikeIcon = document.getElementById(contentId + "Liked");
		if (feedLikeIcon){
			feedLikeIcon.classList.toggle("userLiked");
			if (feedLikeIcon.classList.contains("userLiked")){
				feedLikeIcon.nextSibling.innerHTML = parseInt(feedLikeIcon.nextSibling.innerHTML) + 1
			}
			else{
				feedLikeIcon.nextSibling.innerHTML = parseInt(feedLikeIcon.nextSibling.innerHTML) - 1
			}
		}
		
		var numberOfLikes = document.getElementById("numberOfLikes");
		if (element.classList.contains("userLiked")){
			numberOfLikes.innerHTML = parseInt(numberOfLikes.innerHTML) + 1;
		}
		else{
			numberOfLikes.innerHTML = parseInt(numberOfLikes.innerHTML) - 1;
		}
	}
	
	var data = "action=liked&token=" + sessionToken;
	
	var contentFocusTitle = document.getElementById("contentFocusTitle");
	var contentFocusTitling = document.getElementById("contentFocusTitling");
	
	if (contentFocusTitle){
		contentId = contentFocusTitle.dataset.contentId;
	}
	else if (contentFocusTitling){
		contentId = contentFocusTitling.dataset.contentId;
	}
	
	data += "&contentId=" +  contentId;

	var responseObject = ajaxCall("followAndLike.php", data, likeContentReturn);
}