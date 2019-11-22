<?php
if (isset($_POST['submit'])){
	$targetDirectory = "uploads/";
	$targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
	$accepted = true;
	$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
	
	$check = getimagesize($_FILES["fileInput"]["tmp_Name"]);
	if ($check == false){
		$accepted = false;
		echo("File is not an image!");
	}
	
	if($_FILES["fileInput"]["size"] > 2000000){
		$accepted = false;
		echo("File is too large - 2mb limit");
	}
	
	if($imageFileType != "jpg" && $imageFileType != "jpeg" &&  $imageFileType != "png" &&  $imageFileType != "gif" && $imageFileType != "mp4"){
		$accepted = false;
		echo("File type is not supported - accepted formats: jpg, jpeg, png, gif, mp4.");
	}
	
	if ($accepted){
		$host = "localhost";
		$user = "root";
		$pass = "";
		$db = "Voto";
		
		$dbConn = mysqli_connect($host, $user, $pass, $db);

		function getUserIdFromToken($dbConn, $token){
			$idSql = "SELECT UserId FROM Token WHERE TokenKey='$token' LIMIT 1";
			$idResult = mysqli_query($dbConn, $idSql);
			while ($rows = mysqli_fetch_assoc($idResult)){
				return $rows["UserId"];
			}
		}
		$UserId = ;
		$Name = $_POST["titleInput"];

		$sql = "INSERT INTO Content(UserId, Name, Type, Likes) VALUES ('$UserId', '$Name', '$imageFileType', '0')";
						
		mysqli_query($dbConn, $sql);
		
		if (move_uploaded_file($_FILES["fileInput"]["tmp_Name"], $targetFile)){
	
		}
		else{
			echo("Something went wrong! File was not uploaded");
		}
	}
	
}
?>