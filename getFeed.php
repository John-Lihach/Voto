<?php	
	$host = "localhost";
	$user = "root";
	$password = "";
	$db = "Voto";
	
	$dbConn = mysqli_connect($host, $user, $password, $db);
	
	function getUserIdFromToken($dbConn, $token){
		$idSql = "SELECT UserId FROM Token WHERE TokenKey='$token' LIMIT 1";
		$idResult = mysqli_query($dbConn, $idSql);
		while ($rows = mysqli_fetch_assoc($idResult)){
			return $rows["UserId"];
		}
	}
	
	function getUserIdFromName($dbConn, $userName){
		$idSql = "SELECT UserId FROM User WHERE Name='$userName' LIMIT 1";
		$idResult = mysqli_query($dbConn, $idSql);
		while ($rows = mysqli_fetch_assoc($idResult)){
			return $rows["UserId"];
		}
	}
		
	function getAccountName($dbConn, $userId){
		$nameSql = "SELECT Name FROM User WHERE UserId='$userId' LIMIT 1";
		$nameResult = mysqli_query($dbConn, $nameSql);
		while ($rows = mysqli_fetch_assoc($nameResult)){
			return $rows["Name"];
		}
	}
	
	function getIsFollowing($dbConn, $userId, $secondUserId){
		$followingSql = "SELECT UserId FROM Following WHERE UserId='$userId' AND FollowingUserId='$secondUserId' LIMIT 1";
		$followingResult = mysqli_query($dbConn, $followingSql);
		if (mysqli_num_rows($followingResult) > 0){
			return true;
		}
		return false;
	}
	
	function getIsLiked($dbConn, $userId, $contentId){
		$likedSql = "SELECT UserId FROM Likes WHERE UserId='$userId' AND ContentId='$contentId' LIMIT 1";
		$likedResult = mysqli_query($dbConn, $likedSql);
		if (mysqli_num_rows($likedResult) > 0){
			return true;
		}
		return false;
	}
	
	function getFollowing($dbConn, $userId){
		$conditions = array();
		$followSql = "SELECT FollowingUserId FROM Following WHERE UserId='$userId'";
		$followResult = mysqli_query($dbConn, $followSql);
		while ($rows = mysqli_fetch_assoc($followResult)){
			array_push($conditions, $rows["FollowingUserId"]);
		}
		return $conditions;
	}
	
	$token;
	if (isset($_POST['token'])){
		$token = $_POST['token'];	
	}
	$index = 0;
	$maxIndex = 0;
	if (isset($_POST['index'])){
		$index = $_POST['index'];
		$maxIndex = $index + 3;		
	}
	$onlyFollowing;
	if (isset($_POST['following'])){
		$onlyFollowing = $_POST['following'];	
	}
	$searchCategory;
	$searchQuery;
	if (isset($_POST['searchCategory'])){
		$searchCategory = $_POST['searchCategory'];
		$searchQuery = $_POST['searchQuery'];	
	}
	$uploadedBy;
	if (isset($_POST['uploadedBy'])){
		$uploadedBy = $_POST['uploadedBy'];
		if ($uploadedBy != "self"){
			$uploadedBy = getUserIdFromName($dbConn, $uploadedBy);
		}
	}
	$UserId = null;
	if (!empty($token)){
		$UserId = getUserIdFromToken($dbConn, $token);
		if (!empty($uploadedBy) && $uploadedBy == "self"){
			$uploadedBy = $UserId;
		}
	}
	$contentId;
	if (isset($_POST['contentId'])){
		$contentId = $_POST['contentId'];	
	}
	
	
	$sql = "SELECT * FROM Content WHERE Date(Date)=CURDATE() ORDER BY Likes DESC LIMIT $index,$maxIndex";
	if (!empty($onlyFollowing) && isset($UserId)){
		$conditions = getFollowing($dbConn, $UserId);
		$sql = "SELECT * FROM Content WHERE UserId IN(".implode(',', $conditions).") ORDER BY Date DESC LIMIT $index,$maxIndex";
	}
	elseif (!empty($onlyFollowing) && !isset($UserId)){
		mysqli_close($dbConn);
		exit();
	}
	elseif (!empty($searchCategory) && !empty($searchQuery)){
		if ($searchCategory == "Content"){
			$sql = "SELECT * FROM Content WHERE Name RLIKE '$searchQuery' LIMIT $index,$maxIndex";
		}
		else{
			$sql = "SELECT UserId FROM User WHERE Name RLIKE '$searchQuery' LIMIT $index,$maxIndex";
		}
	}
	elseif (!empty($uploadedBy)){
		$sql = "SELECT * FROM Content WHERE UserId='$uploadedBy' ORDER BY Date DESC LIMIT $index,$maxIndex";
	}
	elseif (!empty($contentId)){
		$sql = "SELECT * FROM Content WHERE ContentId='$contentId' LIMIT 1";
	}
	
	$result = mysqli_query($dbConn, $sql);

	$combinedContent = array();
	
	if ($result != false && mysqli_num_rows($result) > 0){
		while ($rows = mysqli_fetch_assoc($result)){
			$rows["UserName"] = getAccountName($dbConn, $rows["UserId"]);
			if (isset($UserId)){
				$rows["IsFollowing"] = getIsFollowing($dbConn, $UserId, $rows["UserId"]);
				if (empty($searchCategory) || $searchCategory != "User"){
					$rows["IsLiked"] = getIsLiked($dbConn, $UserId, $rows["ContentId"]);
				}
			}
			
			array_push($combinedContent, $rows);
		}
	}
	echo json_encode($combinedContent);	
	
	mysqli_close($dbConn);	
?>