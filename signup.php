<?php
	function checkUsernameCollision($dbConn, $username){
		$sql = "SELECT Name FROM User WHERE Name='$username' LIMIT 1";
		$result = mysqli_query($dbConn, $sql);
		
		if (mysqli_num_rows($result) > 0){
			return false;
		}
		return true;
	}
	
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "Voto";
	
	$dbConn = mysqli_connect($host, $user, $pass, $db);

	$username = $_POST['username'];
	$password = $_POST['password'];
	
	$success = checkUsernameCollision($dbConn, $username);
	
	if ($success){
		$passwordHash = password_hash($password, PASSWORD_DEFAULT);
		$sql = "INSERT INTO User(Name, PasswordHash) VALUES ('$username', '$passwordHash')";
					
		mysqli_query($dbConn, $sql);
		
		echo json_encode(true);
	}
	else{
		echo json_encode(false);
	}
	
	mysqli_close($dbConn);	
?>