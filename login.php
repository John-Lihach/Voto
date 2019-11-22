<?php
	function generateToken($dbConn, $UserId){
		$token = md5(random_bytes(32));
		
		$tokenSql = "SELECT UserId FROM Token WHERE UserId='$UserId' LIMIT 1";
		$tokenResult = mysqli_query($dbConn, $tokenSql);
		if (mysqli_num_rows($tokenResult) > 0){
			$tokenSql = "UPDATE Token SET TokenKey='$token' WHERE UserId='$UserId'";
		}
		else{
			$tokenSql = "INSERT INTO Token(TokenKey, UserId) VALUES ('$token', '$UserId')";
		}		
		mysqli_query($dbConn, $tokenSql);
		
		return $token;
	}
	
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "Voto";
	
	$dbConn = mysqli_connect($host, $user, $pass, $db);

	$username = $_POST['username'];
	$password = $_POST['password'];

	$sql = "SELECT * FROM User WHERE Name='$username'";	
	
	$result = mysqli_query($dbConn, $sql);
	
	if (mysqli_num_rows($result) == 1){
		$rows = mysqli_fetch_assoc($result);
		$success = password_verify($password, $rows['PasswordHash']);
		if ($success){
			$token = generateToken($dbConn, $rows['UserId']);
			$responseObject = ["success" => true, "token" => $token];
			echo json_encode($responseObject);
		}
		else{
			$responseObject = ["success" => false];
			echo json_encode($responseObject);
		}	
	}
	else{
		$responseObject = ["success" => false];
		echo json_encode($responseObject);
	}
	
	mysqli_close($dbConn);	
?>