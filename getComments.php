<?php	
	$host = "localhost";
	$user = "root";
	$password = "";
	$db = "Voto";
	
	$dbConn = mysqli_connect($host, $user, $password, $db);
		
	function getAccountName($dbConn, $userId){
		$nameSql = "SELECT Name FROM User WHERE UserId='$userId' LIMIT 1";
		$nameResult = mysqli_query($dbConn, $nameSql);
		
		while ($rows = mysqli_fetch_assoc($nameResult)){
			return $rows["Name"];
		}
	}
	
	$contentId = $_POST['contentId'];	
	
	$sql = "SELECT * FROM Comments WHERE ContentId='$contentId'";
	
	$result = mysqli_query($dbConn, $sql);

	$combinedContent = array();	
	
	while ($rows = mysqli_fetch_assoc($result)){
		$rows["UserName"] = getAccountName($dbConn, $rows["UserId"]);
		
		array_push($combinedContent, $rows);
	}
	echo json_encode($combinedContent);	
	
	mysqli_close($dbConn);	
?>