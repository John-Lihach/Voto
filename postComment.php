<?php
	
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "Voto";
	
	$dbConn = mysqli_connect($host, $user, $pass, $db);

	$token = $_POST['token'];
	$commentText = $_POST['commentTextArea'];
	$contentId = $_POST['contentId'];
	
	function getUserIdFromToken($dbConn, $token){
		$idSql = "SELECT UserId FROM Token WHERE TokenKey='$token' LIMIT 1";
		$idResult = mysqli_query($dbConn, $idSql);
		while ($rows = mysqli_fetch_assoc($idResult)){
			return $rows["UserId"];
		}
		return false;
	}
	
	function getAccountName($dbConn, $userId){
		$nameSql = "SELECT Name FROM User WHERE UserId='$userId' LIMIT 1";
		$nameResult = mysqli_query($dbConn, $nameSql);
		while ($rows = mysqli_fetch_assoc($nameResult)){
			return $rows["Name"];
		}
	}
	
	$UserId = getUserIdFromToken($dbConn, $token);
	if ($UserId != false){
		$sql = "INSERT INTO Comments(UserId, ContentId, CommentText) VALUES ('$UserId', '$contentId', '$commentText')";
					
		mysqli_query($dbConn, $sql);
		
		$responseObject = ["UserName" => getAccountName($dbConn, $UserId), "CommentText" => $commentText];
		
		echo json_encode($responseObject);
	}

	
	mysqli_close($dbConn);	
?>