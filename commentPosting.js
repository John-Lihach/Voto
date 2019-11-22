function postCommentReturn(xmlhttp){
	responseObject = JSON.parse(xmlhttp.responseText);
	commentSection.innerHTML += addComment(responseObject);
}

function postComment(contentId){
	if (!sessionToken){
		return;
	}
	var commentForm = document.forms["commentForm"];
	var commentTextArea = commentForm["commentTextArea"];
	var contentId = contentId || document.getElementById("contentFocusTitle").dataset.contentId;
	
	var data = "token=" + sessionToken + "&commentTextArea=" + commentTextArea.value + "&contentId=" + contentId;
	var responseObject = ajaxCall("postComment.php", data, postCommentReturn);
}