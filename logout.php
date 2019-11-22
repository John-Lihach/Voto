<?php
	$host = "localhost";
	$user = "root";
	$password = "";
	$db = "Voto";
	
	$dbConn = mysqli_connect($host, $user, $password, $db);

	$token = $_POST['token'];

	$sql = "DELETE FROM Token WHERE TokenKey='$token'";	
	
	mysqli_query($dbConn, $sql);
	
	mysqli_close($dbConn);	
?>