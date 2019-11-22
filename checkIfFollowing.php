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
	
	$token = $_POST['token'];
	$userId = getUserIdFromToken($dbConn, $token);
	$followingUserName = $_POST['followingUserName'];
	$followingUserId = getUserIdFromName($dbConn, $followingUserName);
	
	$followSql = "SELECT UserId FROM Following WHERE UserId='$userId' AND FollowingUserId='$followingUserId' LIMIT 1";
	$followResult = mysqli_query($dbConn, $followSql);
	
	if (mysqli_num_rows($followResult) > 0){
		echo(json_encode(true));
	}
	else{
		echo(json_encode(false));
	}
	
	mysqli_close($dbConn);	
?>