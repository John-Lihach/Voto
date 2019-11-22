<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "Voto";
	
	$dbConn = mysqli_connect($host, $user, $pass, $db);
	
	function getUserIdFromName($dbConn, $userName){
		$idSql = "SELECT UserId FROM User WHERE Name='$userName' LIMIT 1";
		$idResult = mysqli_query($dbConn, $idSql);
		while ($rows = mysqli_fetch_assoc($idResult)){
			return $rows["UserId"];
		}
	}
	
	function getUserIdFromToken($dbConn, $token){
		$idSql = "SELECT UserId FROM Token WHERE TokenKey='$token' LIMIT 1";
		$idResult = mysqli_query($dbConn, $idSql);
		while ($rows = mysqli_fetch_assoc($idResult)){
			return $rows["UserId"];
		}
	}
	
	$action = $_POST['action'];
	$token = $_POST['token'];
	$userId = getUserIdFromToken($dbConn, $token);
	$followingUserName;
	if (isset($_POST['followingUserName'])){
		$followingUserName = $_POST['followingUserName'];
	}
	$contentId;
	if (isset($_POST['contentId'])){
		$contentId = $_POST['contentId'];	
	}
	
	$sql;
	
	if (!empty($followingUserName)){
		$followingUserId = getUserIdFromName($dbConn, $followingUserName);
		$followSql = "SELECT UserId FROM Following WHERE UserId='$userId' AND FollowingUserId='$followingUserId' LIMIT 1";
		$followResult = mysqli_query($dbConn, $followSql);
		if (mysqli_num_rows($followResult) > 0){
			$sql = "DELETE FROM Following WHERE UserId='$userId' AND FollowingUserId='$followingUserId' LIMIT 1";
		}
		else{
			$sql = "INSERT INTO Following(UserId, FollowingUserId) VALUES ('$userId', '$followingUserId')";
		}		
	}
	elseif (!empty($contentId)){
		$likedSql = "SELECT UserId FROM Likes WHERE UserId='$userId' AND ContentId='$contentId' LIMIT 1";
		$likedResult = mysqli_query($dbConn, $likedSql);
		if (mysqli_num_rows($likedResult) > 0){
			$sql = "DELETE FROM Likes WHERE UserId='$userId' AND ContentId='$contentId' LIMIT 1";
			mysqli_query($dbConn, $sql);
			$sql = "UPDATE Content SET Likes=Likes-1 WHERE ContentId='$contentId'";
		}
		else{
			$sql = "INSERT INTO Likes(UserId, ContentId) VALUES ('$userId', '$contentId')";
			mysqli_query($dbConn, $sql);
			$sql = "UPDATE Content SET Likes=Likes+1 WHERE ContentId='$contentId'";
		}		
	}
	
	mysqli_query($dbConn, $sql);

	echo json_encode(true);
	
	mysqli_close($dbConn);	
?>