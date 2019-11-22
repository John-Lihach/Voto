<html>

<head>
	<link rel="stylesheet" type="text/css" href="stylesheet.css">
	<link rel="stylesheet" type="text/css" href="accountStylesheet.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<style>
		#accountLink{
			border-left: 5px solid white;
			font-weight: bold;
		}
		#contentFeed{
			max-height: 35em;
		}
	</style>
</head>

<body>
	<?php include('header.php')?>
	
	<div id="contentContainer">
		<div class="contentSide">
			<h1 id="accountTitle">Your Account</h1>
			<h2>Upload Content</h2>
			<div id="uploadArea">
				<form id="fileUploadForm" action="yourAccount.php" method="POST" enctype="multipart/form-data">
					<h3>Title</h3>
					<div class="inputContainer" id="titleInput">
						<input type="text" name="titleInput" />
					</div>
					<br/>
					<h3>File</h3>
					<input type="file" name="fileInput" id="fileInput" />
					<br/>
					<input type="text" id="sessionTokenInput" name="sessionTokenInput" style="display:none" />
					<input type="submit" value="Submit" class="submitButton" name="submit"/>
				</form>
				<?php
					if (isset($_POST['submit'])){
						$targetDirectory = "uploads/";
						$targetFile = $targetDirectory . basename($_FILES["fileInput"]["name"]);
						$accepted = true;
						$imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
						
						if($_FILES["fileInput"]["size"] > 2000000){
							$accepted = false;
							echo("File is too large - 2mb limit.");
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
								return false;
							}
							
							$ContentId = md5(random_bytes(32));
							$Name = $_POST["titleInput"];
							$UserId = getUserIdFromToken($dbConn, $_POST["sessionTokenInput"]);
							if ($UserId == false){
								echo("You're not logged in!");
							}
							else{
								$sql = "INSERT INTO Content(ContentId, UserId, Name, Type, Likes) VALUES ('$ContentId', '$UserId', '$Name', '$imageFileType', '0')";
												
								mysqli_query($dbConn, $sql);
								
								if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetDirectory.$ContentId.".".$imageFileType)){
									echo("File successfully uploaded.");
								}
								else{
									echo("Something went wrong! File was not uploaded.");
								}
							}
						}
						
					}
				?>
			</div>
		</div>
		
		<div class="contentSide">
			<h2>Posted Content</h2>
			<div id="contentFeed" class="contentSection">
			</div>
		</div>
	</div>
	
	<script src="headerScript.js"></script>
	<script src="feedScript.js"></script>
	<script>
		document.body.onload = function(){
			setMenuSize();
			checkForToken();
			var tokenInput = document.getElementById("sessionTokenInput");
			tokenInput.value = sessionToken;
			getFeed(true, null, null, null, "self");
		}
		
		var contentFeed = document.getElementById("contentFeed");
		var debounce;
		contentFeed.onscroll = function(){
			if (!debounce && contentFeed.scrollTop >= (contentFeed.scrollHeight - contentFeed.offsetHeight)){
				debounce = true
				getFeed(true, null, null, null, "self");
				setTimeout(function(){
					debounce = false;
				}, 1000);
			}
		}
	</script>
	
</body>

</html>